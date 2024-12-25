<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{

    use HasFactory , SoftDeletes;

    protected $table = "categories";
    protected $fillable = ['category_name','category_color' ,'priority'];


    public function tasks() {
        $tasksids = \App\Models\TaskTeam::where('user_id',auth()->user()->id)->pluck('task_id');

        if(!empty($tasksids) && count($tasksids) > 0) {
            return $this->hasMany('App\Models\Task' ,'task_category_id' , 'id')->with('added_by', 'responsible')->whereIn('id',$tasksids)->where('task_status' , 0)
                ->withCount('un_completed_subtasks')
                ->withCount('completed_subtasks')
                ->Orwhere('task_added_by' , auth()->user()->id)->where('task_status' , 0)
                ->Orwhere('task_responsible' , auth()->user()->id)->where('task_status' , 0)
                ->orderBy('task_priority' , 'asc');
        }else {
            return $this->hasMany('App\Models\Task' ,'task_category_id' , 'id')->with('added_by', 'responsible')->where('task_added_by' , auth()->user()->id)->where('task_status' , 0)
                ->withCount('un_completed_subtasks')
                ->withCount('completed_subtasks')
                ->Orwhere('task_responsible' , auth()->user()->id)->where('task_status' , 0)
                ->orderBy('task_priority' , 'asc');
        }
    }
    public function completed_tasks() {
        $tasksids = \App\Models\TaskTeam::where('user_id',auth()->user()->id)->pluck('task_id');
        if(!empty($tasksids) && count($tasksids) > 0) {
            return $this->hasMany('App\Models\Task' ,'task_category_id' , 'id')->with('added_by' , 'team.user' ,'category' ,'second_category', 'responsible')->whereIn('id',$tasksids)->where('task_status' , 1)
                ->withCount('un_completed_subtasks')
                ->withCount('completed_subtasks')
                ->Orwhere('task_added_by' , auth()->user()->id)->where('task_status' , 1)
                ->Orwhere('task_responsible' , auth()->user()->id)->where('task_status' , 1)
                ->orderBy('task_priority' , 'desc');
        }else {
            return $this->hasMany('App\Models\Task' ,'task_category_id' , 'id')->with('added_by' , 'team.user' ,'category' ,'second_category', 'responsible')->where('task_added_by' , auth()->user()->id)->where('task_status' , 1)
                ->withCount('un_completed_subtasks')
                ->withCount('completed_subtasks')
                ->Orwhere('task_responsible' , auth()->user()->id)->where('task_status' , 1)
                ->orderBy('task_priority' , 'desc');
        }
    }


    public function completed_tasks_api() {
        $tasksids = \App\Models\TaskTeam::where('user_id',auth()->user()->id)->pluck('task_id');
        if(!empty($tasksids) && count($tasksids) > 0) {

            return $this->hasMany('App\Models\Task' ,'task_category_id' , 'id')->withCount('un_completed_subtasks')->withCount('completed_subtasks')->whereIn('id',$tasksids)->where('task_status' , 1)
                                ->withCount('un_completed_subtasks')
                                ->withCount('completed_subtasks')
                                ->Orwhere('task_added_by' , auth()->user()->id)->where('task_status' , 1)
                                ->Orwhere('task_responsible' , auth()->user()->id)->where('task_status' , 1)
                                ->orderBy('task_priority' , 'desc');
        }else {
            return $this->hasMany('App\Models\Task' ,'task_category_id' , 'id')->withCount('un_completed_subtasks')->withCount('completed_subtasks')->where('task_added_by' , auth()->user()->id)->where('task_status' , 1)
                ->Orwhere('task_responsible' , auth()->user()->id)->where('task_status' , 1)
                ->withCount('un_completed_subtasks')
                ->withCount('completed_subtasks')
                ->orderBy('task_priority' , 'desc');
        }
    }


    public function deleted_tasks() {
        $tasksids = \App\Models\TaskTeam::where('user_id',auth()->user()->id)->pluck('task_id');
        if(!empty($tasksids) && count($tasksids) > 0) {
            return $this->hasMany('App\Models\Task' ,'task_category_id' , 'id')->withCount('un_completed_subtasks')->withCount('completed_subtasks')->with('added_by' , 'team.user' ,'category' ,'second_category', 'responsible')->whereIn('id',$tasksids)->where('task_status' , 2)
                ->Orwhere('task_added_by' , auth()->user()->id)->where('task_status' , 2)
                ->Orwhere('task_responsible' , auth()->user()->id)->where('task_status' , 2)
                ->withCount('un_completed_subtasks')
                ->withCount('completed_subtasks')
                ->orderBy('task_priority' , 'asc');
        }else {
            return $this->hasMany('App\Models\Task' ,'task_category_id' , 'id')->withCount('un_completed_subtasks')->withCount('completed_subtasks')->with('added_by' , 'team.user' ,'category' ,'second_category', 'responsible')->where('task_added_by' , auth()->user()->id)->where('task_status' , 2)
                ->Orwhere('task_responsible' , auth()->user()->id)->where('task_status' , 2)
                ->withCount('un_completed_subtasks')
                ->withCount('completed_subtasks')
                ->orderBy('task_priority' , 'asc');
        }
    }
    public function uncompleted_tasks() {
        if(!empty($tasksids) && count($tasksids) > 0) {
            return $this->hasMany('App\Models\Task' ,'task_category_id' , 'id')->withCount('un_completed_subtasks')->withCount('completed_subtasks')->whereIn('id',$tasksids)->where('task_status' , 0)
                ->Orwhere('task_added_by' , auth()->user()->id)->where('task_status' , 0)
                ->Orwhere('task_responsible' , auth()->user()->id)->where('task_status' , 0)
                ->withCount('un_completed_subtasks')
                ->withCount('completed_subtasks')
                ->orderBy('task_priority' , 'asc');
        }else {
            return $this->hasMany('App\Models\Task' ,'task_category_id' , 'id')->withCount('un_completed_subtasks')->withCount('completed_subtasks')->where('task_added_by' , auth()->user()->id)->where('task_status' , 0)
                ->Orwhere('task_responsible' , auth()->user()->id)->where('task_status' , 0)
                ->withCount('un_completed_subtasks')
                ->withCount('completed_subtasks')
                ->orderBy('task_priority' , 'asc');
        }
    }

}
