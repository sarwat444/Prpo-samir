<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageCharacter extends Model
{
    use HasFactory;
    protected $table = "image_characters";
    protected $fillable = ['image_id','character_id'];
}
