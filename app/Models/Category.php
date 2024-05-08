<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Job;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function job(): HasMany
    {
        return $this->hasMany(Job::class, 'category_id', 'id');
    }
}
