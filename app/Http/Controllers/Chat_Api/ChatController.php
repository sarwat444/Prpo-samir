<?php

namespace App\Http\Controllers\Chat_Api;

use App\Events\MessageEvent;
use Illuminate\Http\Request;
use App\Repositories\ChatEloquent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\StoreGroupRequest;
use App\Models\ChatRoom;
use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\Api\SearchChatRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\DeleteRoomRequest;

class ChatController extends Controller
{
    private $chat;
    public function __construct(ChatEloquent $chat_eloquent)
    {
        $this->chat = $chat_eloquent;
    }
    public function message(StoreMessageRequest $request) {
         $response  = $this->chat->send_message($request);
         return $response;
    }

    public function chatRooms($type="all") {
        $response  = $this->chat->chat_rooms($type);
        return $response;
    }

    public function roomMessages($room_id , $type = "private") {
        $response  = $this->chat->room_messages($room_id , $type);
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

    public function getunseenMessages() {
        $response  = $this->chat->getunseenMessages();
        return $response;
    }

    public function search(Request $request) {
        $response  = $this->chat->search($request);
        return $response;
    }

    public function getRoomMedia($room_id) {
        $response  = $this->chat->getRoomMedia($room_id);
        return $response;
    }

    public function searchChat(SearchChatRequest $request) {
        $response  = $this->chat->searchChat($request);
        return $response;
    }

    public function get_all_unseen_messages_count() {
        $response  = $this->chat->getAllunseenMessages();
        return $response;
    }






}
