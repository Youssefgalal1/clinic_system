<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    /** @use HasFactory<\Database\Factories\DoctorFactory> */
    use HasFactory;

        protected $fillable = [
        'user_id',
        'specialization_id',
        'title',
        'bio',
        'fees',
        'experience_years',
        'rating',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinics()
    {
        return $this->hasMany(Clinic::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

        public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
