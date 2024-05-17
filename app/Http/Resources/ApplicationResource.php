<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'post_id' => $this->post_id,
            'resume' => $this->resume,
            'contact_details' => $this->contact_details,
            'status' => $this->status,
            'app_email' => $this->app_email,
            'app_phone' => $this->app_phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];    }
}
