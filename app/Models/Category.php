<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Post;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $guarded = [];

    public function jobs()
    {
        return $this->hasMany('App\Models\Job');
    }
    
    public function post(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }
}
