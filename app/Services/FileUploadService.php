<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload a file to the specified path.
     *
     * @param UploadedFile $file
     * @param string $path
     * @return string
     */
    public function upload(UploadedFile $file, string $path = 'uploads'): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/' . $path, $filename);
        return 'storage/' . $path . '/' . $filename;
    }

    /**
     * Upload multiple files.
     *
     * @param array $files
     * @param string $path
     * @return array
     */
    public function uploadMultiple(array $files, string $path = 'uploads'): array
    {
        $paths = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $paths[] = $this->upload($file, $path);
            }
        }
        return $paths;
    }
    
    /**
     * Delete a file.
     * 
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool 
    {
        // Convert public url to storage path
        $relativePath = str_replace('storage/', 'public/', $path);
        if (Storage::exists($relativePath)) {
            return Storage::delete($relativePath);
        }
        return false;
    }
}
