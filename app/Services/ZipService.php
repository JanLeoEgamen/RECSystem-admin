<?php

namespace App\Services;

use ZipArchive;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ZipService
{
    protected const DEFAULT_PASSWORD = '@recdb09';
    
    /**
     * Create a password-protected ZIP file containing the backup file
     * 
     * @param string $filePath Path to the file to be zipped
     * @param string $fileName Original filename  
     * @param string|null $password Optional password (defaults to @recdb09)
     * @return string Path to the created ZIP file
     * @throws Exception
     */
    public function createPasswordProtectedZip(string $filePath, string $fileName, ?string $password = null): string
    {
        if (!Storage::disk('public')->exists($filePath)) {
            throw new Exception('Source file not found: ' . $filePath);
        }
        
        $password = $password ?? self::DEFAULT_PASSWORD;
        
        // Create ZIP filename
        $zipFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.zip';
        $zipPath = dirname($filePath) . '/' . $zipFileName;
        $fullZipPath = Storage::disk('public')->path($zipPath);
        
        // Ensure directory exists
        $directory = dirname($fullZipPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // Get the full path to the source file
        $fullSourcePath = Storage::disk('public')->path($filePath);
        
        // Create ZIP archive
        $zip = new ZipArchive();
        $result = $zip->open($fullZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        if ($result !== TRUE) {
            throw new Exception('Cannot create ZIP file. Error code: ' . $result);
        }
        
        try {
            // Add the backup file to the ZIP
            if (!$zip->addFile($fullSourcePath, $fileName)) {
                throw new Exception('Failed to add file to ZIP archive');
            }
            
            // Set password protection
            if (!$zip->setPassword($password)) {
                throw new Exception('Failed to set password for ZIP archive');
            }
            
            // Enable encryption for the file
            if (!$zip->setEncryptionName($fileName, ZipArchive::EM_AES_256)) {
                throw new Exception('Failed to set encryption for file in ZIP archive');
            }
            
            // Close the ZIP file
            if (!$zip->close()) {
                throw new Exception('Failed to close ZIP archive');
            }
            
            Log::info('Password-protected ZIP created successfully', [
                'zip_path' => $zipPath,
                'original_file' => $filePath,
                'zip_size' => filesize($fullZipPath)
            ]);
            
            return $zipPath;
            
        } catch (Exception $e) {
            $zip->close();
            
            // Clean up partial ZIP file if it exists
            if (file_exists($fullZipPath)) {
                unlink($fullZipPath);
            }
            
            throw $e;
        }
    }
    
    /**
     * Create a temporary password-protected ZIP file for download
     * Returns the full system path to the ZIP file that should be deleted after download
     * 
     * @param string $filePath Path to the file to be zipped
     * @param string $fileName Original filename
     * @param string|null $password Optional password
     * @return string Full system path to the ZIP file
     * @throws Exception
     */
    public function createTemporaryPasswordProtectedZip(string $filePath, string $fileName, ?string $password = null): string
    {
        if (!Storage::disk('public')->exists($filePath)) {
            throw new Exception('Source file not found: ' . $filePath);
        }
        
        $password = $password ?? self::DEFAULT_PASSWORD;
        
        // Create temporary ZIP file in system temp directory
        $tempDir = sys_get_temp_dir();
        $zipFileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . time() . '.zip';
        $tempZipPath = $tempDir . DIRECTORY_SEPARATOR . $zipFileName;
        
        // Get the full path to the source file
        $fullSourcePath = Storage::disk('public')->path($filePath);
        
        // Create ZIP archive
        $zip = new ZipArchive();
        $result = $zip->open($tempZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        if ($result !== TRUE) {
            throw new Exception('Cannot create temporary ZIP file. Error code: ' . $result);
        }
        
        try {
            // Add the backup file to the ZIP
            if (!$zip->addFile($fullSourcePath, $fileName)) {
                throw new Exception('Failed to add file to temporary ZIP archive');
            }
            
            // Set password protection
            if (!$zip->setPassword($password)) {
                throw new Exception('Failed to set password for temporary ZIP archive');
            }
            
            // Enable encryption for the file
            if (!$zip->setEncryptionName($fileName, ZipArchive::EM_AES_256)) {
                throw new Exception('Failed to set encryption for file in temporary ZIP archive');
            }
            
            // Close the ZIP file
            if (!$zip->close()) {
                throw new Exception('Failed to close temporary ZIP archive');
            }
            
            Log::info('Temporary password-protected ZIP created successfully', [
                'temp_zip_path' => $tempZipPath,
                'original_file' => $filePath,
                'zip_size' => filesize($tempZipPath)
            ]);
            
            return $tempZipPath;
            
        } catch (Exception $e) {
            $zip->close();
            
            // Clean up partial ZIP file if it exists
            if (file_exists($tempZipPath)) {
                unlink($tempZipPath);
            }
            
            throw $e;
        }
    }
    
    /**
     * Clean up temporary ZIP file
     * 
     * @param string $zipPath Full path to the ZIP file
     * @return bool
     */
    public function cleanupTemporaryZip(string $zipPath): bool
    {
        if (file_exists($zipPath)) {
            return unlink($zipPath);
        }
        
        return true;
    }
    
    /**
     * Get the default password used for ZIP protection
     * 
     * @return string
     */
    public static function getDefaultPassword(): string
    {
        return self::DEFAULT_PASSWORD;
    }
}