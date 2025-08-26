<?php
namespace App\Http\Controllers;

use App\Models\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\Backup\BackupDestination\Backup as SpatieBackup;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Backup::latest()->get();
        return view('backups.index', compact('backups'));
    }

    public function create()
    {
        try {
            // Run backup command
            Artisan::call('backup:run', ['--only-db' => true]);
            
            // Get the latest backup file from the backups disk
            $backupFiles = Storage::disk('backups')->files(config('backup.backup.name'));
            
            if (count($backupFiles) > 0) {
                // Get the latest file
                $latestBackup = last($backupFiles);
                $size = Storage::disk('backups')->size($latestBackup);
                
                // Save backup info to database
                $backup = Backup::create([
                    'name' => basename($latestBackup),
                    'path' => $latestBackup,
                    'size' => $size,
                    'status' => 'completed'
                ]);
                
                return redirect()->route('backups.index')
                    ->with('success', 'Backup created successfully.');
            }
            
            return redirect()->route('backups.index')
                ->with('error', 'Backup failed. No backup file was created.');
                
        } catch (\Exception $e) {
            Backup::create([
                'name' => 'backup_' . now()->format('Y-m-d_H-i-s'),
                'path' => '',
                'status' => 'failed',
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('backups.index')
                ->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        $backup = Backup::findOrFail($id);
        
        if (!Storage::disk('backups')->exists($backup->path)) {
            return redirect()->route('backups.index')
                ->with('error', 'Backup file not found.');
        }

        return Storage::disk('backups')->download($backup->path);
    }

    public function destroy($id)
    {
        $backup = Backup::findOrFail($id);
        
        try {
            // Delete from storage
            if (Storage::disk('backups')->exists($backup->path)) {
                Storage::disk('backups')->delete($backup->path);
            }
            
            // Delete from database
            $backup->delete();
            
            return redirect()->route('backups.index')
                ->with('success', 'Backup deleted successfully.');
                
        } catch (\Exception $e) {
            return redirect()->route('backups.index')
                ->with('error', 'Failed to delete backup: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        $backup = Backup::findOrFail($id);
        
        try {
            // Run restore command
            Artisan::call('backup:restore', [
                '--backup' => $backup->name,
                '--force' => true
            ]);
            
            return redirect()->route('backups.index')
                ->with('success', 'Database restored successfully from backup.');
                
        } catch (\Exception $e) {
            return redirect()->route('backups.index')
                ->with('error', 'Restore failed: ' . $e->getMessage());
        }
    }
}