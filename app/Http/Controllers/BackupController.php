<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use App\Services\BackupService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB; 
use Exception;

class BackupController extends Controller implements HasMiddleware
{
    protected $backupService;
    
    public function __construct(BackupService $backupService)
    {
        $this->backupService = $backupService;
    }
    
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view backups', only: ['index']),
            new Middleware('permission:create backups', only: ['create', 'store']),
            new Middleware('permission:download backups', only: ['download']),
            new Middleware('permission:delete backups', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Backup::query();

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%")
                        ->orWhere('status', 'like', "%$search%");
                    });
                }

                // Sorting
                $this->applySorting($query, $request);

                // Pagination
                $perPage = $request->input('perPage', 10);
                $backups = $query->paginate($perPage);

                // DEBUG: Log the raw backup data
                Log::debug('Raw backup data:', [
                    'backups' => $backups->getCollection()->toArray(),
                    'count' => $backups->count()
                ]);

                $transformedBackups = $backups->getCollection()->map(function ($backup) {
                    // DEBUG: Log each backup's status
                    Log::debug('Backup status check:', [
                        'id' => $backup->id,
                        'name' => $backup->name,
                        'raw_status' => $backup->status,
                        'includes_completed' => str_contains($backup->status, 'completed'),
                        'size' => $backup->size,
                        'formatted_size' => $this->formatSize($backup->size)
                    ]);

                    return [
                        'id' => $backup->id,
                        'name' => $backup->name,
                        'size' => $this->formatSize($backup->size),
                        'status' => $backup->status, // Return raw status for JavaScript checking
                        'created_at' => $backup->created_at->format('d M, Y H:i:s'),
                        'download_url' => route('backups.download', $backup->id),
                    ];
                });

                return response()->json([
                    'data' => $transformedBackups,
                    'current_page' => $backups->currentPage(),
                    'last_page' => $backups->lastPage(),
                    'from' => $backups->firstItem(),
                    'to' => $backups->lastItem(),
                    'total' => $backups->total(),
                ]);
            }

            return view('backups.list');

        } catch (\Exception $e) {
            Log::error('Backup index error: ' . $e->getMessage());
            
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load backups'], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('error', 'Failed to load backups. Please try again.');
        }
    }

    public function create()
    {
        try {
            // Get database size estimation
            $database = config('database.connections.mysql.database');
            $dbSize = 0;
            
            try {
                $result = DB::select("
                    SELECT SUM(data_length + index_length) / 1024 AS size
                    FROM information_schema.TABLES 
                    WHERE table_schema = ?
                    GROUP BY table_schema
                ", [$database]);
                
                $dbSize = $result[0]->size ?? 0;
            } catch (\Exception $e) {
                Log::error('Database size estimation error: ' . $e->getMessage());
                // If we can't get the actual size, provide a default message
                $dbSize = 'unknown (estimation failed)';
            }
            
            return view('backups.create', compact('dbSize'));
        } catch (\Exception $e) {
            Log::error('Backup create form error: ' . $e->getMessage());
            return redirect()->route('backups.index')
                ->with('error', 'Failed to load backup creation form. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $backup = $this->backupService->createBackup();
            
            return redirect()->route('backups.index')
                ->with('success', 'Backup created successfully: ' . $backup->name);

        } catch (\Exception $e) {
            Log::error('Backup store error: ' . $e->getMessage());
            return redirect()->route('backups.create')
                ->withInput()
                ->with('error', 'Failed to create backup. Please try again. Error: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        try {
            $backup = Backup::findOrFail($id);
            return $this->backupService->downloadBackup($backup);
            
        } catch (\Exception $e) {
            Log::error('Backup download error: ' . $e->getMessage());
            return redirect()->route('backups.index')
                ->with('error', 'Failed to download backup. Error: ' . $e->getMessage());
        }
    }

public function destroy(Backup $backup)
{
    try {
        $this->backupService->deleteBackup($backup);

        if (request()->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Backup deleted successfully.'
            ]);
        }

        return redirect()->route('backups.index')
            ->with('success', 'Backup deleted successfully.');

    } catch (\Exception $e) {
        Log::error("Backup deletion error for ID {$backup->id}: " . $e->getMessage());
        
        if (request()->ajax()) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete backup. Please try again.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        return redirect()->route('backups.index')
            ->with('error', 'Failed to delete backup. Please try again.');
    }
}

    public function cleanup(Request $request)
    {
        try {
            $days = $request->input('days', 30);
            $deletedCount = $this->backupService->cleanupOldBackups($days);
            
            return redirect()->route('backups.index')
                ->with('success', "Cleaned up $deletedCount old backup(s).");

        } catch (\Exception $e) {
            Log::error('Backup cleanup error: ' . $e->getMessage());
            return redirect()->route('backups.index')
                ->with('error', 'Failed to cleanup old backups. Error: ' . $e->getMessage());
        }
    }

    /**
     * Apply sorting to the query
     */
    protected function applySorting($query, Request $request): void
    {
        $sort = $request->sort ?? 'created_at';
        $direction = in_array(strtolower($request->direction ?? 'desc'), ['asc', 'desc']) 
            ? $request->direction 
            : 'desc';

        switch ($sort) {
            case 'name':
                $query->orderBy('name', $direction);
                break;
                
            case 'size':
                $query->orderBy('size', $direction);
                break;
                
            case 'status':
                $query->orderBy('status', $direction);
                break;
                
            case 'created_at':
                $query->orderBy('created_at', $direction);
                break;
                
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    }

    /**
     * Format file size for display
     */
    protected function formatSize($bytes): string
    {
        if ($bytes === null) return 'N/A';
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Format status with badge
     */
    protected function formatStatus($status): string
    {
        $statusClasses = [
            'completed' => 'bg-green-100 text-green-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'failed' => 'bg-red-100 text-red-800',
        ];
        
        $class = $statusClasses[$status] ?? 'bg-gray-100 text-gray-800';
        
        return '<span class="text-xs font-medium px-2.5 py-0.5 rounded ' . $class . '">' . 
               ucfirst($status) . '</span>';
    }


}