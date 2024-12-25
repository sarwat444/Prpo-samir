<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskGuest extends Model
{
    use HasFactory;
     protected $table = "task_guests";
    protected $fillable = [
      'task_id',
      'user_id',
    ];
}
