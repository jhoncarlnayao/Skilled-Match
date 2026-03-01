<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{

  use Notifiable;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasApiTokens;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
  // Allow mass assignment for these fields
   protected $fillable = [
    'first_name',
    'middle_name',
    'last_name',
    'username',
    'email',
    'phone',
    'address',
    'city',
    'postal_code',
    'birthdate',
    'profile_picture',
    'password',
    'role',
    'status',
];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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


    public function worker()
{
    return $this->hasOne(Worker::class);
}

public function announcements()
{
    return $this->hasMany(Announcement::class, 'user_id');
}
public function jobs() {
    return $this->hasMany(Job::class, 'worker_id'); 
}
}
