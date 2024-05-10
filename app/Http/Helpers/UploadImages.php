<?php

namespace App\Http\Helpers;
class UploadImages {
    public function file_operations($request, $image,$folder)
    {
        if ($request->hasFile($image)) {
            $image = $request->file($image);
            $filepath = $image->store("images", $folder);
            return $filepath;
        }
        return null;
    }
}