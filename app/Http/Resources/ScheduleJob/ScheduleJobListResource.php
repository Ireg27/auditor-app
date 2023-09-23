<?php

namespace App\Http\Resources\ScheduleJob;

use App\Models\ScheduleJob;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ScheduleJob */
class ScheduleJobListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'scheduled_date' => $this->scheduled_date,
            'status' => $this->status,
            'user' => JobUserResource::make($this->user),
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
