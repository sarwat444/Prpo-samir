<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelImages extends Model
{

    use HasFactory;

    protected $table="model_images";
    protected $fillable =['image','section_id','motive_id','created_at','updated_at'];

    public function section() {

        return $this->belongsTo('App\Models\Section', 'section_id', 'id');
   }


    public function motive() {
          return $this->belongsTo('App\Models\Motive', 'motive_id', 'id');
    }
}
