<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
      protected $fillable = ['from', 'to','image','message', 'is_read'];
}
