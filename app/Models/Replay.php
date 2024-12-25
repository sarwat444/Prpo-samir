<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replay extends Model
{
    use HasFactory;

    protected $table = "comments_replay";
    protected $fillable = [
      'comment_id',
      'replay',
      'added_by',
      'created_at',
      'updated_at'
    ];



    public function user(){
        return $this->belongsTo('App\Models\User','added_by_id','id');
    }

    public function comment()
    {
      return  $this->belongsTo('App\Models\Comment' , 'comment_id' ,'id') ;
    }


}
