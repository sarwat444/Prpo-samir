<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Models\ChatRoom;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\Message;
use App\Http\Resources\Web\RoomChatResource;
use App\Http\Resources\Web\UserResource;
use App\Traits\ChatResponseJson;
use App\Events\GroupMessageEvent;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;
use App\Models\GroupSeen;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class WebChatEloquent
{

    use ChatResponseJson;

    public function send_message($request)
    {
        try {
            DB::beginTransaction();
            $pusher_data = [];
            if ($request->room_type == "Private") {

                $pusher_data = $this->sendPrivateMessage($request);
            } else {

                $pusher_data = $this->sendGroupMessage($request);
            }
            DB::commit();
            $sucess = true;
            return $this->sendResponse($pusher_data);

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $message = 'error';
            $status = false;
            return $this->sendError($message, $status);
        }
    }

    public function chat_rooms()
    {
        $id = auth()->user()->id;
        $result = UserResource::collection(ChatRoom::leftJoin('users as guest', 'guest.id', '=', 'chat_room_users')
            ->select('chat_rooms.*',
                'guest.id as guest_id', 'guest.first_name as guest_firstname', 'guest.last_name as guest_lastname', 'guest.image as guest_avatar',
                DB::raw('
                                                    (SELECT MAX(chat_timestamp)
                                                    FROM chat
                                                    WHERE chat.chat_room_id = chat_rooms.chat_room_id AND ' . (auth()->user()->id == 'chat.to' ? 'chat.deleted_to = 0' : 'chat.deleted_from = 0') . '
                                                    ) as last_msg'
                ),
                DB::raw('
                                            (SELECT chat_message
                                             FROM chat
                                             WHERE chat.chat_room_id = chat_rooms.chat_room_id AND ' . (auth()->user()->id == 'chat.to' ? 'chat.deleted_to = 0' : 'chat.deleted_from = 0') . '
                                             ORDER BY chat_timestamp DESC
                                             LIMIT 1
                                            ) AS msg'),

                DB::raw('
                                            (SELECT chat_seen
                                             FROM chat
                                             WHERE chat.chat_room_id = chat_rooms.chat_room_id AND ' . (auth()->user()->id == 'chat.to' ? 'chat.deleted_to = 0' : 'chat.deleted_from = 0') . '
                                             ORDER BY chat_timestamp DESC
                                             LIMIT 1
                                            ) AS is_seen'),

                DB::raw('(SELECT chat_message_type FROM chat WHERE chat.chat_room_id = chat_rooms.chat_room_id ORDER BY chat_timestamp DESC LIMIT 1) AS chat_message_type'),
                DB::raw('(SELECT voice_duration FROM chat WHERE chat.chat_room_id = chat_rooms.chat_room_id ORDER BY chat_timestamp DESC LIMIT 1) AS voice_duration'),
                DB::raw('(SELECT COUNT(chat_seen) FROM chat WHERE chat.chat_to = ' . $id . ' AND chat.chat_seen = 0 AND chat.chat_room_id = chat_rooms.chat_room_id ) AS count'))
            ->whereRaw('FIND_IN_SET(?, chat_room_users) OR chat_room_creator = ?', [$id, $id])
            ->where('is_blocked', 0)
            ->orderBy('last_msg', 'Desc')
            ->get());

        return $result;
    }

    public function room_messages($room_id, $type)
    {
        $id = auth()->user()->id;
        if ($type == "Private")
        {
            // $room_id mean the personthat i chat with him
            $result = RoomChatResource::collection(Chat::with('sender' , 'reciver')
                ->select('chat.*', 'users.first_name', 'users.last_name', 'users.image', 'to.first_name', 'to.first_name', 'to.image', 'chat_rooms.chat_room_type')
                ->join('chat_rooms', 'chat_rooms.chat_room_id', '=', 'chat.chat_room_id')
                ->join('users', 'users.id', '=', 'chat.chat_from')
                ->join('users as to', 'to.id', '=', 'chat.chat_to')
                ->where('chat.chat_room_id', $room_id)
                ->where('chat.chat_to', $id)
                ->where('chat.deleted_for_everyone', 0)
                ->where('chat.deleted_to', 0)
                ->where('chat_rooms.chat_room_type', 'Private')
                ->orWhere('chat.chat_room_id', $room_id)
                ->where('chat.chat_from', $id)
                ->where('chat.deleted_for_everyone', 0)
                ->where('chat.deleted_from', 0)
                ->where('chat_rooms.chat_room_type', 'Private')
                ->orderBy('chat_timestamp', 'ASC')
                ->get());

            $room = ChatRoom::select('*')
                ->where('chat_room_creator', $id)
                ->where('chat_room_type', $type)
                ->orWhere('chat_room_users', $id)
                ->where('chat_room_type', $type)
                ->first();

            if ($room) {
                if (!empty($result) && count($result) > 0) {
                    Chat::with('reciver')->where('chat_room_id', $room->chat_room_id)
                        ->where('chat_to', $id)
                        ->where('chat_seen', 0)
                        ->update(['chat_seen' => 1]);
                }
            }


        } else {
            $result = RoomChatResource::collection(Chat::with('sender')->select('chat.*', 'chat_rooms.chat_room_type')
                ->where('chat.chat_room_id', $room_id)
                ->join('chat_rooms', 'chat_rooms.chat_room_id', '=', 'chat.chat_room_id')
                ->where('chat_rooms.chat_room_type', 'Gruppe')
                ->where('chat.deleted_for', '!=', $id)
                ->orderBy('chat_timestamp', 'ASC')
                ->get());

            $gorup_seen = GroupSeen::where(['id' => $id, 'group_id' => $room_id])->first();

            if ($gorup_seen) {
                $gorup_seen->un_read = 0;
                $gorup_seen->save();
            }

        }
        return $result;
    }

    private function replace_string($text, $searchWord)
    {

        $arr = explode(' ', $text);
        $url = "";
        $new_txt = array();

        foreach ($arr as $a) {
            foreach ($searchWord as $word) {
                if (strpos($a, $word) === 0) {
                    $client_id = substr($a, 4);
                    switch ($word) {
                        case '#kid':
                            $url = "Clients/client_dashboard/" . $client_id;
                            break;
                        case '#bid':
                            $url = "Advice/to_page/financehouse/" . $client_id;
                            break;
                        case '#eid':
                            $url = "Clients/edit_client/" . $client_id;
                            break;
                        case '#iid':
                            $url = "Inspire/contract_details/" . $client_id;
                            break;
                        case '#hid':
                            $url = "HCo/hco_details/investments/" . $client_id;
                            break;
                        case '#pid':
                            $url = "HCo_projects/project_details/" . $client_id;
                            break;
                    };
                    $a = '<a target="_blank" style="color:#888ea8" href="' . url($url) . '">#' . $client_id . '</a>';
                }
            }
            array_push($new_txt, $a);
        }
        return implode(' ', $new_txt);
    }

    private function get_room_info_by_ids($from, $to, $type = 'private')
    {

        $chatRoom = ChatRoom::select('*')
            ->where('chat_room_creator', $from)
            ->where('chat_room_users', $to)
            ->where('chat_room_type', $type)
            ->first();

        return $chatRoom;
    }

    private function get_room_info_by_id($room_id)
    {
        $row = DB::table('chat_rooms')
            ->select('*')
            ->where('chat_room_id', $room_id)
            ->first();
        return $row;
    }

    public function addGroup($request) {
        try {
            DB::beginTransaction();
            $name = $request->group_name;
            if($request->users) {
                $request->users = json_decode($request->users) ;
                $user = implode(',', $request->users);
            } else {
                $user = auth()->user()->id;
            }
            $insert_data = array(
                'chat_room_creator'       => auth()->user()->id,
                'chat_room_users'         => $user,
                'chat_room_type'          => 'Gruppe',
                'chat_room_name'          => $name,
                'chat_room_details'       => $request->chat_room_details,
                'chat_room_last_msg_time' => Carbon::now('Africa/Cairo')->toDateTimeString(),
            );
            $room_id = insert_data('chat_rooms', $insert_data);
            if ($request->group_image) {
                $file      = $request->file('group_image');
                $fileName  = uniqid() . '_' . trim($file->getClientOriginalName());
                $fileName  = str_replace(' ', '', $fileName);
                $file->storeAs('chat_room_images/' . $room_id .'/' ,   $fileName ,  's3');
                $path2     = Storage::disk('s3')->url('chat_room_images/'. $room_id .'/'  .$fileName);
                ChatRoom::where('chat_room_id', $room_id)->update([
                    'chat_room_image' =>  $path2
                ]);
            }
            DB::commit();
            $sucess = true ;
            return redirect()->back()->with('success' , 'Group added  Successfuly') ;
        }catch (\Exception $e) {
            DB::rollback();
            $message = 'error';
            $status  = false;
            return $this->sendError( $message , $status);
        }
    }

    public function editGroup($request)
    {

        try {
            $room_id = $request->group_id;
            $group = ChatRoom::where(['chat_room_id' => $room_id, 'chat_room_creator' => auth()->user()->id, 'chat_room_type' => 'Gruppe'])->first();
            if ($group) {
                $name = $request->group_name;
                if ($request->group_image) {
                    $path = 'halalcheck-crm.de/documents/chat_room_images/' . $room_id;
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $file = $request->file('group_image');
                    $fileName = uniqid() . '_' . trim($file->getClientOriginalName());

                    $path2 = Storage::disk('s3')->url('chat_room_images/' . $room_id . '/' . $fileName);
                    ChatRoom::where('chat_room_id', $room_id)->update([
                        'chat_room_image' => $path2
                    ]);
                } else {
                    $path2 = $group->chat_room_image;
                }

                $group->chat_room_name = $name;
                $group->chat_room_image = $path2;
                $group->save();
                $sucess = true;
                return $this->sendResponse('group updated successfully.', $sucess);
            } else {
                $message = 'error';
                $status = false;
                return $this->sendError($message, $status);
            }

        } catch (\Exception $e) {
            $message = 'error';
            $status = false;
            return $this->sendError($message, $status);
        }
    }
    public function deleteGroup($group_id)
    {
        $group = ChatRoom::where(['chat_room_id' => $group_id, 'chat_room_creator' => auth()->user()->id])->first();
        if (!$group) {
            return $this->sendError('This Group Not found', false);
        } else {
            GroupSeen::where('group_id', $group_id)->delete();
            ChatRoom::where('chat_room_id', $group_id)->delete();
            $sucess = true;
            return $this->sendResponse('group deleted successfully.', $sucess);
        }

    }

    public function addGroupMember($request)
    {
        try {
            DB::beginTransaction();
            $name = $request->group_name;
            if ($request->users) {
                $group = ChatRoom::where(['chat_room_id' => $request->group_id, 'chat_room_creator' => auth()->user()->id, 'chat_room_type' => 'Gruppe'])->first();
                if ($group) {
                    $members = explode(',', $group->chat_room_users);
                    $users = array_merge($request->users, $members);
                    $group_users = implode(',', $users);
                    $group->chat_room_users = $group_users;
                    $group->save();
                }
            }
            DB::commit();
            $sucess = true;
            return $this->sendResponse('mbembers addeded successfully.', $sucess);
        } catch (\Exception $e) {
            DB::rollback();
            $message = 'error';
            $status = false;
            return $this->sendError($message, $status);
        }
    }

    public function groupInfo($group_id)
    {
        $group = ChatRoom::where(['chat_room_id' => $group_id, 'chat_room_creator' => auth()->user()->id])->first();
        if (!$group) {
            return $this->sendError('This Group Not found', false);
        } else {
            $users = explode(',', $group->chat_room_users);
            $users_data = User::whereIn('id', $users)->select('id', 'first_name', 'last_name', 'image')->get();
            $admin = User::where('id', $group->chat_room_creator)->select('id', 'first_name', 'last_name', 'image')->first();
            $group->chat_room_users = $users_data;
            $group->chat_room_creator = $admin;
            $sucess = true;
            return $this->sendResponse($group, 'data retuerned successfully.');
        }

    }

    public function deleteGroupMember($request)
    {
        try {

            $group = ChatRoom::where(['chat_room_id' => $request->group_id, 'chat_room_creator' => auth()->user()->id, 'chat_room_type' => 'Gruppe'])->first();
            if ($group) {
                $member = $request->member_id;
                $members = explode(',', $group->chat_room_users);
                $users = array_filter($members, function ($item) use ($member) {
                    return $item !== $member;
                });
                $group_users = implode(',', $users);
                $group->chat_room_users = $group_users;
                $group->save();
            }
            $sucess = true;
            return $this->sendResponse('mbember deleted successfully.', $sucess);
        } catch (\Exception $e) {
            $message = 'error';
            $status = false;
            return $this->sendError($message, $status);
        }
    }

    public function getAllMembers()
    {
        $users = User::select('id', 'first_name', 'last_name', 'image')->get();
        $sucess = true;
        return $this->sendResponse($users, 'data retuerned successfully.');
    }

    // send private and group messages
    public function sendPrivateMessage($request)
    {
        $data = $request->all();
        $id = auth()->user()->id;
        $message_type = 'text';
        $path = NULL;
        $duration = NULL;

        $message_to = $data['to'];
        $message = '';

        // Handle text message
        if (isset($data['message']) && !empty($data['message'])) {
            $message = $this->replace_string($data['message'], ['#kid', '#eid', '#bid', '#pid', '#iid', '#hid']);
            $message = my_cryption($message, 'e');
            $message_type = 'text';
        }

        if(isset($data['image']) && !empty($data['image'])) {
            $data['chat_attachment'] =  uploadImage($request->file('image'));
            $message_type            = 'image';
            $path                    =  Storage::disk('s3')->url('message/images/'.$data['chat_attachment']);
        }

        if(isset($data['video']) && !empty($data['video'])) {

            $data['chat_attachment'] =  uploadVideo($request->file('video'));
            $message_type            = 'video';
            $path                    =  Storage::disk('s3')->url('message/videos/'.$data['chat_attachment']);
        }

        if(isset($data['voice']) && !empty($data['voice'])) {

            $data['chat_attachment'] = uploadVoice($request->file('voice'));
            $message_type            = 'voice';
            $path                    =  Storage::disk('s3')->url('message/voices/'.$data['chat_attachment']);
        }

        if(isset($data['doc']) && !empty($data['doc'])) {

            $data['chat_attachment'] = uploadDoc($request->file('doc'));
            $message_type            = 'doc';
            $path                    =  Storage::disk('s3')->url('message/docs/'.$data['chat_attachment']);
        }

        $users        = $this->get_room_info_by_ids($id, $message_to , 'Private');
        $my_users     = $this->get_room_info_by_ids($message_to, $id , 'Private');

        if(!$users && !$my_users) {
            $insert_data = array(
                'chat_room_creator' => $id,
                'chat_room_users'   => $message_to,
                'chat_room_type'    => 'Private'
            );

            $room_id    = insert_data('chat_rooms', $insert_data);
            $users      = $this->get_room_info_by_id($room_id);
        } elseif($users) {
            $room_id    = $users->chat_room_id;
        } else {
            $users      = $my_users;
            $room_id    = $users->chat_room_id;
        }

        if($id == $users->chat_room_users) {
            $to_user = $users->chat_room_creator;
        } else {
            $to_user = $users->chat_room_users;
        }
        // Insert chat message into database
        $insert_data = [
            'chat_room_id' => $room_id,
            'chat_from' => $id,
            'chat_to' => $to_user,
            'chat_message' => $message,
            'chat_message_type' => $message_type,
            'chat_attachment' => $path,
            'voice_duration' => $duration,
        ];
        $chat_id = insert_data('chat', $insert_data);

        // Prepare Pusher data
        $pusher_data = [
            'chat_id' => (int) $chat_id,
            'chat_from' => (int) $id,
            'chat_room_id' => $room_id,
            'chat_to' => [(int) $to_user],
            'chat_message' => $message ? my_cryption($message, 'd') : null,
            'time' => now()->format('H:i A'),
            'chat_message_type' => $message_type,
            'chat_attachment' => $path,
            'chat_favorite' => 0,
            'duration' => $duration,
            'id' => $id,
            'first_name' => auth()->user()->first_name,
            'last_name' => auth()->user()->last_name,
            'image' => auth()->user()->image,
        ];

        // Insert chat notification
        insert_data('chat_notifications', [
            'chat_noti_room_id' => $room_id,
            'chat_noti_chat_id' => $chat_id,
            'chat_noti_from' => $id,
            'chat_noti_to' => $to_user,
        ]);

        // Fire Pusher event
        // Check if chat is open
        $chat_room = ChatRoom::where('chat_room_id', $room_id)->first();
        $this->check_chat_is_open($chat_room, $to_user, $pusher_data);

        event(new Message($pusher_data));
    }

// Helper method to create chat room
    private function createChatRoom($id, $message_to)
    {
        $room_data = [
            'chat_room_creator' => $id,
            'chat_room_users' => $message_to,
            'chat_room_type' => 'Private',
        ];
        return insert_data('chat_rooms', $room_data);
    }

    public function check_chat_is_open($chat_room, $to_user, $pusher_data)
    {

        if ($chat_room->chat_room_creator == $to_user) {
            if ($chat_room && $chat_room->chat_room_creator_open == 0) {


                $pusher_data['unseen_count'] = Chat::where('chat_room_id', $chat_room->chat_room_id)
                    ->where('chat_to', $to_user)
                    ->where('chat_seen', 0)
                    ->count();
                $pusher_data['chat_seen'] = 0;
                $pusher_data['chat_type'] = "Private";
                send_notification((int)$to_user, $pusher_data);
            } else {

                $lastUpdateTimestamp = strtotime($chat_room->creator_updated_at);
                $currentTimestamp = now()->addHours(2)->timestamp;
                $timeDifference = $currentTimestamp - $lastUpdateTimestamp;
                $chat = Chat::where('chat_id', $pusher_data['chat_id'])->first();
                if ($timeDifference <= 10) {
                    if ($chat) {
                        $chat->chat_seen = 1;
                        $pusher_data['chat_seen'] = 1;
                        $chat->save();
                    }
                } else {
                    $chat_room->chat_room_creator_open = 0;
                    $pusher_data['chat_seen'] = 0;
                    $chat_room->save();
                }

                $pusher_data['unseen_count'] = Chat::where('chat_room_id', $chat_room->chat_room_id)
                    ->where('chat_to', $to_user)
                    ->where('chat_seen', 0)
                    ->count();

                $pusher_data['chat_type'] = "Private";
                send_notification((int)$to_user, $pusher_data);
            }
        } else {
            if ($chat_room && $chat_room->chat_room_user_open == 0) {

                $pusher_data['unseen_count'] = Chat::where('chat_room_id', $chat_room->chat_room_id)
                    ->where('chat_to', $to_user)
                    ->where('chat_seen', 0)
                    ->count();
                $pusher_data['chat_seen'] = 0;
                $pusher_data['chat_type'] = "Private";
                send_notification((int)$to_user, $pusher_data);
            } else {

                $lastUpdateTimestamp = strtotime($chat_room->user_updated_at);
                $currentTimestamp = now()->addHours(2)->timestamp;
                $timeDifference = $currentTimestamp - $lastUpdateTimestamp;
                $chat = Chat::where('chat_id', $pusher_data['chat_id'])->first();
                if ($timeDifference <= 10) {
                    if ($chat) {
                        $chat->chat_seen = 1;
                        $pusher_data['chat_seen'] = 1;
                        $chat->save();
                    }
                } else {
                    $chat_room->chat_room_user_open = 0;
                    $pusher_data['chat_seen'] = 0;
                    $chat_room->save();
                }

                $pusher_data['unseen_count'] = Chat::where('chat_room_id', $chat_room->chat_room_id)
                    ->where('chat_to', $to_user)
                    ->where('chat_seen', 0)
                    ->count();

                $pusher_data['chat_type'] = "Private";
                send_notification((int)$to_user, $pusher_data);
            }
        }
    }

    public function sendGroupMessage($request) {

        $data         = $request->all();
        $user_id      = auth()->user()->id;
        $message_type = 'text';
        $path = NULL;
        $room_id   = $data['room_id'];
        $message = '';
        if(isset($data['client']) && $data['client'] > 0) {
            $message .= 'Kunde: #kid' . $data['client'] . ' ';
        }

        if(isset($data['message']) && !empty($data['message'])) {
            $message     .= $data['message'];
            $message      = $this->replace_string($message, array('#kid', '#eid', '#bid', '#pid', '#iid', '#hid'));
            $message      = my_cryption($message, 'e');
            $message_type = 'text';
            $path         = NULL;
        }
        $users      = $this->get_room_info_by_id($room_id);
        $room_users = explode(',', $users->chat_room_users);


        $key1 = array_search($user_id, $room_users);

        if ($key1 === false) {
            $message = 'you are not allowed to send messages in this group';
            $status  = false;
            return $this->sendError( $message , $status);
        }else {

            if($user_id == $users->chat_room_users) {
                $to_user = $users->chat_room_creator;
            }else if($users->chat_room_type == 'Gruppe') {
                $to_user = 0;
            }else {
                $to_user = 0;
            }

            $message_data   =  '';
            if(isset($data['image']) && !empty($data['image'])) {
                $data['chat_attachment'] =  uploadImage($request->file('image'));
                $message_type            = 'image';
                //$path = url('public/uploads/message/images').'/'. $data['chat_attachment'];
                $path                    =  Storage::disk('s3')->url('message/images/'.$data['chat_attachment']);
                $message_data            =  'Er hat ein Bild gesendet. ';
            }

            if(isset($data['video']) && !empty($data['video'])) {

                $data['chat_attachment'] =  uploadVideo($request->file('video'));
                $message_type            = 'video';
                $path                    =  Storage::disk('s3')->url('message/videos/'.$data['chat_attachment']);
                $message_data            =  'Er hat ein Video gesendet.';
            }

            if(isset($data['voice']) && !empty($data['voice'])) {

                $data['chat_attachment'] = uploadVoice($request->file('voice'));
                $message_type            = 'voice';
                $path                    =  Storage::disk('s3')->url('message/voices/'.$data['chat_attachment']);
                $message_data            =  'Er hat eine Sprachnachricht gesendet.';
            }

            if(isset($data['doc']) && !empty($data['doc'])) {

                $data['chat_attachment'] = uploadDoc($request->file('doc'));
                $message_type            = 'doc';
                $path                    =  Storage::disk('s3')->url('message/docs/'.$data['chat_attachment']);
                $message_data            =  'Er hat eine Datei gesendet.';
            }

            $insert_data = array(
                'chat_room_id' => $room_id,
                'chat_from'    => $user_id,
                'chat_to'      => $to_user,
                'chat_message' => $message,
                'chat_reply_id'     => @$data['chat_reply_id'],
                'chat_message_type' => $message_type,
                'chat_attachment'   => $path ,
                'chat_timestamp'    => Carbon::now('Africa/Cairo')->toDateTimeString(),
                'is_link'           => $data['is_link']??0,
            );

            $id = insert_data('chat', $insert_data);
            array_push($room_users, $users->chat_room_creator);
            $key = array_search($user_id, $room_users);
            array_splice($room_users, $key, 1);
            $arr_users = [];
            foreach($room_users as $key=>$user) {
                $insert_data2 = array(
                    'chat_noti_room_id'     => $room_id,
                    'chat_noti_chat_id'     => $id,
                    'chat_noti_to'          => $user,
                    'chat_noti_from'        => $user_id,
                );

                insert_data('chat_notifications', $insert_data2);
                $arr_users[] = (int)$user;

                if($user != auth()->user()->id) {
                    $gorup_seen = GroupSeen::where(['user_id' => $user , 'group_id' => $room_id ])->first();
                    if( $gorup_seen &&  $gorup_seen->is_open == 0) {
                        seen_messages($user, $room_id);
                    }

                    $pusher_data = array(
                        'chat_id'           =>  $id,
                        'chat_room_id'       => $room_id,
                        'chat_from'         => (int)$user_id,
                        'chat_to'           => $user,
                        'chat_message'      => !empty($message) ? my_cryption($message, 'd') : $message_data,
                        'time'              => date('H:i A', strtotime(now())),
                        'chat_message_type' => $message_type,
                        'chat_attachment'   => $path,
                        'chat_favorite'     => 0,
                        'room_name'         => @$users->chat_room_name,
                        'chat_type'         => 'Gruppe',
                        "user_id"           => auth()->user()->id,
                        "first_name"    => auth()->user()->first_name,
                        "last_name"     => auth()->user()->last_name,
                        "image"       => auth()->user()->image,
                        'unseen_count'      => GroupSeen::where(['user_id' => $user , 'group_id' => $room_id ])->first()->un_read ?? 0,
                        'chat_timestamp'    => Carbon::now('Africa/Cairo')->toDateTimeString(),
                    );

                    send_notification($user, $pusher_data);

                }else {

                    continue;
                }

            }
            $pusher_data = array(
                'chat_id'           =>  (int) $id,
                'chat_room_id'       => $room_id,
                'chat_from'         => (int)$user_id,
                'chat_to'           => $arr_users,
                'chat_message'      => !empty($message) ? my_cryption($message, 'd') : NULL,
                'time'              => date('H:i A' , strtotime(now())),
                'chat_message_type' => $message_type,
                'chat_attachment'   => $path,
                'chat_favorite'     => 0,
                'room_name'         => @$users->chat_room_name,
                'chat_type'         => 'Gruppe',
                "user_id"           => auth()->user()->id,
                "first_name"    => auth()->user()->first_name,
                "last_name"     => auth()->user()->last_name,
                "image"       => auth()->user()->image,
                'chat_timestamp'    => Carbon::now('Africa/Cairo')->toDateTimeString(),
            );

            $chat_room    = ChatRoom::where(['chat_room_id' => $room_id  , 'chat_room_type' => 'Gruppe' ])->first();
            if( $chat_room) {
                $chat_room->chat_room_last_msg_time = Carbon::now('Africa/Cairo')->toDateTimeString();
                $chat_room->save();
            }
            event(new Message($pusher_data));
        }
    }









    public function updatefcmToken($request)
    {
        $user = auth()->user();
        $user->fcm_token = $request->fcm_token;
        $user->save();
        $success = null;
        return $this->sendResponse('fcm token successfully updated.');
    }
    public function checkChatOpen($request)
    {
        if ($request->chat_room_type == 'Private') {
            $room = ChatRoom::where(['chat_room_id' => $request->chat_room_id, 'chat_room_type' => 'Private'])->first();
            if ($room) {
                if ($room->chat_room_creator == auth()->user()->id) {
                    $room->chat_room_creator_open = $request->is_open;
                    $room->creator_updated_at = now()->addHours(2);
                } else {
                    $room->chat_room_user_open = $request->is_open;
                    $room->user_updated_at = now()->addHours(2);
                }

                $room->save();
                $sucess = true;
                return $this->sendResponse('data updated successfully.', $sucess);
            }
        } else {
            $room = ChatRoom::where(['chat_room_id' => $request->chat_room_id, 'chat_room_type' => 'Gruppe'])->first();
            if ($room) {
                $gorup_seen = GroupSeen::where(['id' => auth()->user()->id, 'group_id' => $request->chat_room_id])->first();
                if ($gorup_seen) {
                    $gorup_seen->is_open = $request->is_open;
                    $gorup_seen->save();
                    $sucess = true;
                    return $this->sendResponse('data updated successfully.', $sucess);
                } else {
                    $gorup_seen = new GroupSeen();
                    $gorup_seen->id = auth()->user()->id;
                    $gorup_seen->group_id = $request->chat_room_id;
                    $gorup_seen->is_open = 1;
                    $gorup_seen->save();
                    $sucess = true;
                    return $this->sendResponse('data updated successfully.', $sucess);
                }
            }
        }
    }

    public function deleteForMe($request)
    {

        try {
            if ($request->room_type == "Private") {


                $chats = Chat::whereIn('chat_id', $request->chat_id)->get();
                if (count($chats) > 0) {
                    foreach ($chats as $chat) {
                        if ($request->delete_type == "me") {
                            if ($chat->chat_to == auth()->user()->id) {
                                $chat->deleted_to = 1;
                                $chat->save();
                            } else {
                                $chat->deleted_from = 1;
                                $chat->save();
                            }
                        } else {
                            if ($chat->chat_from == auth()->user()->id) {
                                $chat->deleted_to = 1;
                                $chat->deleted_from = 1;
                                $chat->deleted_for_everyone = 1;
                                $chat->save();
                            }
                        }
                    }
                    $success = null;
                    return response()->json(["msg" => "Done Successfully.", 'success' => true], 200);
                }

            } else {

                $chats = Chat::whereIn('chat_id', $request->chat_id)->where('chat_from', auth()->user()->id)->get();
                if (count($chats) > 0) {
                    foreach ($chats as $chat) {
                        $newValue = auth()->user()->id;
                        $chat->update([
                            'deleted_for' => $newValue,
                            'deleted_from' => 1,
                        ]);
                    }
                    return response()->json(["msg" => "Done Successfully.", 'success' => true], 200);
                }
            }
        } catch (\Exception $e) {
            $message = 'error';
            $status = false;
            return response()->json(["msg" => "error", 'success' => false], 500);
        }

    }

    public function deleteForEveryone($id)
    {
        $message = Chat::findOrFail($id);
        // Implement logic for "delete for everyone" (e.g., update a column like deleted_for_everyone)
        $message->update(['deleted_for_everyone' => true]);
    }

    public function blockChatRoom($request)
    {
        $room = ChatRoom::where(['chat_room_id' => $request->chat_room_id])->first();
        if ($room) {
            $room->is_blocked = 1;
            $room->save();
        }
        return response()->json(["msg" => "Done Successfully.", 'success' => true], 200);
    }

    public function deleteChatRoom($request)
    {
        $chats = Chat::where('chat_room_id', $request->chat_room_id)->get();

        if ($request->type == "Private") {
            if (count($chats) > 0) {
                foreach ($chats as $chat) {

                    if ($chat->chat_to == auth()->user()->id) {
                        $chat->deleted_to = true;
                        $chat->save();
                    } else {
                        $chat->deleted_from = true;
                        $chat->save();
                    }
                }

            }
        } else {
            if (count($chats) > 0) {
                foreach ($chats as $chat) {
                    $newValue = auth()->user()->id;
                    $chat->update([
                        'deleted_for' => $newValue,
                        'deleted_from' => 1,
                    ]);
                }

            }
        }
        return response()->json(["msg" => "Done Successfully.", 'success' => true], 200);
    }


    public function createRoom($request)
    {
        // Validate request data (You can customize the rules as needed)
        $request->validate([
            'chat_room_creator' => 'required|integer',
            'chat_room_users' => 'required|string', // Assuming this is a comma-separated string of user IDs
        ]);

        // Create or update the chat room
        $chatRoom = ChatRoom::updateOrCreate(
            [
                'chat_room_creator' => $request->chat_room_creator,
                'chat_room_users' => $request->chat_room_users,
            ],
            [
                'chat_room_type' => 'Private',
            ]
        );

        return response()->json(["msg" => "Done Successfully.", 'success' => true, 'chat_room' => $chatRoom], 200);
    }




}
