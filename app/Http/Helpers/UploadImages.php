<?php

namespace App\Http\Helpers;
class UploadImages {
    public function file_operations($request, $image)
    {
        if ($request->hasFile($image)) {
            $image = $request->file($image);
            $filepath = $image->store("images", "employers");
            return $filepath;
        }
        return null;
    }
}