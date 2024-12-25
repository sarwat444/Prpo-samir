<?php

namespace App\Http\Resources\TimeTracking;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TimeTrackingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $history = $this->whenLoaded('history');
        if(isset($history[0])){
            $first_history = Carbon::parse($history[count($history) - 1]->created_at)->subSeconds($history[count($history) - 1]->Time)->format('d.m.Y H:i:s');
            $last_history = end($history)[0]->created_at;
            $date = date('d.m.Y', strtotime($first_history));
        }else{
            $first_history = '';
            $last_history = '';
            $date = '';
        }
        $duration = $this->history_sum_time;
        if($first_history && $last_history){
            $hours = floor($duration / 3600);
            $minutes = floor(($duration % 3600) / 60);
            $seconds = $duration % 60;
            $formattedDuration = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
        }else{
            $formattedDuration = "00:00:00";
        }
        return [
            'id' => $this->id,
            'subtask_title' => $this->subtask_title,
            'task_title' => $this->whenLoaded('task')->task_title,
            'task_id' => $this->task_id,
            //'subtask_user_id' => $this->subtask_user_id,
            'subtask_start_date' => $this->subtask_start_date,
            'subtask_due_date' => $this->subtask_due_date,
            'subtask_priority' => $this->subtask_priority,
            'subtask_status' => $this->subtask_status,
            'subtask_completed_at' => $this->subtask_completed_at,
            'account_id' => $this->account_id,
            'subtask_time' => $this->subtask_time,
            'timer' => $this->timer,
            'timer_value' => $this->timer_value,
            'start_time_system' => $this->start_time_system,
            'tested' => $this->tested,
            'tester' => $this->tester,
            'assigned_at' => $this->assigned_at,
            'suborder' => $this->suborder,
            //'start_time' => date('H:i:s', strtotime($first_history)),
            //'end_time' => date('H:i:s', strtotime($last_history)),
            'last_change' => date('H:i:s', strtotime($last_history)),
            'date' => $date,
            'duration' => $formattedDuration,
            'history' => TimeTrackingHistoryResource::collection($this->whenLoaded('history')),
            'task' => $this->whenLoaded('task')->category,
            'project_title' => $this->whenLoaded('task')->category->category_name,
            'added_by' => $this->whenLoaded('added_by')
        ];
    }
}
