<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Task;
use App\Models\Log;
use App\Models\Tag;
use App\Models\TaskTeam;
use App\Models\TaskGuest;
use App\Models\TaskTag;
use DataTables;
use DB;
use Validator;
use Auth;
class tagsController extends Controller
{

   public function index() {
        $datas = Tag::where(['account_id' => Auth::user()->account_id])->orderBy('priority','desc')->get();
        $status = 0;
        return view('admin.tags.index',compact('datas','status'));
    }

    public function create() {
       $categories =  Category::where(['account_id' => Auth::user()->account_id])->get() ;
       return view('admin.tags.create')->with(compact('categories'));
   }

   public function store(Request $request) {
         $validator = Validator::make($request->all(),[
               'tag_name' => 'required|string|unique:tags',
         ]);

         if ($validator->fails()) {
             return redirect()->back()->with(array('errors' => $validator->getMessageBag()));
         }

          foreach($request->category_id  as $cat_id) {
              $data = new Tag();
              $data->tag_name       =    $request->tag_name;
              $data->cat_id         =    $cat_id;
              $data->account_id     =   Auth::user()->account_id;
              $data->save();
          }
        return redirect()->route('admin.tags.create')->with(['success' => 'Data Added Successfully']);
   }
   public function edit(Request $request ) {
           $id     = $request->id;
           $category  = Category::find($id);
           return view('admin.categories.edit', ['category' => $category,'id' => $id]);
    }
   public function update(Request $request , $id) {
         try {
             $validator = Validator::make($request->all(),[
                   'category_name' => 'required|string|unique:categories,category_name,'.$id,
             ]);

               if ($validator->fails()) {
                   return redirect()->route('admin.categories.edit')->with(array('errors' => $validator->getMessageBag()));
               }
              DB::beginTransaction();
              $data =Category::find($id);
              $data->category_name = $request->category_name;
              $data->category_color = $request->category_color;
              $data->save();
              $log = new Log();
              $log->log_desc = "The User ".Auth::user()->user_name .' Updated The Kategorie ' . $data->category_name ;
              $log->log_user_id = Auth::user()->id;
              $log->log_cat_id = $id;
              $log->account_id = auth()->user()->account_id;
              $log->save();
              DB::commit();
             return redirect()->route('admin.categories')->with(['success' => 'Data Updated Successfully']);
           }catch(Exception $e) {
               return redirect()->route('admin.categories')->with(['error' => 'Something Wrong Happen']);
           }

  }
  public function delete(Request $request) {
        $id = $request->id;
        $tag_data = TaskTag::where('tag_id',$id)->first() ;
         if(!empty($tag_data)) {
             $msg = 'Deleted All Tasks Related To This Category First';
             return response()->json([
                             "status" =>  false,
                             "msg" => $msg
                             ],200);
        }
       else {
            $data = Tag::find($id);
            $data->delete();
            $msg = 'Data Deleted Successfully';
            return response()->json([
                       "status" =>  true,
                       "msg" => $msg
                       ],200);
              }
       }

       public function addTag(Request $request) {

       try {
         $validator = Validator::make($request->all(),[
               'tag_name' => 'required|string',
               'cat_id' => 'required',

         ]);

         if ($validator->fails()) {
             return redirect()->back()->with(array('errors' => $validator->getMessageBag()));
         }
          DB::beginTransaction();
          $data = new Tag();
          $data->tag_name = $request->tag_name;

          $tagcats = $request->input('cat_id');
   //   dd( count($tagcats) );
       if(!empty($tagcats)) {
          for($i=0;$i<count($tagcats);$i++) {
             $data = new Tag();
             $data->tag_name = $request->tag_name;
             $data->cat_id   =  $tagcats[$i] ;
             $data->account_id = auth()->user()->account_id;
             $data->save();
          }
        }
          $data->save();
          $log = new Log();
          $log->log_desc = "The User ".Auth::user()->user_name .' Add A New Tag ' . $data->tag_name ;
          $log->log_user_id = Auth::user()->id;
          $log->account_id = auth()->user()->account_id;
          $log->save();
          DB::commit();
          if(!empty(session()->get('catt_id'))) {
             return redirect()->route('admin.cat.tasks', ['cat_id' => session()->get('catt_id'), 'status' => 0])->with(['success' => 'Data Added Successfully']);
          }else {
               return redirect() -> route('admin.dashboard')->with(['success' => 'Data Added Successfully']);
          }

       }catch(Exception $e) {
            return redirect() -> route('admin.dashboard')->with(['error' => 'Something Wrong Happen']);
       }


   }

