<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

Trait ImageTrait
{
    // this function used  upload single photo if you have a table column in database for photo
    function uploadImage($photo, $folder)
    {
        $file_extension = $photo->getClientOriginalExtension();
        $photo_name     = time() . '.' . $file_extension;
        $path           = $folder;
        $photo->move($path, $photo_name);

        return $photo_name;
    }



    // this function used to upload single photo if you have a media morph table to add all photos in it
    public function uploadMedia($modelRecord, $folder, $request)
    {
        //remove old file
        if($modelRecord->media) 
        {
            Storage::disk('attachments')->delete($folder . '/' . $modelRecord->media->file_name);
            $modelRecord->media->delete();
        }

        $file_size = $request->getSize();
        $file_type = $request->getMimeType();
        $file_name = time() . '.webp' /*. $request->getClientOriginalName()*/;
        $request->storeAs($folder, $file_name, 'attachments');
        $modelRecord->media()->create([
            'file_path' => asset('public/attachments/' . $folder . '/' . $file_name),
            'file_name' => $file_name,
            'file_size' => $file_size,
            'file_type' => $file_type,
            'file_sort' => 1,
        ]);
    }



    // this function used to upload mulit photo if you have a media morph table to add all photos in it
    public function uploadMultiMedia($modelRecord, $folder, $requests)
    {
        //remove old files
        if($modelRecord->media) {
            foreach($modelRecord->media as $media) 
            {
                Storage::disk('attachments')->delete($folder . '/' . $media->file_name);
                $media->delete();
            }
        }

        $i = 0;
        foreach ($requests as $index => $file)
        {
            $file_size = $file->getSize();
            $file_type = $file->getMimeType();
            $file_name = time() . $i . '.webp' /*. $file->getClientOriginalName()*/;
            $file->storeAs($folder, $file_name, 'attachments');
            $modelRecord->media()->create([
                'file_path' => asset('public/attachments/' . $folder . '/' . $file_name),
                'file_name' => $file_name,
                'file_size' => $file_size,
                'file_type' => $file_type,
                'file_sort' => $i,
            ]);
            $i++;
        }
    }
}