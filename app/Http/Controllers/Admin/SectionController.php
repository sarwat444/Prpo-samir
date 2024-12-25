<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use DataTables;
use DB;
use Validator;


class SectionController extends Controller
{
  public function index() {



          //dd('hell');
               $datas = Section::orderBy('id','desc')->get();

               return view('admin.sections.index',compact('datas'));

  }


   public function create() {
      return view('admin.sections.create');
   }

   public function store(Request $request) {



               //dd($request->all());

         $validator = Validator::make($request->all(),[



               'section_name' => 'required',

         ]);

           if ($validator->fails()) {



                 return redirect()->route('admin.sections.create')->with(array('errors' => $validator->getMessageBag()));
           }


          //  dd($validator->errors()->getMessages());

            $data = new Section();

            $data->section_name = $request->section_name;

            $data->save();

             return redirect()->route('admin.sections')->with(['success' => 'Data Added Successfully']);


   }







       public function edit(Request $request ) {

                  $id     = $request->id;
                  $section   = Section::find($id);

                  return view('admin.sections.edit', ['section' => $section,'id' => $id]);

       }

       public function update(Request $request , $id) {



                  //dd($request->all());

                  $validator = Validator::make($request->all(),[



                        'section_name' => 'required',

                  ]);

                    if ($validator->fails()) {



                          return redirect()->route('admin.sections.edit')->with(array('errors' => $validator->getMessageBag()));

                    }
          // dd($validator->errors()->getMessages());



                 $data = Section::find($id);

                  $data->section_name = $request->section_name;


                   $data->save();

                   return redirect()->route('admin.sections')->with(['success' => 'Section Updated Successfully' ]);



           }





           public function delete(Request $request) {

                $id = $request->id;

                 $data = Section::find($id);

                 $data->delete();

                 $msg = 'Data Deleted Successfully';

                return response()->json([
                          "status" =>  true,
                           "msg" => $msg
                   ],200);
       }
}
