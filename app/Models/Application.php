<?php

namespace App\Models;
use App\Models\Candidate;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Application extends Model implements HasMedia
{
    use InteractsWithMedia;

    use HasFactory;

    protected $fillable = [
        'candidate_id',
        // 'job_id',
        'resume',
        'contact_details',
        'status',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // public function job()
    // {
    //     return $this->belongsTo(Job::class);
    // }
}
