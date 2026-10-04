<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'id' => $this->id,
        'user_id' => $this->user_id,
        'specialization_id' => $this->specialization_id,
        'title' => $this->title,
        'bio' => $this->bio,
        'experience_years' => $this->experience_years,
        'rating' => $this->rating,
        'image' => $this->image
            ? asset('storage/' . $this->image)
            : null,
    ];
    }
}
