<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUpload extends Model
{
    public static function S3($fileData, $folder, $subName)
    {
        $file = $fileData;
        $extension = $file->getClientOriginalExtension();

        $movedName = $subName . '-' . time() . '.' . $extension;

        $path = $file->storeAs($folder, $movedName, 'public');

        return asset('storage/' . $path);
    }

    public static function S3_PDF($fileData, $folder, $subName)
    {
        $file = $fileData;
        $extension = $file->getClientOriginalExtension();

        $movedName = $subName . '-' . time() . '.' . $extension;

        $path = $file->storeAs($folder, $movedName, 'public');

        return asset('storage/' . $path);
    }

    public static function UploadFileBlob($files_name, $file_tmp, $folder)
    {
        if (isset($files_name) && isset($file_tmp)) {

            $new_name = time() . '_' . $files_name;

            Storage::disk('public')->put($folder . '/' . $new_name, $file_tmp);

            return asset('storage/' . $folder . '/' . $new_name);
        }
    }
}