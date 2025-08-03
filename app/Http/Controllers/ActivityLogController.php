<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Dompdf\Dompdf;
use Dompdf\Options;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer')
            ->orderBy('created_at', 'desc');

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
            // Get all activities without pagination for the export
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
        $props = $properties->toArray();
        
        // If it's a standard model update/create log
        if (isset($props['attributes']) || isset($props['old'])) {
            $oldValues = $props['old'] ?? [];
            $newValues = $props['attributes'] ?? [];
            
            $formatted = [];
            $allKeys = array_unique(array_merge(array_keys($oldValues), array_keys($newValues)));
            
            foreach ($allKeys as $key) {
                $oldValue = $oldValues[$key] ?? null;
                $newValue = $newValues[$key] ?? null;
                
                // Skip if both values are empty
                if (is_null($oldValue) && is_null($newValue)) {
                    continue;
                }
                
                // Format the values
                $formatted[] = [
                    'field' => ucfirst(str_replace('_', ' ', $key)),
                    'old' => $this->formatValue($oldValue),
                    'new' => $this->formatValue($newValue)
                ];
            }
            
            return $formatted;
        }
        
        // Fallback for other log types
        return ['raw' => json_encode($props, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)];
    }

    protected function formatValue($value)
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        
        if (is_array($value)) {
            return json_encode($value);
        }
        
        if (is_null($value)) {
            return '(empty)';
        }
        
        return $value;
    }
}