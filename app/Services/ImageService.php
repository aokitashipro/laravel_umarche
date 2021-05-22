<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use InterventionImage;


class ImageService
{
  public static function upload($imageFile, $folderName){
    //dd($imageFile['image']);
    if(is_array($imageFile))
    {
      $file = $imageFile['image'];
    } else {
      $file = $imageFile;
    }

    $fileName = uniqid(rand().'_');
    $extension = $file->extension();
    $fileNameToStore = $fileName. '.' . $extension;
    $resizedImage = InterventionImage::make($file)->resize(1920, 1080)->encode();
    Storage::put('public/' . $folderName . '/' . $fileNameToStore, $resizedImage );
    
    return $fileNameToStore;
  }
}