<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmentFactory> */
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

        public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

        public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function status(){
        if($this->status == 'pending'){
            return "<span class='badge bg-warning'>". $this->status ."</span>" ;
        }elseif($this->status == 'confirmed'){
            return "<span class='badge bg-primary'>". $this->status ."</span>" ;
        }elseif($this->status == 'cancelled'){
            return "<span class='badge bg-danger'>". $this->status ."</span>" ;
        }else{
            return "<span class='badge bg-info'>". $this->status ."</span>" ;
        }
    }
}
