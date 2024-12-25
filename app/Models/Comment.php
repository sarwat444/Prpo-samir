<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = ['comment','tags','task_id','comment_added_by','done'];
    public function getCommentAttribute($value)
    {
        return strip_tags($value);
    }
    public function user(){
        return $this->belongsTo('App\Models\User','comment_added_by','id');
    }
    public function added_by(){
        return $this->belongsTo('App\Models\User' ,'comment_added_by' , 'id');
    }
    public  function  replays()
    {
        return $this->hasMany('App\Models\Replay' , 'comment_id' ,'id');
    }
    public function task(){
        return $this->belongsTo('App\Models\Task' ,'task_id' , 'id');
    }
    public function subtask(){
        return $this->belongsTo('App\Models\SubTask' ,'subtask_id' , 'id');
    }

}
