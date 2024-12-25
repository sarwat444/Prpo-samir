<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Task;
use App\Models\Log;
use App\Models\Package;
use DataTables;
use DB;
use Validator;
use Auth;
class PackageController extends Controller
{
     public function index() {
        $datas = Package::orderBy('id','desc')->get();
        $status = 3;
        return view('admin.packages.index',compact('datas','status'));
    }

    public function create() {
        
            $status = 3;
        return view('admin.packages.create',compact('status'));
   }

   public function store(Request $request) {

       try {
         $validator = Validator::make($request->all(),[
               'package_name' => 'required|string',
               'package_desc' => 'required|string',
               'package_price' => 'required',
               'user_limit' => 'required',
               
         ]);

         if ($validator->fails()) {
             return redirect()->back()->with(array('errors' => $validator->getMessageBag()));
         }
          DB::beginTransaction();
          $data = new Package();
          $data->package_name = $request->package_name;
          $data->package_desc = $request->package_desc;
          $data->package_price = $request->package_price;
          $data->user_limit = $request->user_limit;
          $data->save();

          DB::commit();
         return redirect()->route('admin.packages')->with(['success' => 'Data Added Successfully']);
       }catch(Exception $e) {
           return redirect()->route('admin.packages')->with(['error' => 'Something Wrong Happen']);
       }


   }
   public function edit(Request $request ) {
           $id     = $request->id;
           $package  = Package::find($id);
           return view('admin.packages.edit', ['package' => $package,'id' => $id]);
    }
    
    public function AddAccount(Request $request ) {
           $id     = $request->id;
           return view('admin.packages.account', ['id' => $id]);
    }
    
    
   public function update(Request $request , $id) {
         try {
         $validator = Validator::make($request->all(),[
               'package_name' => 'required|string',
               'package_desc' => 'required|string',
               'package_price' => 'required',
               'user_limit' => 'required',
               
         ]);

         if ($validator->fails()) {
             return redirect()->back()->with(array('errors' => $validator->getMessageBag()));
         }
          DB::beginTransaction();
          $data = Package::find($id);
          $data->package_name = $request->package_name;
          $data->package_desc = $request->package_desc;
          $data->package_price = $request->package_price;
          $data->user_limit = $request->user_limit;
          $data->save();

          DB::commit();
         return redirect()->route('admin.packages')->with(['success' => 'Data Updated Successfully']);
       }catch(Exception $e) {
           return redirect()->route('admin.packages')->with(['error' => 'Something Wrong Happen']);
       }

  }
  public function delete(Request $request) {
        $id = $request->id;
        $data = Package::find($id);
        $data->delete();

        $msg = 'Data Deleted Successfully';
        return response()->json([
                   "status" =>  true,
                   "msg" => $msg
                   ],200);

          
       }
       
       
       
}
