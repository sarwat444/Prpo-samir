<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Task;
use App\Models\Comment;
use App\Models\SubTask ;
use App\Models\Log;
use App\Models\Replay;
use DataTables;
use DB;
use Validator;
use Auth;
class CommentsController extends Controller
{
     public function index() {

        $comments =  Comment::orderBy('id' , 'Desc')->get() ;

        $notes = [] ;
         foreach($comments as $comment){

             if(!empty($comment->tags)) {
                 $tags = explode(',', $comment->tags);

                 if (in_array(Auth()->user()->id, $tags)) {

                     $notes[] = $comment;

                 }
             }
         }
        //Send Taged  Replays

        $replays = [] ;
        $all_replays  =  Replay::orderBy('id' , 'Desc')->get() ;
        foreach($all_replays  as $replay){

            if(!empty($replay->tags)) {
                $tags = explode(',', $replay->tags);

                if (in_array(Auth()->user()->id, $tags)) {

                    $replays[] = $replay;

                }
            }
        }



        $status = 0;
        return view('admin.notes.user_notes',compact('notes','status' , 'replays'));




    }

public function  filtercomments(Request $request)
{

        $new = strtotime($request->end_due_date);
        $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
        $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
        $erledigt = (request()->has('erledigt')) ?  $request->erledigt : 0;
        $seen = (request()->has('seen')) ?  $request->seen : 0;
        if($start_due_date == '1970-01-01'){
            $start_due_date = null ;
        }
        if($end_due_date == '1970-01-01'){
            $end_due_date = null ;
        }
        else{
            $end_due_date = date('Y-m-d', strtotime("+1 day".$request->end_due_date));
        }
        //Two Dates Only
        if (!empty($start_due_date)  && !empty($end_due_date) &&  $erledigt == 0 && $seen == 0  )
        {
            $comments = Comment::where('account_id' , auth()->user()->account_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
            $notes = [] ;
            foreach($comments as $comment){
                if(!empty($comment->tags)) {
                    $tags = explode(',', $comment->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        $notes[] = $comment;
                    }
                }
            }

        }
       //Two Dates And ERldigate
        if (!empty($start_due_date) && !empty($end_due_date) &&  $erledigt == 1  && $seen == 0 )
        {
            $comments = Comment::where('account_id' , auth()->user()->account_id)->where('done', $erledigt)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
            $notes = [] ;
            foreach($comments as $comment){
                if(!empty($comment->tags)) {
                    $tags = explode(',', $comment->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        $notes[] = $comment;
                    }
                }
            }

        }
       // Two dates And Done
        if (!empty($start_due_date) && !empty($end_due_date) &&   $erledigt == 0 && $seen == 1   )
    {
        $comments =  Comment::whereBetween('created_at', [$start_due_date, $end_due_date])->get();

        $notes = [] ;
        foreach($comments as $comment){
            $read_users =  json_decode($comment['readby']) ;
            if(!empty($comment->tags)) {

                $tags = explode(',', $comment->tags);

                if (in_array(Auth()->user()->id, $tags)) {
                    if(!empty($read_users)) {
                        if (in_array(Auth()->user()->id, $read_users)) {
                            $notes[] = $comment;
                        }
                    }
                }
            }
        }

    }

        if (empty($start_due_date) && empty($end_due_date) &&    $erledigt == 1 && $seen == 0 )
        {

            $comments = Comment::where('account_id' , auth()->user()->account_id)->where('done', $erledigt)->get();
            $notes = [] ;
            foreach($comments as $comment){
                if(!empty($comment->tags)) {
                    $tags = explode(',', $comment->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        $notes[] = $comment;
                    }
                }
            }

        }
        if (empty($start_due_date) && empty($end_due_date) &&   $erledigt == 0 && $seen == 1   )
        {
            $comments =  Comment::where('status' , '!=' , 1)->get() ;
            $notes = [] ;
            foreach($comments as $comment){
                $read_users =  json_decode($comment['readby']) ;
                if(!empty($comment->tags)) {
                    $tags = explode(',', $comment->tags);
                    if (in_array(Auth()->user()->id, $tags)) {
                        if(!empty($read_users)) {
                            if (in_array(Auth()->user()->id, $read_users)) {
                                $notes[] = $comment;
                            }
                        }
                    }
                }
            }

        }

        if (!empty($start_due_date) && !empty($end_due_date) &&   $erledigt == 1 && $seen == 1   )
        {

            $comments =  Comment::where('done', $erledigt)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();

            $notes = [] ;
            foreach($comments as $comment){
                $read_users =  json_decode($comment['readby']) ;
                if(!empty($comment->tags)) {

                    $tags = explode(',', $comment->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        if(!empty($read_users)) {
                            if (in_array(Auth()->user()->id, $read_users)) {
                                $notes[] = $comment;
                            }
                        }
                    }
                }
            }

        }
        $user_id = auth::user()->id ;
        $data = view('admin.notes.commentfilter',compact('notes' , 'user_id'))->render();
        return response()->json(['options'=>$data]);
    }


    public function  filterReplays(Request $request)
{

        $new = strtotime($request->end_due_date);
        $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
        $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
        $seen = (request()->has('seen')) ?  $request->seen : 0;
        if($start_due_date == '1970-01-01'){
            $start_due_date = null ;
        }
        if($end_due_date == '1970-01-01'){
            $end_due_date = null ;
        }
        else{
            $end_due_date = date('Y-m-d', strtotime("+1 day".$request->end_due_date));
        }

        if (empty($start_due_date) && empty($end_due_date)  && $seen == 0)
        {


            $replays =  Replay::get() ;
            $replays_arr = [] ;
            foreach($replays as $replay){
                $read_users =  json_decode($replay['is_read']) ;
                if(!empty($replay->tags)) {

                    $tags = explode(',', $replay->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                                $replays_arr[] = $replay;
                    }
                }
            }

        }

        if (!empty($start_due_date)  && !empty($end_due_date) && $seen == 0  )
        {
            $replays = Replay::whereBetween('created_at', [$start_due_date, $end_due_date])->get();
            $replays_arr = [] ;
            foreach($replays as $replay){
                if(!empty($replay->tags)) {
                    $tags = explode(',', $replay->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        $replays_arr[] = $replay;
                    }
                }
            }

        }

        if (!empty($start_due_date) && !empty($end_due_date) && $seen == 1 )
        {

            $replays =  Replay::whereBetween('created_at', [$start_due_date, $end_due_date])->get();
            $replays_arr = [] ;
            foreach($replays as $replay){
                $read_users =  json_decode($replay['is_read']) ;
                if(!empty($replay->tags)) {

                    $tags = explode(',', $replay->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        if(!empty($read_users)) {
                            if (in_array(Auth()->user()->id, $read_users)) {
                                $replays_arr[] = $replay;
                            }
                        }
                    }
                }
            }

        }


        if (empty($start_due_date) && empty($end_due_date)  && $seen == 1   )
        {
            $replays =  Replay::get() ;
            $replays_arr = [] ;
            foreach($replays as $replay){
                $read_users =  json_decode($replay['is_read']) ;
                if(!empty($replay->tags)) {

                    $tags = explode(',', $replay->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        if(!empty($read_users)) {
                            if (in_array(Auth()->user()->id, $read_users)) {
                                $replays_arr[] = $replay;
                            }
                        }
                    }
                }
            }

        }

        $user_id = auth::user()->id ;
        $data = view('admin.notes.replaysfillter',compact('replays_arr' , 'user_id'))->render();
        return response()->json(['options'=>$data]);
    }

    //Filter Replays And Comments



    public function  filltercommentsandreplays(Request $request)
    {

            $new = strtotime($request->end_due_date);
            $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
            $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
            $erledigt = (request()->has('erledigt')) ?  $request->erledigt : 0;
            $seen = (request()->has('seen')) ?  $request->seen : 0;
            if($start_due_date == '1970-01-01'){
                $start_due_date = null ;
            }
            if($end_due_date == '1970-01-01'){
                $end_due_date = null ;
            }
            else{
                $end_due_date = date('Y-m-d', strtotime("+1 day".$request->end_due_date));
            }

            if (empty($start_due_date) && empty($end_due_date)  && $seen == 0 && $erledigt == 0 )
            {

                $comments =  Comment::with('added_by','task')->get() ;
                $notes = [] ;
                foreach($comments as $comment){

                    if(!empty($comment->tags)) {

                        $tags = explode(',', $comment->tags);

                        if (in_array(Auth()->user()->id, $tags)) {
                                    $notes[] = $comment;
                        }
                    }
                }

                $replays =  Replay::with('user')->get() ;
                $replays_arr = [] ;
                foreach($replays as $replay){

                    if(!empty($replay->tags)) {

                        $tags2 = explode(',', $replay->tags);

                        if (in_array(Auth()->user()->id, $tags2)) {
                                    $replays_arr[] = $replay;
                        }
                    }
                }

            }





            if (!empty($start_due_date)  && !empty($end_due_date) && $seen == 0  && $erledigt == 0 )
            {

                $replays = Replay::with('user')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                $replays_arr = [] ;
                foreach($replays as $replay){
                    if(!empty($replay->tags)) {
                        $tags = explode(',', $replay->tags);

                        if (in_array(Auth()->user()->id, $tags)) {
                            $replays_arr[] = $replay;
                        }
                    }
                }

                $comments = Comment::with('added_by')->where('account_id' , auth()->user()->account_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                $notes = [] ;
                foreach($comments as $comment){
                    if(!empty($comment->tags)) {
                        $tags2 = explode(',', $comment->tags);

                        if (in_array(Auth()->user()->id, $tags2)) {
                            $notes[] = $comment;
                        }
                    }
             }



            }

            if (!empty($start_due_date) && !empty($end_due_date) && $seen == 1 && $erledigt == 0 )
            {


                $replays =  Replay::with('user')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();

                $replays_arr = [] ;
                foreach($replays as $replay){
                    $read_users =  json_decode($replay['is_read']) ;
                    if(!empty($replay->tags)) {

                        $tags = explode(',', $replay->tags);

                        if (in_array(Auth()->user()->id, $tags)) {
                            if(!empty($read_users)) {
                                if (in_array(Auth()->user()->id, $read_users)) {
                                    $replays_arr[] = $replay;
                                }
                            }
                        }
                    }
                }

                $comments =  Comment::with('added_by' , 'task' )->whereBetween('created_at', [$start_due_date, $end_due_date])->where('status' , '!=' , 1 )->get();

                $notes = [] ;
                foreach($comments as $comment){
                    $read_users =  json_decode($comment['readby']) ;
                    if(!empty($comment->tags)) {

                        $tags = explode(',', $comment->tags);

                        if (in_array(Auth()->user()->id, $tags)) {
                            if(!empty($read_users)) {
                                if (in_array(Auth()->user()->id, $read_users)) {
                                    $notes[] = $comment;
                                }
                            }
                        }
                    }
                }

            }


            if (empty($start_due_date) && empty($end_due_date)  && $seen == 1   )
            {
                $replays =  Replay::with('user')->get() ;
                $replays_arr = [] ;
                foreach($replays as $replay){
                    $read_users =  json_decode($replay['is_read']) ;
                    if(!empty($replay->tags)) {

                        $tags = explode(',', $replay->tags);

                        if (in_array(Auth()->user()->id, $tags)) {
                            if(!empty($read_users)) {
                                if (in_array(Auth()->user()->id, $read_users)) {
                                    $replays_arr[] = $replay;
                                }
                            }
                        }
                    }
                }


                $comments =  Comment::with('added_by' , 'task')->where('status' , '!=' , 1 )->get() ;
                $notes = [] ;
                foreach($comments as $comment){
                    $read_users =  json_decode($comment['readby']) ;
                    if(!empty($comment->tags)) {

                        $tags = explode(',', $comment->tags);

                        if (in_array(Auth()->user()->id, $tags)) {
                            if(!empty($read_users)) {
                                if (in_array(Auth()->user()->id, $read_users)) {
                                    $notes[] = $comment;
                                }
                            }
                        }
                    }
                }

            }

            $user_id = auth::user()->id ;
            $data = view('admin.notes.replaysandcommentsfillter',compact('replays_arr' , 'notes' , 'user_id'))->render();
            return response()->json(['options'=>$data]);
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
       public  function deletecomment(Request  $request)
       {

           $data = $request->all() ;
           $readedcomment  = Comment::where([ 'id' => $data['comment_id']])->first();

           if(empty($readedcomment->readby))
           {
               $readedcomment->readby  =  json_encode(array($data['readby']));
           }
           else
           {
               $users_readed  = json_decode(  $readedcomment->readby ) ;
               if(!in_array( $data['readby']  ,$users_readed )) {
                   if($request->value == 1) {
                       array_push($users_readed, $data['readby']);
                       $readedcomment->readby = json_encode($users_readed);
                   }

               }else {
                       if($request->value == 0) {
                          $key = array_search($data['readby'] , $users_readed) ;
                          unset($users_readed[$key]);
                           $readedcomment->readby  = array_values($users_readed);
                        }
                   }

           }
           $readedcomment->save() ;

       /*End Of update Replays */

           $replays = Replay::where('comment_id' , $data['comment_id'])->get();
           foreach($replays as  $replay)
           {
               if (empty($replay->is_read) || $replay->is_read == NULL) {
                   $replay->is_read = json_encode(array(Auth::user()->id));
                   $replay->save();
               } else {
                   $arr = json_decode($replay->is_read);
                   if (!in_array(Auth::user()->id, $arr)) {
                       array_push($arr, Auth::user()->id);
                       $replay->is_read = json_encode($arr);
                       $replay->save();
                   }
               }

           }

       }
    public  function donecomment(Request  $request)
    {
        $data = $request->all() ;
        $donecomment  = Comment::where([ 'id' => $data['comment_id']])->first();
        $donecomment->done = $data['value'];
        $donecomment->save() ;

    }

    public function  filtertests(Request $request)
    {

            $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
            $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
            if(empty($start_due_date)) {
                $start_due_date = null;
            }
            if(empty($end_due_date)) {
                $end_due_date = null;
            }
            $subtasks = SubTask::where(['tester' => auth::user()->id ])->whereBetween('assigned_at', [$start_due_date." 00:00:00", $end_due_date." 23:59:59"])->get();
            $data = view('admin.subtasks.testfilter',compact('subtasks'))->render();
            return response()->json(['options'=>$data]);

    }
}
