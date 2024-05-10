<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password',

    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }


}
