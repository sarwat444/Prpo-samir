<?php

namespace App\Repositories;

use App\Http\Resources\commentsResource;
use Illuminate\Support\Facades\DB;
use App\Traits\ResponseJson;
use App\Models\User;
use App\Http\Resources\SupportResource;
use Validator;

class SupportEloquent
{
    use ResponseJson;
    private $user_id;
    private $month ;
    public function __construct() {
        $this->user_id = auth()->guard('api')->user()->user_id;
        $this->month   =  array(
                                1 => "Januar",
                                2 => "Februar",
                                3 => "März",
                                4 => "April",
                                5 => "Mai",
                                6 => "Juni",
                                7 => "Juli",
                                8 => "August",
                                9 => "September",
                                10=> "Oktober",
                                11=> "November",
                                12=> "Dezember"
                            );
    }

    public function get_sub_menus_of_support() {
        $site      = 'Menü';
        $user_id   = auth()->guard('api')->user()->user_id;
        $user_type = auth()->guard('api')->user()->user_type;
        $submenu   = "Kunden Chat";
        return  SupportResource::collection(DB::table('user_type_permissions')
                ->select('*')
                ->where('u_type_permission_group', $submenu)
                ->where('u_type_permission_location', $site)
                ->where(function ($query) use ($user_id, $user_type) {
                    $query->whereRaw('FIND_IN_SET(' . $user_id . ', u_type_permission_deny) = 0')
                        ->orWhereNull('u_type_permission_deny')
                        ->where(function ($query) use ($user_id, $user_type) {
                            $query->where('u_type_permission_type', 'LIKE', '%' . $user_type . '%')
                                ->orWhere('u_type_permission_exceptions', 'LIKE', '%,' . $user_id . ',%');
                        });
                })
                ->orderBy('u_type_permission_order', 'ASC')
                ->get());
    }
    public function client_chat($support_id = 1, $read = false) {

        try {
                $data['user']   = DB::table('users')->select('*')->where('user_id', '=', $this->user_id)->first();
                $data['user_array']         = explode(',', $data['user']->user_support);

                if($support_id == 0 ) {
                    $data['clients']    = $this->get_favourite_chat_of_clients();
                }else if($support_id < 5 || $support_id > 5){
                    $data['clients']    = $this->get_chat_of_clients_by_support_id($support_id, $read);
                    dd($data);
                }else{
                    $data['clients']    = $this->get_shared_chat_of_clients($read);
                }

                $data['sum_hco_unseen']         = $this->get_sum_unseen_messages(1);
                $data['sum_inspire_unseen']     = $this->get_sum_unseen_messages(2);
                $data['sum_affiliate_unseen']   = $this->get_sum_unseen_messages(3);
                $data['sum_shop_unseen']        = $this->get_sum_unseen_messages(4);
                $data['sum_hc4u_unseen']        = $this->get_sum_unseen_messages(6);

                $data['sum_favourites']         = $this->count_favourite_chat_of_clients($this->user_id);
                $data['sum_redirect_open']      = $this->count_shared_chat_of_clients($this->user_id);

                $this->delete_chat_noti_by_type($this->user_id, $support_id);

                $dataTitle['open_emails']  = DB::table('client_chats')
                                                ->selectRaw('IFNULL(COUNT(client_chat_id), 0) as sum')
                                                ->where('client_chat_from', '=', 0)
                                                ->where('client_chat_send_email', '=', 0)
                                                ->first()
                                                ->sum;
                $dataTitle['support_id']   = $support_id;
                $data['months']            = $this->month;

                return  response()->json([ "msg" => "data returned successfully.", "data" => $data ]);
        } catch(Exception $e) {
                dd($e);
                $message = 'error';
                $status  = false;
                return $this->sendError( $message , $status);
        }
    }

    public function get_favourite_chat_of_clients() {
        DB::table('client_chats as chat1')
        ->join('clients as clients1', function ($join) {
            $join->on('clients1.client_id', '=', 'chat1.client_chat_from')
                ->orOn('clients1.client_id', '=', 'chat1.client_chat_to');
        })
        ->join('client_chat_favourites', function ($join) {
            $join->on('fav_chat_added_by_id', '=', DB::raw($this->user_id))
                ->on('clients1.client_id', '=', 'fav_chat_client_id');
        })
        ->where('clients1.client_mute_status', '=', 0)
        ->groupBy('clients1.client_id')
        ->select('chat1.*', 'clients1.client_gender', 'clients1.client_firstname', 'clients1.client_lastname', 'clients1.client_id')
        ->orderBy('chat1.client_chat_datetime', 'DESC')
        ->get();
    }

