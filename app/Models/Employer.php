<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Job;

class Employer extends Model
{
    use HasFactory;
    protected $fillable = ['name','email','password','industry','logo'];
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'employer_id', 'id');
    }
}
