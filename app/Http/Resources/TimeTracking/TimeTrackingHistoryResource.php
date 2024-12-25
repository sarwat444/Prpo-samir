<?php

namespace App\Http\Resources\TimeTracking;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TimeTrackingHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $end = Carbon::parse($this->created_at)->format('d.m.Y H:i:s');
        $start = Carbon::parse($end)->subSeconds($this->Time)->format('d.m.Y H:i:s');
        $duration = Carbon::parse($start)->diffInSeconds($end);
        $hours = floor($duration / 3600);
        $minutes = floor(($duration % 3600) / 60);
        $seconds = $duration % 60;
        $formattedDuration = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
        return [
            'id' => $this->id,
            'start' => date('H:i:s', strtotime($start)),
            'time'  => $this->Time,
            'end' => date('H:i:s', strtotime($end)),
            'duration' => $formattedDuration,
            'date' => date('d.m.Y', strtotime($start)),
        ];
    }
}
