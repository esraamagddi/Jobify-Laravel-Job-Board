<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employer;
use App\Models\Category;
use App\Models\Application;
class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'responsibilities', 'skills', 'qualifications', 'salary_range', 'work_type', 'location', 'deadline', 'employer_id', 'category_id'];

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
