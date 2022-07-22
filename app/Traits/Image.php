<?php


namespace App\Traits;


use Illuminate\Http\UploadedFile;

trait Image
{
    public function uploadPhoto(UploadedFile $file, string $logoPath): string
    {
        if (isset($file)) {
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($logoPath), $filename);
            return $logoPath . '/' . $filename;
        }
        return '';
    }
}
