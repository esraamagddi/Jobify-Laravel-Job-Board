<?php

namespace App\Http\Helpers;
class UploadImages {
    
    public function file_operations($request){
        if($request->hasFile('image')){
    
            $image = $request->file('image');
            $filepath=$image->store("images","users" );

            return $filepath;
    
        }
        return null;
    }
}


