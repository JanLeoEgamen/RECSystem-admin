<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Dompdf\Dompdf;
use Dompdf\Options;

class LoginLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer')
            ->where('log_name', 'authentication')
            ->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('causer', function($q) use ($search) {
                      $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by login type if needed
        if ($request->has('login_type')) {
            $query->where('description', $request->input('login_type'));
        }

        $logs = $query->paginate(20);

        // Format the properties for display
        $logs->getCollection()->transform(function ($log) {
            $log->formatted_properties = $this->formatLoginProperties($log->properties);
            return $log;
        });

        // PDF Export
        if ($request->has('export') && $request->export === 'pdf') {
            $exportLogs = $query->get();
            $exportLogs->transform(function ($log) {
                $log->formatted_properties = $this->formatLoginProperties($log->properties);
                return $log;
            });

            return $this->generatePdf($exportLogs, $request->input('search'));
        }

        return view('login-logs.list', [
            'logs' => $logs,
            'search' => $request->input('search')
        ]);
    }

    public function indexTable(Request $request)
    {
        $query = Activity::with('causer')
            ->where('log_name', 'authentication')
            ->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('causer', function($q) use ($search) {
                      $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by login type if needed
        if ($request->has('login_type')) {
            $query->where('description', $request->input('login_type'));
        }

        $logs = $query->paginate(20);

        // Format the properties for display
        $logs->getCollection()->transform(function ($log) {
            $log->formatted_properties = $this->formatLoginProperties($log->properties);
            return $log;
        });

        // PDF Export
        if ($request->has('export') && $request->export === 'pdf') {
            $exportLogs = $query->get();
            $exportLogs->transform(function ($log) {
                $log->formatted_properties = $this->formatLoginProperties($log->properties);
                return $log;
            });

            return $this->generatePdf($exportLogs, $request->input('search'));
        }

        return view('login-logs.list-table', [
            'logs' => $logs,
            'search' => $request->input('search')
        ]);
    }

    protected function generatePdf($logs, $searchTerm = null)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');
        
        $dompdf = new Dompdf($options);
        
        $html = view('login-logs.export-pdf', [
            'logs' => $logs,
            'searchTerm' => $searchTerm,
            'totalLogs' => $logs->count(),
            'currentDate' => now()->format('Y-m-d H:i:s'),
        ])->render();
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Changed to landscape for better table layout
        $dompdf->render();
        
        // Add page numbers
        $canvas = $dompdf->getCanvas();
        $font = $dompdf->getFontMetrics()->getFont('DejaVu Sans');
        $canvas->page_text(540, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
        
        return $dompdf->stream("login_logs_report_".now()->format('Y-m-d').".pdf");
    }

    protected function formatLoginProperties($properties)
    {
        $props = $properties->toArray();
        
        $formatted = [];
        
        if (isset($props['ip_address'])) {
            $formatted[] = [
                'field' => 'IP Address',
                'value' => $props['ip_address'] ?? '(unknown)'
            ];
        }
        
        if (isset($props['user_agent'])) {
            $formatted[] = [
                'field' => 'User Agent',
                'value' => $props['user_agent'] ?? '(unknown)'
            ];
        }
        
        if (isset($props['login_time'])) {
            $formatted[] = [
                'field' => 'Login Time',
                'value' => $props['login_time']
            ];
        }
        
        if (isset($props['logout_time'])) {
            $formatted[] = [
                'field' => 'Logout Time',
                'value' => $props['logout_time']
            ];
        }
        
        if (isset($props['status'])) {
            $formatted[] = [
                'field' => 'Status',
                'value' => $props['status']
            ];
        }
        
        return $formatted;
    }

    public function export(Request $request)
    {
        $query = Activity::with('causer')
            ->where('log_name', 'authentication')
            ->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                ->orWhereHas('causer', function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
            });
        }

        if ($request->has('login_type')) {
            $query->where('description', $request->input('login_type'));
        }

        $exportLogs = $query->get();
        $exportLogs->transform(function ($log) {
            $log->formatted_properties = $this->formatLoginProperties($log->properties);
            return $log;
        });

        return $this->generatePdf($exportLogs, $request->input('search'));
    }
}