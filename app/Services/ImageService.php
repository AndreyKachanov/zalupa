<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Exception;

class ImageService
{
    /**
     * @param  string  $filePathFromRequest
     * @return string
     */
    public function saveImageWithResize(string $filePathFromRequest): string
    {
        try {
            $img = Image::make($filePathFromRequest);
            $img->orientate()->fit(300, 350, function ($constraint) {
                $constraint->upsize();
            })->encode(null, 80);
            $now = Carbon::now()->toDateTimeString();
            $hash = md5($img->__toString() . $now);
            $fileName = 'items/' . $hash . '.jpg';
            Storage::disk('uploads')->put($fileName, $img);
        } catch (Exception $e) {
            $errorMsg = sprintf(
                '[%s]. Exception thrown. Error insert items image path to database. %s.  Class - %s, line - %d',
                Carbon::now()->toDateTimeString(),
                $e->getMessage(),
                __CLASS__,
                __LINE__
            );
            dd($errorMsg);
        }
        return $fileName;
    }
}
