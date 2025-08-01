<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'start_datetime' => $this->start_datetime->toIso8601String(),
            'end_datetime' => $this->end_datetime->toIso8601String(),
            'max_participants' => $this->max_participants,
            'current_participants' => $this->participants->count(),
            'participants' => UserResource::collection($this->whenLoaded('participants')),
        ];
    }
}
