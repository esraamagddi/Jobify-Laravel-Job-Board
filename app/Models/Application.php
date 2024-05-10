<?php

namespace App\Models;
use App\Models\Candidate;
use App\Models\Post;
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
        'post_id',
        'resume',
        'contact_details',
        'status',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class,'candidate_id','id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }
}