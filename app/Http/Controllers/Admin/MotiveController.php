<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Motive;
use App\Models\Character;
use DataTables;
use DB;
use Validator;

class MotiveController extends Controller
{
  public function index() {



          //dd('hell');
               $datas = Motive::orderBy('id','desc')->get();

               return view('admin.motives.index',compact('datas'));

  }


   public function create() {
      return view('admin.motives.create');
   }

   public function store(Request $request) {



          //     dd($request->all());

         $validator = Validator::make($request->all(),[


               'motive_image' => 'required',
               'motive_name' => 'required',
               'characters' => 'required',
               'animal' => 'required',

         ]);

           if ($validator->fails()) {



                 return redirect()->route('admin.motives.create')->with(array('errors' => $validator->getMessageBag()));
           }


          //  dd($validator->errors()->getMessages());
          DB::beginTransaction();
          $data = new Motive();

           $data->motive_name = $request->motive_name;

           $data->animal = $request->animal[0];
           if ($request->hasFile('motive_image') && !empty($request->hasFile('motive_image'))) {
                  $image = $request->file('motive_image');
                  $image_ext = $image->getClientOriginalExtension();
                  $path = rand(123456, 999999) . "." . $image_ext;
                  $destination_path = base_path('assets/images/motives/');
                  $image->move($destination_path, $path);

                  $data->motive_image = $path;

           }

              $data->save();



              if(!empty($request->characters)) {

                    foreach ( json_decode($request->characters) as $key => $character) {
                           $characterr = new Character();

                           $characterr->character_name = $character;
                           $characterr->motive_id = $data->id;

                            $characterr->save();
                    }
              }

             DB::commit();

             return redirect()->route('admin.motives')->with(['success' => 'Data Added Successfully']);


   }







       public function edit(Request $request ) {

                  $id     = $request->id;
                  $motive   = Motive::find($id);

                  return view('admin.motives.edit', ['motive' => $motive,'id' => $id]);

       }

       public function update(Request $request , $id) {




                        //dd($request->all());

                  $validator = Validator::make($request->all(),[


                  //     'motive_image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
                        'motive_name' => 'required',
                        'characters' => 'required',
                        'animal' => 'required',

                  ]);

                    if ($validator->fails()) {



                          return redirect()->route('admin.motives.edit')->with(array('errors' => $validator->getMessageBag()));
                    }
          // dd($validator->errors()->getMessages());

               DB::beginTransaction();

                 $data = Motive::find($id);

                  $data->motive_name = $request->motive_name;

                  $data->animal = $request->animal[0];

                  if ($request->hasFile('motive_image') && !empty($request->hasFile('motive_image'))) {

                         $image = $request->file('motive_image');
                         $image_ext = $image->getClientOriginalExtension();
                         $path = rand(123456, 999999) . "." . $image_ext;
                         $destination_path = base_path('assets/images/motives/');
                         $image->move($destination_path, $path);

                         $data->motive_image = $path;

                  }



                   $data->save();


                   $chrrs = Character::where('motive_id',$id)->get();
                  if(!empty($chrrs)) {
                        foreach ($chrrs as $key => $chrr) {

                             $chrr->delete();
                        }

                  }

                   if(!empty($request->characters)) {

                         foreach ( json_decode($request->characters) as $key => $character) {
                                $characterr = new Character();

                                $characterr->character_name = $character;
                                $characterr->motive_id = $data->id;

                                 $characterr->save();
                         }
                   }


                     DB::commit();
                   return redirect()->route('admin.motives')->with(['success' => 'Motive Updated Successfully' ]);



           }





           public function delete(Request $request) {

                $id = $request->id;

                 $data = Motive::find($id);

                 $data->delete();

                 $msg = 'Data Deleted Successfully';

                return response()->json([
                   "status" =>  true,
                   "msg" => $msg
                   ],200);
       }

}
