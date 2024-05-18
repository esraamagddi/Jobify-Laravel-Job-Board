<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'responsibilities' => $this->responsibilities,
            'skills' => $this->skills,
            'qualifications' => $this->qualifications,
            'salary_range' => $this->salary_range,
            'work_type' => $this->work_type,
            'location' => $this->location,
            'status' => $this->status,
            'deadline' => $this->deadline,
            'employer' => $this->employer->name,
            'industry' => $this->employer->industry,
            'email' => $this->employer->email,
            'image' => $this->employer->image,
            'category' => $this->category->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
