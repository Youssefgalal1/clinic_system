<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'gender',
        'phone',
        'birth_date',
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

    public function doctor()
    {
        return $this->hasone(Doctor::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

        public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function role(){
    if($this->role == 'patient')
        return "<span class='badge bg-warning'>". $this->role ."</span>" ;
    elseif($this->role == 'doctor')
        return "<span class='badge bg-success'>". $this->role ."</span>" ;
    else
        return "<span class='badge bg-danger'>". $this->role ."</span>" ;
    }

        public function gender(){
    if($this->gender == 'male')
        return "<span class='badge bg-info text-dark'>". $this->gender ."</span>" ;
    else
        return "<span class='badge bg-danger-subtle text-danger-emphasis'>". $this->gender ."</span>" ;
    }
    
}
