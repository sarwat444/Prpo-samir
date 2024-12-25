<?php

namespace App\Http\Controllers\Chat_Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SupportEloquent;

class SupportController extends Controller
{
    private $support;
    public function __construct(SupportEloquent $support_eloquent)
    {
        $this->support = $support_eloquent;
    }
    public function get_sub_menus_of_support() {
        $response  = $this->support->get_sub_menus_of_support();
        return $response;
    }

    public function client_chat($support_id = 1, $read = false) {
        $response  = $this->support->client_chat($support_id , $read);
        return $response;
    }


}
