<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;
use App\Events\newMessage;
use App\Events\PrivateMessageEvent;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


     public function index()
  {
      // select all users except logged in user
      // $users = User::where('id', '!=', Auth::id())->get();

      // count how many message are unread from the selected user
      $users = DB::select("select users.id, users.user_name, users.image, users.email, count(is_read) as unread
      from users LEFT  JOIN  messages ON users.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
      where users.id != " . Auth::id() . "
      group by users.id, users.user_name, users.image, users.email");

           $user = auth()->user();
            $status = 0;
        //   dd($users);
          return view('admin.messages.home', ['users' => $users  , 'user' => $user ,'status' => $status ]);
  }

  public function getMessage($user_id)
  {
      $my_id = Auth::id();

      // Make read all unread message
      Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

      // Get all message from selected user
      $messages = Message::where(function ($query) use ($user_id, $my_id) {
          $query->where('from', $user_id)->where('to', $my_id);
      })->oRwhere(function ($query) use ($user_id, $my_id) {
          $query->where('from', $my_id)->where('to', $user_id);
      })->get();

      return view('admin.messages.index', ['messages' => $messages,'receiver' => $user_id]);
  }

  public function sendMessage(Request $request)
  {

    //  dd($request->all());

      $from = Auth::id();

      $message = $request->message;

      $data = new Message();
      $data->from = $from;



      if ($request->hasFile('image') && !empty($request->hasFile('image'))) {


      $image = $request->file('image');
      $image_ext = $image->getClientOriginalExtension();
      $path = rand(123456, 999999) . "." . $image_ext;
      $destination_path = base_path('assets/images/messages/');
      $image->move($destination_path, $path);

        $data->image = $path;
          $to = $request->to;
            $data->to = $to;

  }else {
      $to = $request->receiver_id;
      $data->message = $message;
      $data->to = $to;
  }

      $data->is_read = 0; // message will be unread when sending message
      $data->save();
      $data = ['from' => $from, 'to' => $to]; // sending from and to user id when pressed enter
      //  $pusher->trigger('my-channel', 'my-event', $data);
      event(new newMessage($data));
  }


}
