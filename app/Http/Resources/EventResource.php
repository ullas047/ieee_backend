<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'venue' => $this->venue,

            // normalize dates for frontend
            'date' => $this->start_datetime,
            'startTime' => date('H:i', strtotime($this->start_datetime)),
            'endTime' => date('H:i', strtotime($this->end_datetime)),
            'endDate' => $this->end_datetime,
            'prerequisites' => $this->prerequisites,

            'registrationFee' => $this->registration_fee,
            'registrationLink' => $this->registration_link,
            'status' => $this->status,

            // IMPORTANT: frontend needs full URL
            'banner_image' => $this->banner_image
                ? asset('storage/' . $this->banner_image)
                : null,

            // tags fix (your DB stores JSON string)
            'tags' => json_decode($this->tags, true) ?? [],

            // relations
            'speakers' => $this->speakers->map(function ($s) {
                return [
                    'id' => $s->id,
                    'name' => $s->name,
                    'title' => $s->title,
                    'image_url' => $s->image ? Storage::url($s->image) : null,
                ];
            }),

            'agendas' => $this->agendas,
            'highlights' => $this->highlights,

            'created_at' => $this->created_at,
        ];
    }
}