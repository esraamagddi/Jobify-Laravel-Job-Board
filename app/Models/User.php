<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Application;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Category;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image',
        'profile_photo_path'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'user_id', 'id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',

    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function employer()
    {
        return $this->hasOne(Employer::class);
    }

    // one-to-many
    public function jobs()
    {
        return $this->hasMany('App\Models\Job');
    }
    
    // many-to-many
    // public function applications()
    // {
    //     return $this->belongsToMany('App\Models\Post', 'applications')->withPivot(['user_id', 'post_id', 'resume', 'status']);
    // }
    
}
