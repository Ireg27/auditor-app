<?php

namespace App\Http\Resources\ScheduleJob;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleJobResource extends JsonResource
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
            'assessment' => $this->assessment,
            'scheduled_date' => $this->scheduled_date,
            'status' => $this->status,
            'user' => JobUserResource::make($this->user),
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
