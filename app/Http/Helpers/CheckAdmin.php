<?php

namespace App\Http\Helpers;
class CheckAdmin
{
    public function isAdmin($user)
    {
        if ($user && $user->role === 'admin') {
            return true;
        }
        
        return false;
    }
}