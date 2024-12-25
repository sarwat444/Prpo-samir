<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table = "logs";
    protected $fillable = [
      'log_desc',
      'log_user_id',
    ];

    public function userImage(){
      return $this->belongsTo('App\Models\User' , 'log_user_id' , 'id');
    }

    public function subtask(){
      return $this->belongsTo('App\Models\SubTask' , 'log_subtask_id' , 'id')->with('task');
  }

  public function task(){
    return $this->belongsTo('App\Models\Task' , 'log_task_id' , 'id');
  }

  public function category(){
     return $this->belongsTo('App\Models\Category' , 'log_cat_id' , 'id');
   }
   public function getCreatedAtAttribute($value)
   {
       return date('H:i', strtotime($value));
   }

}
