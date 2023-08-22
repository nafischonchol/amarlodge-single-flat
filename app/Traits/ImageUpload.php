<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait ImageUpload
{
    //image upload
    public function fileUploadimage($file, $path, $width, $height)
    {
        // multiple image upload
        if (is_array($file)) {
            if (! empty($file)) {
                $gallery = [];
                $i = 1;
                foreach ($file as $item) {
                    $fileName = substr(md5(time()), 0, 20).$i.'.'.$item->getClientOriginalExtension();
                    Image::make(file_get_contents($item))->resize($width, $height)->save($path.$fileName);
                    $gallery[] = $path.$fileName;
                    $i++;
                }

                return json_encode($gallery);
            }
        }

        // single image upload
        if (! empty($file)) {
            $fileName = substr(md5(time()), 0, 20).'.'.$file->getClientOriginalExtension();
            Image::make(file_get_contents($file))->resize($width, $height)->save($path.$fileName);

            return $path.$fileName;
        }
    }

    public function deleteImage($path)
    {
        $image = public_path($path);
        if (file_exists($image) && is_file($image)) {
            unlink($image);
        }

        return null;
    }

    public function deleteMultipleImage($files)
    {
        foreach ($files as $path) {
            $image = public_path($path);
            if (file_exists($image) && is_file($image)) {
                unlink($image);
            }
        }

        return null;
    }

    public static function fileDelete($image)
    {
        if (File::exists($image)) {
            File::delete($image);
        }

        return null;
    }

    public static function uploadImage($file, $directory, $image_name = null)
    {
        if (Str::startsWith($file, 'data:image/')) {
            return self::base64FileStore($file, $directory);
        } else {
            return self::fileUpload($file, $directory);
        }
    }

    public static function fileUpload($file, $path)
    {
        if (! empty($file)) {
            $extension = 'webp';
            $fileName = substr(md5(time()), 0, 20).'.'.$extension;
            $imagePath = $path.$fileName;
            $filePath = public_path($imagePath);
            $resizedImage = Image::make($file)->fit(400, 265);
            $resizedImage->save($filePath);

            return $imagePath;
        }

        return null;
    }

    public static function base64FileStore($file, $directory, $image_name = null): string
    {
        if ($image_name == null) {
            $image_name = Str::uuid();
        }
        $base64Image = explode(';base64,', $file);
        $extension = 'webp';

        $image_base64 = base64_decode($base64Image[1]);
        $imagePath = $directory.$image_name.'.'.$extension;
        $filePath = public_path($imagePath);
        // if (!is_dir($directory)) {
        //     mkdir($directory, 0755, true);
        // }

        // Resize the image
        $resizedImage = Image::make($image_base64)->fit(400, 265)->encode($extension);
        $resizedImage->save($filePath);

        return $imagePath;
    }

    public static function uploadImageMultiple($files, $directory, $image_name = null)
    {
        if ($files && Str::startsWith($files[0], 'data:image/')) {
            return self::base64FileStoreMultiple($files, $directory);
        } elseif ($files) {
            return self::fileUploadMultiple($files, $directory);
        }
    }

    public static function fileUploadMultiple($files, $path)
    {
        $uploadedImages = [];
        foreach ($files as $file) {
            $extension = 'webp';
            $fileName = Str::uuid().'.'.$extension;
            $imagePath = $path.$fileName;
            $filePath = public_path($imagePath);
            $resizedImage = Image::make($file)->fit(400, 265);
            $resizedImage->save($filePath);
            $uploadedImages[] = $imagePath;
        }

        return $uploadedImages;
    }

    public static function base64FileStoreMultiple($files, $directory): array
    {
        $uploadedImages = [];

        foreach ($files as $file) {
            $imageName = Str::uuid().'.webp';
            $base64Image = explode(';base64,', $file);
            $imageBase64 = base64_decode($base64Image[1]);
            $imagePath = $directory.$imageName;
            $filePath = public_path($imagePath);
            // if (!is_dir($directory)) {
            //     mkdir($directory, 0755, true);
            // }

            // Resize the image
            $resizedImage = Image::make($imageBase64)->fit(400, 265)->encode('webp');
            $resizedImage->save($filePath);

            $uploadedImages[] = $imagePath;
        }

        return $uploadedImages;
    }
}
