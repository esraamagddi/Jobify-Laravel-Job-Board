<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $fillable = [
        // 'employer_id',
        'title',
        'description',
        'responsibilities',
        'requirements',
        'benefits',
        'location',
        'type',
        'salary_min',
        'salary_max',
        'application_deadline',
    ];
}
