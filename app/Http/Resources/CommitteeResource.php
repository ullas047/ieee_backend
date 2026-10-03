<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommitteeResource extends JsonResource
{
    /**
     * Transform the committee member for API consumers.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'year' => $this->year,
            'committee_type' => $this->committee_type,
            'name' => $this->name,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'image_path' => $this->image,
            'club_position' => $this->club_position,
            'varsity_position' => $this->varsity_position,
            'facebook_link' => $this->facebook_link,
            'linkedin_link' => $this->linkedin_link,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
