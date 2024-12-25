<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = "tasks";

    protected $fillable = [
      'task_title',
      'task_desc',
      'task_category_id',
      'task_added_by',
      'task_responsible',
      'task_start_date',
      'task_due_date',
      'task_status',
      'task_priority',
    ];

    public function category(){
        return $this->belongsTo('App\Models\Category' ,'task_category_id' , 'id');
    }
    public function second_category(){
        return $this->belongsTo('App\Models\Category' ,'task_category_id_two' , 'id');
     }
    public function responsible(){
        return $this->belongsTo('App\Models\User' ,'task_responsible' , 'id');
    }
    public function added_by() {
        return $this->belongsTo('App\Models\User' ,'task_added_by' , 'id');
    }
    public function subtasks() {
        return $this->hasMany('App\Models\SubTask' ,'task_id' , 'id')->orderBy('subtask_priority' , 'asc');
    }
    public function completed_subtasks() {
        return $this->hasMany('App\Models\SubTask' ,'task_id' , 'id')->where('subtask_status' , 1)->orderBy('subtask_priority' , 'asc');
    }
    public  function  testedtasks()
    {
        return $this->hasMany('App\Models\SubTask' ,'task_id' , 'id')->where('tested' , 1);
    }
    public function un_completed_subtasks() {
        return $this->hasMany('App\Models\SubTask' ,'task_id' , 'id')->where('subtask_status' , 0)->orderBy('subtask_priority' , 'asc');
    }
    public function un_completed_subtasks_api() {
        return $this->hasMany('App\Models\SubTask' ,'task_id' , 'id')->where('subtask_status' , 0)->orderBy('subtask_priority' , 'asc')->count();
    }

     public function comments() {
        return $this->hasMany('App\Models\Comment' ,'task_id' , 'id')->orderBy('id' , 'DESC');
    }
    public function team (){
        return $this->hasMany('App\Models\TaskTeam','task_id');
    }



}
