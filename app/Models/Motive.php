<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motive extends Model
{
      use HasFactory;

      protected $table = "motives";

      protected $fillable = ['motive_name','motive_image','animal'];

      public function characters() {

              return $this->hasMany('App\Models\Character', 'motive_id', 'id');
      }
}
