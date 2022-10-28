<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * @param $file
     * @param Model $model
     * @return string
     */
    public function upload($file, Model $model): string
    {
        $folder = class_basename($model);

        $path = "Images/$folder";

        if (!is_file($file))
        {
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];

            $file_name = Str::random(20) . '.' . $extension;

            $replace = substr($file, 0, strpos($file, ',')+1);

            // find substring for replace here eg: data:image/png;base64,

            $image = str_replace($replace, '', $file);

            $image = str_replace(' ', '+', $image);

            $file_path = $path . "/" . $file_name;

            Storage::disk('public')->put(
                $file_path,
                base64_decode($image),
                'public'
            );
        }
        else
        {
            $file_name = Str::random(20) . $file->getClientOriginalName();

            $file_path = $path . "/" . $file_name;

            Storage::disk('public')->put(
                $file_path,
                file_get_contents($file),
                'public'
            );
        }

        return Storage::disk('public')->url($file_path);
    }

    /**
     * @param string $path
     * @return void
     */
    public function delete(string $path): void
    {
        $img_path = str_replace(config('app.url') . '/storage/', '', $path);

        if (Storage::disk('public')->exists($img_path))
        {
            Storage::disk('public')->delete($img_path);
        }
    }
}