     public function allTasks($cat_id,$status) {
          session()->put('catt_id' , $cat_id);
         $tags = Tag::where('cat_id',$cat_id)->get();
         $categories = Category::where('account_id' , auth()->user()->account_id)->get();
         $tasksids = \App\Models\TaskTeam::where('account_id' , auth()->user()->account_id)->where('user_id',auth()->user()->id)->pluck('task_id');
      if($cat_id == 0) {


        if($status == 1) {
               $title = 'Pripo Completed';
               if(auth()->user()->role == 1) {
                  $tasks =Task::where('task_status' , 1)->get();
               }else {
               $tasks =Task::where('task_added_by' , auth()->user()->id)->where('task_status' , 1)
                           ->Orwhere('task_responsible' , auth()->user()->id)->where('task_status' , 1)
                           ->OrWhere('task_added_by' , auth()->user()->id)->where('task_status' , 1)
                           ->OrWhere('task_responsible' , auth()->user()->id)->where('task_status' , 1)
                           ->orWhereIn('id',$tasksids)->where('task_status' , 1)
                           ->orWhereIn('id',$tasksids)->where('task_status' , 1)->orderBy('task_priority' , 'asc')->get();
              }
          }else if($status ==2) {
                $title = 'Pripo Deleted';
                if(auth()->user()->role == 1) {
                   $tasks =Task::where('task_status' , 2)->get();
                }else {
                $tasks =Task::where('task_added_by' , auth()->user()->id)->where('task_status' , 2)
                            ->Orwhere('task_responsible' , auth()->user()->id)->where('task_status' , 2)
                            ->OrWhere('task_added_by' , auth()->user()->id)->where('task_status' , 2)
                            ->OrWhere('task_responsible' , auth()->user()->id)->where('task_status' , 2)
                            ->orWhereIn('id',$tasksids)->where('task_status' , 2)
                            ->orWhereIn('id',$tasksids)->where('task_status' , 2)->orderBy('task_priority' , 'asc')->get();
                }
          }else {
               $title = 'Pripo';
               if(auth()->user()->role == 1) {
                  $tasks =Task::where('task_status' , 0)->get();
               }else {
            $tasks =Task::where('task_added_by' , auth()->user()->id)->where('task_status' , 0)
                        ->Orwhere('task_responsible' , auth()->user()->id)->where('task_status' , 0)
                        ->OrWhere('task_added_by' , auth()->user()->id)->where('task_status' , 0)
                        ->OrWhere('task_responsible' , auth()->user()->id)->where('task_status' , 0)
                        ->orWhereIn('id',$tasksids)->where('task_status' , 0)
                        ->orWhereIn('id',$tasksids)->where('task_status' , 0)->orderBy('task_priority' , 'asc')->get();
              }

          }

      }else {
        if($status == 1) {
               $title = 'Pripo Completed';
           $tasks =Task::where('task_category_id',$cat_id)->where('task_added_by' , auth()->user()->id)->where('task_status' , 1)
                                  ->Orwhere('task_category_id',$cat_id)->where('task_responsible' , auth()->user()->id)->where('task_status' , 1)
                                  ->OrWhere('task_category_id_two',$cat_id)->where('task_added_by' , auth()->user()->id)->where('task_status' , 1)
                                  ->OrWhere('task_category_id_two',$cat_id)->where('task_responsible' , auth()->user()->id)->where('task_status' , 1)
                                  ->Orwhere('task_category_id',$cat_id)->whereIn('id',$tasksids)->where('task_status' , 1)
                                  ->Orwhere('task_category_id_two',$cat_id)->whereIn('id',$tasksids)->where('task_status' , 1)->orderBy('task_priority' , 'asc')->get();
          }else if($status ==2) {
                $title = 'Pripo Deleted';
            $tasks =Task::where('task_category_id',$cat_id)->where('task_added_by' , auth()->user()->id)->where('task_status' , 2)
                        ->Orwhere('task_category_id',$cat_id)->where('task_responsible' , auth()->user()->id)->where('task_status' , 2)
                        ->OrWhere('task_category_id_two',$cat_id)->where('task_added_by' , auth()->user()->id)->where('task_status' , 2)
                        ->OrWhere('task_category_id_two',$cat_id)->where('task_responsible' , auth()->user()->id)->where('task_status' , 2)
                        ->Orwhere('task_category_id',$cat_id)->whereIn('id',$tasksids)->where('task_status' , 2)
                        ->Orwhere('task_category_id_two',$cat_id)->whereIn('id',$tasksids)->where('task_status' , 2)->orderBy('task_priority' , 'asc')->get();
          }else {
               $title = 'Pripo';

            $tasks =Task::where('task_category_id',$cat_id)->where('task_added_by' , auth()->user()->id)->where('task_status' , 0)
                        ->Orwhere('task_category_id',$cat_id)->where('task_responsible' , auth()->user()->id)->where('task_status' , 0)
                        ->OrWhere('task_category_id_two',$cat_id)->where('task_added_by' , auth()->user()->id)->where('task_status' , 0)
                        ->OrWhere('task_category_id_two',$cat_id)->where('task_responsible' , auth()->user()->id)->where('task_status' , 0)
                        ->Orwhere('task_category_id',$cat_id)->whereIn('id',$tasksids)->where('task_status' , 0)
                        ->Orwhere('task_category_id_two',$cat_id)->whereIn('id',$tasksids)->where('task_status' , 0)->orderBy('task_priority' , 'asc')->get();

          }
      }

         return view('admin.categories.all_tasks',compact('tasks','tags','categories','title','status','cat_id'));
     }

