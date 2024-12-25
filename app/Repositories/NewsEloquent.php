<?php

namespace App\Repositories;

use App\Http\Resources\commentsResource;
use Illuminate\Support\Facades\DB;
use App\Traits\ResponseJson;
use App\Models\User;
use App\Http\Resources\NewsResource;
use App\Http\Resources\LikersResource;
use App\Http\Resources\SeenUserResource;
use Validator;
use App\Http\Resources\SingleNewsREsource;

class NewsEloquent
{
    use ResponseJson;
    public function index($category = "", $subcategory = "", $status ="public")
    {
        try {
            $query = DB::table('news as news1')
            ->select([
                'news1.*',
                DB::raw('(SELECT IFNULL(count(noti_seen), 0)
                    FROM notifications
                    JOIN users ON users.user_id = noti_to AND noti_type = "Neue News"
                    JOIN news ON DATE_FORMAT(news.news_timestamp, "%Y-%m-%d %H:%i") = DATE_FORMAT(notifications.noti_timestamp, "%Y-%m-%d %H:%i")
                    WHERE noti_seen = 1 AND news.news_id = news1.news_id) as count_seen'),
                DB::raw('(SELECT IFNULL(count(like_id), 0) FROM news_likes WHERE like_news_id = news1.news_id) as count_likes'),
                DB::raw('(SELECT IFNULL(count(comment_id), 0) FROM news_comments WHERE comment_news_id = news1.news_id) as count_comments'),
                DB::raw('(SELECT GROUP_CONCAT(news_attach_path) FROM news_attachments WHERE news_attachments.news_attach_new_id = news1.news_id) as images'),
                'like_id'
            ])
            ->where('news1.news_status', $status)
            ->where('news1.news_show', 0);

        if (auth()->user()->user_type != 1 || auth()->user()->user_id != 64) {
            $query->where('news1.news_seen_by', 0);
        }

        if ($category != "") {
            $query->where('news_category', $category);
        }

        if ($subcategory != "") {
            $query->where('news_subcategory', $subcategory);
        }

         $query
            ->leftJoin('news_likes', function ($join) {
                $join->on('like_news_id', '=', 'news1.news_id')
                    ->where('like_user_id', '=', auth()->user()->user_id);
            })
            ->limit(50)
            ->orderBy('news1.news_timestamp', 'DESC');
          //  ->get();
          //  ->toArray();

        $this->mark_noti_as_seen(0);
        return NewsResource::collection($query->paginate(10));

        } catch(Exception $e) {
            $message = 'error';
            $status  = false;
            return $this->sendError( $message , $status);
        }
    }

    public function news_info($news_id)
    {
        try {
            $query = DB::table('news as news1')
            ->select([
                'news1.*',
                DB::raw('(SELECT IFNULL(count(noti_seen), 0)
                    FROM notifications
                    JOIN users ON users.user_id = noti_to AND noti_type = "Neue News"
                    JOIN news ON DATE_FORMAT(news.news_timestamp, "%Y-%m-%d %H:%i") = DATE_FORMAT(notifications.noti_timestamp, "%Y-%m-%d %H:%i")
                    WHERE noti_seen = 1 AND news.news_id = news1.news_id) as count_seen'),
                DB::raw('(SELECT IFNULL(count(like_id), 0) FROM news_likes WHERE like_news_id = news1.news_id) as count_likes'),
                DB::raw('(SELECT IFNULL(count(comment_id), 0) FROM news_comments WHERE comment_news_id = news1.news_id) as count_comments'),
                DB::raw('(SELECT GROUP_CONCAT(news_attach_path) FROM news_attachments WHERE news_attachments.news_attach_new_id = news1.news_id) as images'),
                'like_id'
            ])
            ->where('news1.news_show', 0)
            ->where('news1.news_id',$news_id);

        if (auth()->user()->user_type != 1 || auth()->user()->user_id != 64) {
            $query->where('news1.news_seen_by', 0);
        }

         $query
            ->leftJoin('news_likes', function ($join) {
                $join->on('like_news_id', '=', 'news1.news_id')
                    ->where('like_user_id', '=', auth()->guard('api')->user()->user_id);
            })
            ->limit(50)
            ->orderBy('news1.news_timestamp', 'DESC');
          //  ->get();
          //  ->toArray();
          return SingleNewsREsource::collection($query->get())->first();

        } catch(Exception $e) {
            $message = 'error';
            $status  = false;
            return $this->sendError( $message , $status);
        }
    }


    public function mark_noti_as_seen($ticket_id) {
        DB::table('notifications')->where('noti_type_id', $ticket_id)
        ->where('noti_to', auth()->guard('api')->user()->user_id)
        ->update(['noti_seen' => 1]);
    }

