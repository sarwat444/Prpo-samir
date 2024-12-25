<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\DeleteRoomRequest;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\ChatRoom;
use App\Models\User;
use App\Repositories\WebChatEloquent;
use Illuminate\Http\Request;
use App\Events\Message ;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    public function chat()
    {
        $status  = 0 ;

        return  view('admin.chat.index' , compact('status')) ;
    }
    public function send_message(Request $request)
    {
        event(new Message('test' , 'test'));
    }

    private $chat;
    public function __construct(WebChatEloquent $chat_eloquent)
    {
        $this->chat = $chat_eloquent;
    }
    public function message(StoreMessageRequest $request) {
        $response  = $this->chat->send_message($request);
        return $response;
    }

    public function chatRooms()
    {
        $status = 0;
        $users = User::where('status' , 0)->get();
        $rooms = $this->chat->chat_rooms();

        $id = auth()->user()->id;

        $accessibleRooms = $rooms->filter(function ($room) use ($id) {
            return $room->chat_room_creator === $id || (isset($room->chat_room_users) && strpos($room->chat_room_users, (string)$id) !== false);
        });

        $privateRooms = $accessibleRooms->filter(function ($room) {
            return $room->chat_room_type === 'Private';
        });

        $groupRooms = $accessibleRooms->filter(function ($room) {
            return $room->chat_room_type === 'Gruppe';
        });

        $roomids = $privateRooms->pluck('guest_id')->merge($privateRooms->pluck('chat_room_creator'))->unique();

        $usersWithRooms = $users->filter(function ($user) use ($roomids) {
            return $roomids->contains($user->id) || $user->id === auth()->user()->id; // Include the authenticated user if they have a room
        });

        $usersWithoutRooms = $users->diff($usersWithRooms);

        return view('admin.chat.index', compact('privateRooms', 'status', 'usersWithRooms', 'usersWithoutRooms', 'users'  , 'groupRooms'));
    }

    public function roomMessages(Request  $request) {
        $room_id = $request->room_id ;
        $room_type = $request->room_type ;
        $response  = $this->chat->room_messages($room_id , $room_type);
        return $response;
    }

    public function addGroup(StoreGroupRequest $request) {
        $response  = $this->chat->addGroup($request);
        return $response;
    }

    public function deleteGroup($group_id) {
        $response  = $this->chat->deleteGroup($group_id);
        return $response;
    }

    public function addGroupMember(AddMemberRequest $request) {
        $response  = $this->chat->addGroupMember($request);
        return $response;
    }

    public function editGroup(UpdateGroupRequest $request) {
        $response  = $this->chat->editGroup($request);
        return $response;
    }

    public function groupInfo($group_id) {
        $response  = $this->chat->groupInfo($group_id);
        return $response;
    }

    public function deleteGroupMember(Request $request) {
        $response  = $this->chat->deleteGroupMember($request);
        return $response;
    }

    public function getAllMembers() {
        $response  = $this->chat->getAllMembers();
        return $response;
    }

    public function updatefcmToken(Request $request) {
        $response  = $this->chat->updatefcmToken($request);
        return $response;
    }

    public function checkChatOpen(Request $request) {
        $response  = $this->chat->checkChatOpen($request);
        return $response;
    }

    public function deleteForMe(DeleteRequest $request) {
        $response  = $this->chat->deleteForMe($request);
        return $response;
    }

    public function deleteForEveryone(DeleteRequest $request) {
        $response  = $this->chat->deleteForEveryone($request);
        return $response;
    }

    public function blockChatRoom(Request $request) {
        $response  = $this->chat->blockChatRoom($request);
        return $response;
    }

    public function deleteChatRoom(DeleteRoomRequest $request) {
        $response  = $this->chat->deleteChatRoom($request);
        return $response;
    }

    public function  craete_room(Request  $request)
    {
        $response = $this->chat->createRoom($request) ;
        return $response  ;
    }
    public function show_room(Request $request)
    {
        $data = $request->all();

        // Find the chat room with the given conditions
        if($request->room_type == 'private') {
            $room = ChatRoom::where(function ($query) use ($data) {
                $query->where([
                    ['chat_room_creator', '=', $data['user_id']],
                    ['chat_room_users', '=', Auth::id()]
                ])->orWhere([
                    ['chat_room_creator', '=', Auth::id()],
                    ['chat_room_users', '=', $data['user_id']]
                ]);
            })->first();
        }else
        {
            $room =  ChatRoom::find($request->group_room) ;
        }

        // Handle the case where the room is not found
        if (!$room) {
            return response()->json([
                'room_id' => 0 ,
                'room_type' => 'private'
            ]);
        }

        // Return the chat room ID
        return response()->json([
            'room_id' => $room->chat_room_id ,
            'user_id' => $data['user_id'] ,
            'room_type' => $room->chat_room_type
        ]);
    }

}
