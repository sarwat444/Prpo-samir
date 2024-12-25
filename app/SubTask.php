<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;
    protected $table = "sub_tasks";
    protected $fillable = [
      'subtask_title',
      'task_id',
      'subtask_added_by',
      'subtask_user_id',
      'subtask_start_date',
      'subtask_due_date',
      'subtask_status',
    ];

    public function responsible(){
        return $this->belongsTo('App\Models\User' ,'subtask_user_id' , 'id');
    }
    public function task(){
        return $this->belongsTo('App\Models\Task' ,'task_id' , 'id');
    }
}
