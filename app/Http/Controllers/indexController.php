<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Motive;
use App\Models\Character;
use App\Models\ModelImages;
use App\Models\ImageCharacter;


class indexController extends Controller
{

  public  function index()
  {
      $motives = Motive::all();
      return view('index',compact('motives')) ;
  }

    public  function productdetails($id)
    {

          $motive = Motive::find($id);
          if($motive) {
                  return view('front.products.product_details',compact('motive')) ;
          }

    }
    public  function modeldetails($id)
    {

        $motive = Motive::find($id);



        if($motive) {

                $motive_characters = Character::where('motive_id',$id)->get();
          

                $motive_images     = ModelImages::where('motive_id',$id)->get();
                return view('front.models.modeldetails',compact('motive','motive_characters','motive_images')) ;
        }

    }
}
