<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->profile_photo_path,
            'role'=>$this->role,
            'avatar'=>$this->profile_photo_url ?? 'N/A',
        ];
    }
}