     public function allCatTagTasks($cat_id,$tag_id,$status) {

         $tags = Tag::where('cat_id',$cat_id)->get();
         $categories = Category::where('account_id' , auth()->user()->account_id)->get();
         $tasksids = \App\Models\TaskTeam::where('account_id' , auth()->user()->account_id)->where('user_id',auth()->user()->id)->pluck('task_id');
         $tasksids2 =    TaskTag::where('tag_id',$tag_id)->pluck('task_id');
         session()->put('catt_id' , $cat_id);
         session()->put('tagg_id' , $tag_id);
         if($status == 1) {
              $title = 'Pripo Completed';
           if(!empty($tasksids) && count($tasksids) > 0) {
             $tasks =Task::whereIn('id',$tasksids2)->where('task_added_by' , auth()->user()->id)->where('task_status' , 1)
                         ->orWhereIn('id',$tasksids2)->where('task_responsible' , auth()->user()->id)->where('task_status' , 1)
                         ->orWhereIn('id',$tasksids2)->whereIn('id',$tasksids)->where('task_status' , 1)->orderBy('task_priority' , 'asc')->get();
             }else {
                    $tasks =Task::whereIn('id',$tasksids2)->where('task_added_by' , auth()->user()->id)->where('task_status' , 1)
                           ->orWhereIn('id',$tasksids2)->where('task_responsible' , auth()->user()->id)->where('task_status' , 1)->orderBy('task_priority' , 'asc')->get();
             }
             }else if($status == 2) {
                 $title = 'Pripo Deleted';
               if(!empty($tasksids) && count($tasksids) > 0) {
                 $tasks =Task::whereIn('id',$tasksids2)->where('task_added_by' , auth()->user()->id)->where('task_status' , 2)
                             ->orWhereIn('id',$tasksids2)->where('task_responsible' , auth()->user()->id)->where('task_status' , 2)
                             ->orWhereIn('id',$tasksids2)->whereIn('id',$tasksids)->where('task_status' , 1)->orderBy('task_priority' , 'asc')->get();
                 }else {
                        $tasks =Task::whereIn('id',$tasksids2)->where('task_added_by' , auth()->user()->id)->where('task_status' , 2)
                               ->orWhereIn('id',$tasksids2)->where('task_responsible' , auth()->user()->id)->where('task_status' , 2)->orderBy('task_priority' , 'asc')->get();
                 }

             }else {
                   $title = 'Pripo';
                 if(!empty($tasksids) && count($tasksids) > 0) {
                   $tasks =Task::whereIn('id',$tasksids2)->where('task_added_by' , auth()->user()->id)->where('task_status' , 0)
                               ->orWhereIn('id',$tasksids2)->where('task_responsible' , auth()->user()->id)->where('task_status' , 0)
                               ->orWhereIn('id',$tasksids2)->whereIn('id',$tasksids)->where('task_status' , 0)->orderBy('task_priority' , 'asc')->get();
                   }else {
                          $tasks =Task::whereIn('id',$tasksids2)->where('task_added_by' , auth()->user()->id)->where('task_status' , 0)
                                 ->orWhereIn('id',$tasksids2)->where('task_responsible' , auth()->user()->id)->where('task_status' , 0)->orderBy('task_priority' , 'asc')->get();
                   }
             }
         return view('admin.categories.all_cat_tag_tasks',compact('tasks','tags','categories','title','status','cat_id','tag_id'));
     }

    public function editTagModal(Request $request)
    {
        $tag = Tag::find($request->id);
        if (!$tag) {
            return response()->json(['error' => 'tag not found']);
        }

        $view = view('front.models.edit_tag',compact('tag'))->render();
        return response()->json(['html' => $view]);
    }

    public function updateTagModal(Request $request){
        try {

            $id = decrypt($request->id);
            $tag = Tag::find($id);

            if (!$tag) {
                return response()->json(['message' => 'invalid data']);
            }
            $validator = $request->validate([
                'name' => 'required',
                'priority' => 'required',
            ]);

            $tag->tag_name = $request->name;
            $tag->priority = $request->priority;

            $tag->save();
            return response()->json(['success' => 'tag data updated']);

        }catch (\Exception $exception){
            return response()->json(['error'=>$exception->getMessage()]);
        }

    }



}
