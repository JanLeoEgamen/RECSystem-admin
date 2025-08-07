<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Activity::with('causer')
                ->orderBy('created_at', 'desc')
                ->where(function($q) {
                    $q->where('log_name', 'not like', '%authentication%')
                    ->where('description', 'not like', '%authentication%');
                });

            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('log_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('causer', function($q) use ($search) {
                        $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
                });
            }

            $activities = $query->paginate(20);

            // Format the properties for display
            $activities->getCollection()->transform(function ($activity) {
                $activity->formatted_properties = $this->formatProperties($activity->properties);
                return $activity;
            });

            // PDF Export
            if ($request->has('export') && $request->export === 'pdf') {
                $exportActivities = $query->get();
                $exportActivities->transform(function ($activity) {
                    $activity->formatted_properties = $this->formatProperties($activity->properties);
                    return $activity;
                });

                return $this->generatePdf($exportActivities, $request->input('search'));
            }

            return view('activity-logs.list', [
                'activities' => $activities,
                'search' => $request->input('search')
            ]);

        } catch (QueryException $e) {
            Log::error('Activity log query error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was a problem retrieving activity logs. Please try again.');
            
        } catch (\Exception $e) {
            Log::error('Activity log error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred while loading activity logs.');
        }
    }

    public function indexTable(Request $request)
    {
        try {
            $query = Activity::with('causer')
                ->orderBy('created_at', 'desc')
                ->where(function($q) {
                    $q->where('log_name', 'not like', '%authentication%')
                    ->where('description', 'not like', '%authentication%');
                });

            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('log_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('causer', function($q) use ($search) {
                        $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
                });
            }

            $activities = $query->paginate(10);

            // Format the properties for display
            $activities->getCollection()->transform(function ($activity) {
                $activity->formatted_properties = $this->formatProperties($activity->properties);
                return $activity;
            });

            // PDF Export
            if ($request->has('export') && $request->export === 'pdf') {
                $exportActivities = $query->get();
                $exportActivities->transform(function ($activity) {
                    $activity->formatted_properties = $this->formatProperties($activity->properties);
                    return $activity;
                });

                return $this->generatePdf($exportActivities, $request->input('search'));
            }

            return view('activity-logs.list-table', [
                'activities' => $activities,
                'search' => $request->input('search')
            ]);

        } catch (QueryException $e) {
            Log::error('Activity log table query error: ' . $e->getMessage());
            return response()->json([
                'error' => 'There was a problem retrieving activity logs.'
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('Activity log table error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An unexpected error occurred while loading activity logs.'
            ], 500);
        }
    }

    protected function generatePdf($activities, $searchTerm = null)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        
        $dompdf = new Dompdf($options);
        
        $html = view('activity-logs.export-pdf', [
            'activities' => $activities,
            'searchTerm' => $searchTerm,
            'totalActivities' => $activities->count(),
            'currentDate' => now()->format('Y-m-d H:i:s'),
        ])->render();
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        return $dompdf->stream("activity_logs_report_".now()->format('Y-m-d').".pdf");
    }

    protected function formatProperties($properties)
    {
        try {
            if (!$properties) {
                return [[
                    'field' => 'Data',
                    'value' => '(empty)'
                ]];
            }

            $props = $properties->toArray();
            
            if (isset($props['attributes']) || isset($props['old'])) {
                $oldValues = $props['old'] ?? [];
                $newValues = $props['attributes'] ?? [];
                
                $formatted = [];
                $allKeys = array_unique(array_merge(array_keys($oldValues), array_keys($newValues)));
                
                foreach ($allKeys as $key) {
                    try {
                        $formatted[] = [
                            'field' => $this->formatFieldName($key),
                            'old' => $this->formatValue($oldValues[$key] ?? null),
                            'new' => $this->formatValue($newValues[$key] ?? null),
                            'value' => $this->formatValue($newValues[$key] ?? $oldValues[$key] ?? null)
                        ];
                    } catch (\Exception $e) {
                        // Log error for specific field formatting
                        Log::warning("Failed to format property field: {$key}", [
                            'error' => $e->getMessage(),
                            'oldValue' => $oldValues[$key] ?? null,
                            'newValue' => $newValues[$key] ?? null
                        ]);
                        
                        // Still include the field with error indication
                        $formatted[] = [
                            'field' => $this->formatFieldName($key),
                            'old' => '(format error)',
                            'new' => '(format error)',
                            'value' => '(format error)'
                        ];
                    }
                }
                
                return $formatted;
            }
            
            // For other log types
            return [[
                'field' => 'Data',
                'value' => $this->formatValue($props)
            ]];

        } catch (\Exception $e) {
            Log::error('Failed to format activity properties', [
                'error' => $e->getMessage(),
                'properties' => $properties
            ]);
            
            return [[
                'field' => 'Data',
                'value' => '(formatting error)'
            ]];
        }
    }

    protected function formatValue($value)
    {
        try {
            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            }
            
            if (is_array($value) || is_object($value)) {
                return json_encode($value, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            }
            
            if (is_null($value)) {
                return '(empty)';
            }
            
            if (is_string($value) && trim($value) === '') {
                return '(empty string)';
            }
            
            return $value;
        } catch (\Exception $e) {
            Log::warning('Failed to format value', [
                'error' => $e->getMessage(),
                'value' => $value
            ]);
            return '(format error)';
        }
    }

    protected function formatFieldName(string $key): string
    {
        return ucfirst(str_replace(['_', '-'], ' ', $key));
    }

}