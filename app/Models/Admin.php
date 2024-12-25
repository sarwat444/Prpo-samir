<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory;

      protected $table="admins";
      protected $fillable =['name','email','password','created_at','updated_at'];

      //remeber token mean تذكرنى
      protected $hidden = [
         'password', 'remember_token',
      ];
}
