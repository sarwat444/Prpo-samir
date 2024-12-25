<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InviteUser extends Model
{
    use HasFactory;
    protected $table = "invite_users";
    protected $fillable = ['inviter_id','user_id'];
}