    public function get_chat_of_clients_by_support_id($support_id, $read=false) {

        $unread = $read == 'unread' ? " AND (chat1.client_chat_to = 0 AND chat1.client_chat_seen = 0)" : '';
        $results = DB::table('client_chats as chat1')
            ->join('clients as clients1', function ($join) use ($support_id, $unread) {
                $join->on('clients1.client_id', '=', 'chat1.client_chat_from')
                    ->orOn('clients1.client_id', '=', 'chat1.client_chat_to')
                    ->where('clients1.client_mute_status', '=', 0)
                    ->where('chat1.client_chat_support', '=', $support_id)
                    ->whereRaw($unread);
            })
            ->groupBy('clients1.client_id') // Only include columns not part of an aggregate function
            ->select('chat1.*', 'clients1.client_gender', 'clients1.client_firstname', 'clients1.client_lastname', 'clients1.client_id')
            ->orderBy('chat1.client_chat_datetime', 'DESC')
            ->get();

        return $results;


    }

    public function get_shared_client_messages($client_id, $user_id){
        $results = DB::table('client_chat_shared')
                        ->select(
                            'client_chat_supports.*', 'client_chats.*', 'client_chat_shared.client_chat_share_message_id',
                            'client_chat_shared.client_chat_share_support_id', 'clients.client_gender', 'clients.client_firstname',
                            'clients.client_lastname', 'clients.client_id', 'clients.client_email', 'client_support_logo'
                        )
                        ->join('client_chats', 'client_chat_id', '=', 'client_chat_share_message_id')
                        ->join('clients', function ($join) {
                            $join->on('clients.client_id', '=', 'client_chats.client_chat_from')
                                ->orOn('clients.client_id', '=', 'client_chats.client_chat_to');
                        })
                        ->join('client_chat_supports', 'client_support_id', '=', 'client_chat_support')
                        ->leftJoin('client_chat_favourites', function ($join) use ($user_id) {
                            $join->on('fav_chat_message_id', '=', 'client_chats.client_chat_id')
                                ->where('fav_chat_added_by_id', '=', $user_id);
                        })
                        ->where('client_chat_share_to_adviser', '=', $user_id)
                        ->where('client_chat_share_done', '=', 0)
                        ->where('client_chat_share_client_id', '=', $client_id)
                        ->orderBy('client_chat_share_timestamp', 'DESC')
                        ->get()
                        ->toArray();

        return $results;

    }

    public function get_shared_chat_of_clients(){
        $results = DB::table('client_chat_shared')
                    ->select(
                        'client_chats.*', 'client_chat_shared.client_chat_share_message_id',
                        'client_chat_shared.client_chat_share_support_id', 'clients.client_gender',
                        'clients.client_firstname', 'clients.client_lastname', 'clients.client_id',
                        'clients.client_email', 'client_support_logo'
                    )
                    ->join('client_chats', 'client_chat_id', '=', 'client_chat_share_message_id')
                    ->join('clients', function ($join) {
                        $join->on('clients.client_id', '=', 'client_chats.client_chat_from')
                            ->orWhere('clients.client_id', '=', 'client_chats.client_chat_to')
                            ->where('clients.client_mute_status', '=', 0);
                    })
                    ->join('client_chat_supports', 'client_support_id', '=', 'client_chat_support')
                    ->where('client_chat_share_to_adviser', '=', $this->user_id)
                    ->where('client_chat_share_done', '=', 0)
                    ->orderBy('client_chat_share_timestamp', 'DESC')
                    ->groupBy('client_chat_share_client_id', 'client_chat_share_support_id')
                    ->get()
                    ->toArray();
        return $results;

    }

    public function get_sum_unseen_messages($support_id) {
        $unseenSum = DB::table('client_chats')
        ->selectRaw('IFNULL(count(client_chat_id), 0) as unseen_sum')
        ->where('client_chat_to', '=', 0)
        ->where('client_chat_seen', '=', 0)
        ->where('client_chat_support', '=', $support_id)
        ->get()
        ->first()
        ->unseen_sum;

       return $unseenSum;

    }

    public function count_favourite_chat_of_clients($user_id) {

        $sumFav = DB::table('client_chat_favourites')
                    ->selectRaw('COUNT(DISTINCT(IFNULL(fav_chat_client_id, 0))) as sum_fav')
                    ->where('fav_chat_added_by_id', '=', $user_id)
                    ->get()
                    ->first()
                    ->sum_fav;

         return $sumFav;
    }

    public function count_shared_chat_of_clients($user_id) {
        $sumShared = DB::table('client_chat_shared')
                        ->selectRaw('COUNT(DISTINCT(IFNULL(client_chat_share_client_id, 0))) as sum_shared')
                        ->where('client_chat_share_to_adviser', '=', $user_id)
                        ->where('client_chat_share_done', '=', 0)
                        ->get()
                        ->first()
                        ->sum_shared;
       return $sumShared;

    }

    public function delete_chat_noti_by_type($user_id, $support){
        DB::table('notifications')
        ->where('noti_type', 'Neue Chatnachricht')
        ->where('noti_type_id', $support)
        ->where('noti_to', $user_id)
        ->delete();
    }




}
