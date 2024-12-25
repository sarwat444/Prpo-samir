<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ModelImages;
use App\Models\ImageCharacter;
use App\Models\Character;
use App\Models\Section;
use App\Models\Motive;
use DataTables;
use DB;
use Validator;

class ImagesController extends Controller
{

  public function datatables($type)
 {


        if($type == 'hautfarbe'){
              $datas = ModelImages::where('type','=','hautfarbe')->orderBy('id','desc')->get();
         }
         elseif($type == 'kleidung_unter_teil') {
              $datas = ModelImages::where('type','=','kleidung_unter_teil')->orderBy('id','desc')->get();
         }
         elseif($type == 'kleidung_boer_teil') {
              $datas = ModelImages::where('type','=','kleidung_boer_teil')->orderBy('id','desc')->get();
         }
         elseif($type == 'hinterground') {
              $datas = ModelImages::where('type','=','hinterground')->orderBy('id','desc')->get();
         }elseif($type == 'hairstyle') {
                $datas = ModelImages::where('type','=','hairstyle')->orderBy('id','desc')->get();
         }
         else{
               $datas = ModelImages::where('type','=','mugs')->orderBy('id','desc')->get();
         }





     //--- Integrating This Collection Into Datatables
   return Datatables::of($datas)





                         ->editColumn('gender', function(ModelImages $data) {
                                 if($data->gender == "1") {

                                     return    "Mann";
                                 }else if ($data->gender == "2") {

                                     return    "Frau";

                                 }else {
                                      return 'No Thing';
                                 }
                         })



                          ->editColumn('image', function(ModelImages $data) {
                                   $image = $data->image ? url('assets/images/'.$data->image):url('assets/images/noimage.png');
                                   return '<img src="' . $image . '" alt="Image" style="width:60px;height:60px;">';
                          })







                      ->addColumn('action', function(ModelImages $data) {






                      })
                      ->rawColumns(['action','gender','image'])
                      ->toJson(); //--- Returning Json Data To Client Side
 }



     public function index() {



             //dd('hell');
                  $datas = ModelImages::orderBy('id','desc')->get();

                  return view('admin.images.index',compact('datas'));
     }



     public function index2(Request $request ) {

      //  dd($request->all());

          $type = $request->type;
          if($type == 'hautfarbe'){


                $datas = ModelImages::where('type','=','hautfarbe')->orderBy('id','desc')->get();
           }
           elseif($type == 'kleidung_unter_teil') {
                $datas = ModelImages::where('type','=','kleidung_unter_teil')->orderBy('id','desc')->get();
           }
           elseif($type == 'kleidung_boer_teil') {
                $datas = ModelImages::where('type','=','kleidung_boer_teil')->orderBy('id','desc')->get();
           }
           elseif($type == 'hinterground') {
                $datas = ModelImages::where('type','=','hinterground')->orderBy('id','desc')->get();
           }elseif($type == 'hairstyle') {
                  $datas = ModelImages::where('type','=','hairstyle')->orderBy('id','desc')->get();
           }
           else{
             //dd('hell');
                 $datas = ModelImages::where('type','=','mugs')->orderBy('id','desc')->get();
           }

        //   dd($datas);

        $data = view('admin.images.index2',compact('datas'))->render();

         return response()->json(['options'=>$data]);

     }

      public function create() {

            $motives =  Motive::all();

            return view('admin.images.create',compact('motives'));
      }

      public function store(Request $request) {



                  //dd($request->all());

            $validator = Validator::make($request->all(),[

                 'images' => 'required',
                 'images.*' => 'required|max:2048',
                 'motive_id' => 'required',
                //  'gender' => 'required',
        ]);

        if ($validator->fails()) {



              return redirect()->route('admin.images.create')->with(array('errors' => $validator->getMessageBag()));
        }
    // dd($validator->errors()->getMessages());



if ($request->hasfile('images') && !empty($request->hasFile('images'))) {


        $images = $request->file('images');

        foreach($images as $image) {

             $data = new ModelImages();

              $image_ext = $image->getClientOriginalExtension();
              $path = rand(123456, 999999) . "." . $image_ext;
              $destination_path = base_path('assets/images/');
              $image->move($destination_path, $path);

                $data->image = $path;

              //  $data->section_id = $request->section_id;

                $data->motive_id = $request->motive_id;

                $data->section = $request->section;


               if(!empty($request->animal)) {
                  $data->animal = $request->animal[0];
              }  


                   $data->save();


                   if(!empty($request->characters)) {


                          foreach ($request->characters as $key => $chrrr) {

                                   $imgchar = new ImageCharacter();

                                   $imgchar->image_id =   $data->id;
                                   $imgchar->character_id =   $chrrr;

                                   $imgchar->save();

                          }
                   }


        }
     }




                return redirect()->route('admin.images.create')->with(['success' => 'Data Added Successfully']);


      }



      public function move(Request $request ) {

                $id     = $request->id;
                $image   = ModelImages::find($id);

                return view('admin.images.move', ['image' => $image,'id' => $id]);

      }

      public function updateCategory(Request $request , $id) {



                  $validator = Validator::make($request->all(),[


                        'type' => 'required',

                   ]);


              if ($validator->fails()) {



                    return redirect()->route('admin.images')->with(array('errors' => $validator->getMessageBag()));
              }



                $data = ModelImages::find($id);

                 $data->type = $request->type;

                 $data->save();

                  return redirect()->route('admin.images')->with(['success' => 'Image Moved Successfully' ]);



          }



          public function edit(Request $request ) {

                    $id     = $request->id;
                    $image   = ModelImages::find($id);
                    $motives =  Motive::all();

                    return view('admin.images.edit', ['image' => $image  ,'motives' => $motives ,'id' => $id]);

          }

          public function update(Request $request , $id) {



                      $validator = Validator::make($request->all(),[


                            'gender'  => 'required',

                             'image' => 'mimes:jpeg,png,jpg,gif,svg',
                             'section_id' => 'required',
                             'motive_id' => 'required',

                       ]);


                  if ($validator->fails()) {



                        return redirect()->route('admin.images')->with(array('errors' => $validator->getMessageBag()));
                  }



                    $data = ModelImages::find($id);

                     $data->gender = $request->gender[0];

                     if ($request->hasFile('image') && !empty($request->hasFile('image'))) {


                          $image = $request->file('image');
                          $image_ext = $image->getClientOriginalExtension();
                          $path = rand(123456, 999999) . "." . $image_ext;
                          $destination_path = base_path('assets/images/');
                          $image->move($destination_path, $path);

                            $data->image = $path;

                 }

                     $data->save();

                      return redirect()->route('admin.images')->with(['success' => 'Image Updated Successfully' ]);



              }





              public function delete(Request $request) {

                   $id = $request->id;

                    $data = ModelImages::find($id);

                    $data->delete();

                    $msg = 'Data Deleted Successfully';

                   return response()->json([
                      "status" =>  true,
                      "msg" => $msg
                      ],200);
          }




           public function getMotivesChrrs(Request $request) {
             //  dd($request->all());
                       $motive_id = $request->motive_id;
                     $motive = Motive::where('id',$motive_id)->first();


                       $datas = Character::where('motive_id',$motive_id)->orderBy('id','desc')->get();
                       $data = view('admin.images.motive_charr',compact('datas','motive'))->render();
                       return response()->json(['options'=>$data]);
           }




}
