<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HospitalResource extends JsonResource
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
            'name' => $this->name,
            'photo' => $this->photo,
            'city' => $this->city,
            'phone' => $this->phone,
            'about' => $this->about,
            'address' => $this->address,
            'post_code' => $this->post_code,
            'doctors_count' => $this->doctors->count(),
            'specialists_count' => $this->specialists->count(),
            'doctors' => DoctorResource::collection($this->whenLoaded('doctors')),
            'specialists' => SpecialistResource::collection($this->whenLoaded('specialists'))
        ];
    }
}
