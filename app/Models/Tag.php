<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = "tags";
    protected $fillable = [
        'tag_name',
        'cat_id'
    ];
    public  function  categories()
    {
        return $this->belongsTo('App\Models\Category' ,'cat_id' , 'id');
    }
}
