<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->user->id,
            'employer_id'=>$this->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'industry' => $this->industry,
            'image' => $this->user->profile_photo_path,
            'avatar' => $this->user->profile_photo_url ?? 'N/A',
            'branches' => $this->branches,
            'branding_elements' => $this->branding_elements,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            //'posts' => PostResource::collection($this->whenLoaded('posts')),
        ];
    }
}