    public function ajax_request( $request) {

        $validator = Validator::make($request->all(), [
            'type'  => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

       $type = $request->type;

        if($type == 'insert_likes') {

            $validator = Validator::make($request->all(), [
                'news_id'  => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->first());
            }

            $user_id = auth()->guard('api')->user()->user_id;
            $news_id = $request->news_id;
            $likesid = DB::table('news_likes')
                                    ->where('like_news_id', $news_id)
                                    ->where('like_user_id', $user_id)
                                    ->first();
            if($likesid) {
                DB::table('news_likes')
                    ->where('like_news_id', $news_id)
                    ->where('like_user_id', $user_id)
                    ->delete();
                $result = DB::table('news_likes')
                            ->select(DB::raw('count(like_id) as likes'))
                            ->where('like_news_id', $news_id)
                            ->first();
                // Access the result
                if ($result) {
                    $likes  = $result->likes;
                } else {
                    $likes  = 0;
                }
                return  response()->json([ "msg" => "unlike successfully.", "data" => [] ]);
            }else {
                $data = array(
                    "like_news_id" => $news_id,
                    "like_user_id" => $user_id
                );
                insert_data('news_likes',$data);
                $result = DB::table('news_likes')
                ->select(DB::raw('count(like_id) as likes'))
                ->where('like_news_id', $news_id)
                ->first();
                // Access the result
                if ($result) {
                    $likes  = $result->likes;
                } else {
                    $likes  = 0;
                }
                return  response()->json([ "msg" => "liked successfully.", "data" => [] ]);
            }
        }
        if($type == 'show_likers'){

            $validator = Validator::make($request->all(), [
                'news_id'  => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->first());
            }
            $news_id = $request->news_id;

            return LikersResource::collection(DB::table('news_likes')
                                                ->select('users.user_firstname', 'users.user_lastname', 'users.user_id', 'users.user_avatar')
                                                ->join('users', 'users.user_id', '=', 'news_likes.like_user_id')
                                                ->where('news_likes.like_news_id', $news_id)
                                                ->get());

        }
        if($type == 'show_seen') {
            $validator = Validator::make($request->all(), [
                'news_id'  => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->first());
            }
            $news_id    = $request->news_id;
            return SeenUserResource::collection(DB::table('notifications')
                                    ->select('users.user_firstname', 'users.user_lastname', 'users.user_avatar', 'users.user_id')
                                    ->join('users', 'users.user_id', '=', 'notifications.noti_to')
                                    ->join('news', function ($join) {
                                        $join->on(DB::raw('DATE_FORMAT(news.news_timestamp, "%Y-%m-%d %H:%i")'), '=', DB::raw('DATE_FORMAT(notifications.noti_timestamp, "%Y-%m-%d %H:%i")'));
                                    })
                                    ->where('notifications.noti_type', 'Neue News')
                                    ->where('notifications.noti_seen', 1)
                                    ->where('news.news_id', $news_id)
                                    ->get());
        }

        if($type == 'show_comments'){
            $validator = Validator::make($request->all(), [
                'news_id'  => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->first());
            }
            $news_id = $request->news_id;
            return commentsResource::collection(DB::table('news_comments')
                                    ->select('news_comments.*', 'users.user_firstname' , 'users.user_avatar')
                                    ->join('users', 'users.user_id', '=', 'news_comments.comment_user_id')
                                    ->where('news_comments.comment_news_id', $news_id)
                                    ->orderBy('news_comments.comment_id', 'DESC')
                                    ->get());
        }

        if($type == 'insert_comments'){

            $validator = Validator::make($request->all(), [
                'news_id'       => 'required',
                'comment_text'  => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors()->first());
            }

            $data = array(
                'comment_user_id' => auth()->guard('api')->user()->user_id,
                'comment_text'    => $request->comment_text,
                'comment_news_id' => $request->news_id
            );
            $comment_id  = insert_data('news_comments', $data) ;

            if($comment_id) {
                 $comment =commentsResource::collection(DB::table('news_comments')
                 ->select('news_comments.*', 'users.user_firstname' , 'users.user_avatar')
                 ->join('users', 'users.user_id', '=', 'news_comments.comment_user_id')
                 ->where('news_comments.comment_news_id', $request->news_id)
                 ->where('news_comments.comment_id', $comment_id)
                 ->orderBy('news_comments.comment_id', 'DESC')
                 ->get())->first();
            }else {
                 $comment = [];
            }

            return  response()->json([ "msg" => "comment addeded successfully.", "data" =>  $comment]);
        }

      /*  if($type == 'publish_news'){
            $id = $_POST['data'];
            $this->Global_model->update_row('news', 'news_id ='.$id, array('news_status'=>'public'));
        }

        if($type == 'unpublish_news'){
            $id = $_POST['data'];
            $this->Global_model->update_row('news', 'news_id ='.$id, array('news_status'=>'private'));
        }*/
    }




}
