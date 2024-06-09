<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService

{
    public static function deleteFile($name, $path)
    {
        if ($name && Storage::disk('public')->exists($path . '/' . $name)) {
            Storage::disk('public')->delete($path . '/' . $name);
        }
        return null;
    }


    public static function saveFile($file, $path, $oldFileName = null)
    {
        if ($oldFileName) {
            self::deleteFile($oldFileName, $path);
        }
        $fileName = time() . "_" . Str::random(5) . '.' . $file->getClientOriginalExtension();
        Storage::disk('public')->putFileAs($path, $file, $fileName);
        return $fileName;
    }

    public static function saveShriftFile($file, $path, $oldFileName = null)
    {
        if ($oldFileName) {
            self::deleteFile($oldFileName, $path);
        }
        $fileName = $file->getClientOriginalName();
        Storage::disk('public')->putFileAs($path, $file, $fileName);
        return $fileName;
    }

    public static function saveBase64Image($base64String, $path, $oldFileName = null)
    {
        if ($oldFileName) {
            self::deleteFile($oldFileName, $path);
        }
        $decodedData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64String));
        $fileName = time() . "_" . Str::random(5) . '.jpg';
        Storage::disk('public')->put($path . '/' . $fileName, $decodedData);
        return $fileName;
    }
}
