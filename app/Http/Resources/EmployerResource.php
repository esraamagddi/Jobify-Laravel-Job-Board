<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployerResource extends JsonResource
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
            'name' => $this->user->name,
            'email' => $this->user->email,
            'industry' => $this->industry,
            'image' => $this->user->profile_photo_path,
            'avatar'=>$this->user->profile_photo_url ?? 'N/A',
            'branches'=>$this->branches,
            'branding_elements'=> $this->branding_elements,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
