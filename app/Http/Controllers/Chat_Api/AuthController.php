<?php

namespace App\Http\Controllers\Chat_Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AuthEloquent;

class AuthController extends Controller
{
    private $auth;

    public function __construct(AuthEloquent $auth)
    {
        $this->auth = $auth;
    }
    public function login(Request $request) {
        $response  = $this->auth->login($request);
        return $response;
    }

    public function register(Request $request) {
        $response  = $this->auth->register($request);
        return $response;
    }

    public function delete() {
        $response  = $this->auth->delete();
        return $response;
    }

    public function toggleRegister() {

        $response  = $this->auth->toggleRegister();
        return $response;
    }

}
