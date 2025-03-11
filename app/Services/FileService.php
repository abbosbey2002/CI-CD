<?php


namespace App\Services;


use Illuminate\Http\UploadedFile;
use App\Models\File;

class FileService
{

    public function getAllFiles()
    {
        return File::all(['title', 'file', 'type', 'last_update', 'id']);
    }

    public function getFileById($id)
    {
    }

    public function createFile(UploadedFile $file, $title): string
    {

        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('files', $filename, 'public');
        File::updateOrCreate(
            [ 'type' => $title ],
            [
            'title' => $filename,
            'file' => $filePath,
        ]);

        return $filePath;
    }

    public function updateFile($id, array $data)
    {

    }

    public function deleteFile($id)
    {

    }
}
