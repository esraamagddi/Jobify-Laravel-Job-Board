<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Application extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'post_id',
        'resume',
        'contact_details',
        'status',
        'app_email',
        'app_phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }

}
