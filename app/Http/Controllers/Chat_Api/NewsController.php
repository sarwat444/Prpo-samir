<?php

namespace App\Http\Controllers\Chat_Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\NewsEloquent;

class NewsController extends Controller
{
    private $news;
    public function __construct(NewsEloquent $news_eloquent)
    {
        $this->news = $news_eloquent;
    }
    public function index() {
         $response  = $this->news->index();
         return $response;
    }

    public function ajax_request(Request $request){
        $response  = $this->news->ajax_request($request);
        return $response;
    }

    public function news_info($news_id){
        $response  = $this->news->news_info($news_id);
        return $response;
    }




}
