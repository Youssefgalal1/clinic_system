<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    /** @use HasFactory<\Database\Factories\SpecializationFactory> */
    use HasFactory;

    protected $fillable = [
    'name',
    'image',
];
    public function doctors()
        {
            return $this->hasMany(Doctor::class);
        }

    public function image()
    {
        if (is_null($this->image))
        return 'default.png';
        else
        return $this->image;
    }
}
