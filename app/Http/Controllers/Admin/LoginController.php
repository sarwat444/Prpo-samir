<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Admin;
use App\Models\User;
use App\Models\Category;
use App\Models\Task;
use App\Models\TaskTeam;
use App\Models\Package;
use App\Models\InviteUser;
use Illuminate\Validation\Rule;

use Auth;
use str;
use Mail;
use Session ;

class LoginController extends Controller
{
    // i use it in tinker
    //    public function save() {
    //        $admin = new App\Models\Admin();
    //        $admin->name = "Abdelazem Abdelhamed";
    //        $admin->email = "abdelazem15181996@gmail.com";
    //        $admin->password = bcrypt("12345678");
    //        $admin->save();
    //    }

    public function getRegister()
    {

        return view('admin.auth.register');
    }

    public function storeRegister(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->where(fn ($query) => $query->where('deleted', 0)), // Ensure we only check against active users
            ],
            'password' => 'required|confirmed',
            'image' => 'required|image',
            'user_name' => [
                'required',
                Rule::unique('users')->where(fn ($query) => $query->where('deleted', 0)), // Same for user name
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(array('errors' => $validator->getMessageBag()));
        }

        //--- Validation Section Ends
        if (auth()->user()->role == 4) {

            $users = User::where('account_id', auth()->user()->account_id)->where('id', '!=', auth()->user()->id)->where('status' , 0)->get();
            $Count = $users->count();
            if ($Count == auth()->user()->package->user_limit) {
                return redirect()->route('admin.dashboard')->with(['error' => 'You Cant not Add More Users']);
            } else {
                $user = new User;

                if ($request->hasFile('image') && !empty($request->hasFile('image'))) {
                    $image = $request->file('image');
                    $image_ext = $image->getClientOriginalExtension();
                    $path = rand(123456, 999999) . "." . $image_ext;
                    $destination_path = public_path('/public/assets/images/users/');
                    $image->move($destination_path, $path);
                    $input['image'] = $path;
                }

                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->user_name = $request->user_name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->image = $path;
                $user->account_id = auth()->user()->account_id;
                $user->save();

            }

        } else {
            $user = new User;

            if ($request->hasFile('image') && !empty($request->hasFile('image'))) {
                $image = $request->file('image');
                $image_ext = $image->getClientOriginalExtension();
                $path = rand(123456, 999999) . "." . $image_ext;
                $destination_path = public_path('assets/images/users/');
                $image->move($destination_path, $path);
                $input['image'] = $path;

            }

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->user_name = $request->user_name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->image = $path;
            $user->save();

        }
        return redirect()->route('admin.dashboard')->with(['success' => 'Record Added Successfully']);

    }


    // store guest function

    public function storeGuest(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->where('deleted' , 0 ), // Exclude soft-deleted users
            ],
            'password' => 'required|confirmed',
            'image' => 'required|image',
            'user_name' => [
                'required',
                Rule::unique('users')->where('deleted' , 0 ),
            ],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(array('errors' => $validator->getMessageBag()));
        }

        //--- Validation Section Ends

        $user = new User;

        if ($request->hasFile('image') && !empty($request->hasFile('image'))) {
            $image = $request->file('image');
            $image_ext = $image->getClientOriginalExtension();
            $path = rand(123456, 999999) . "." . $image_ext;
            $destination_path = public_path('assets/images/users/');
            $image->move($destination_path, $path);
            $input['image'] = $path;

        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->role = 3;
        $user->password = bcrypt($request->password);
        $user->image = $path;
        $user->save();

        return redirect()->route('admin.dashboard')->with(['success' => 'Record Added Successfully']);

    }


    // end store guest function


    public function profileupdate(Request $request)
    {
        $id = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('users')->ignore($id)->where('deleted', 0),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id)->where('deleted', 0),
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_ext = $image->getClientOriginalExtension();
            $path = rand(123456, 999999) . "." . $image_ext;
            $destination_path = public_path('assets/images/users/');
            $image->move($destination_path, $path);
            $user->image = $path;
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->user_name = $request->user_name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with(['success' => 'Data Updated Successfully']);
    }



    public function getLogin($user_name = null, $user_pass = null , $is_chat = 0)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->intended('/admin');
        }
        else
        {
            if (!empty($user_name) && !empty($user_pass)) {

                $user_name = $this->my_cryption($user_name, 'd', 'inspire_login');
                $user_pass = $this->my_cryption($user_pass, 'd', 'inspire_login');

            }
            return response(view('admin.auth.login', compact('user_name', 'user_pass' , 'is_chat')))

                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        }
    }


    public function Login(Request $request)
    {

        //if he click remeber me make it true
        $remember_me = $request->has('remember_me') ? true : false;

        $this->validate($request, [

            'user_name' => 'required',

        ]);

        if (auth()->guard('admin')->attempt(['user_name' => $request->input("user_name"), 'password' => $request->input("password") , 'deleted' => 0 , 'status' => 0], $remember_me  )) {
            $user_name = $this->my_cryption($request->input("user_name"), 'e', 'inspire_login');
            $user_pass = $this->my_cryption($request->input("password"), 'e', 'inspire_login');
            Session::put('user_name',  $user_name);
            Session::put('user_pass',  $user_pass);

            session()->put('locale',  auth()->guard('admin')->user()->d_lang);

            auth()->guard('admin')->user()->login_status = 1;

            $mytime = \Carbon\Carbon::now()->addHour(2)->addMinutes(10);
            auth()->guard('admin')->user()->login_at = $mytime->toDateTimeString();
            auth()->guard('admin')->user()->save();
            if (auth()->guard('admin')->check()) {
               
                $user = auth()->guard('admin')->user(); // Retrieve the logged-in user

                if($request->input('is_chat') == 1) {
                    return redirect()
                    ->route('chat.chat_rooms')
                    ->with('success', 'Login Successfuly');
                }

                if ($user->role == 3) {
                    // Redirect guest admin role to guest dashboard
                    return redirect()
                        ->route('admin.guest_dashboard')
                        ->with('success', 'Login Successfuly');
                } else {
                    // Redirect other roles to the main dashboard
                    return redirect()
                        ->route('admin.dashboard')
                        ->with('success', 'Login Successfully');
                }
            } else {
                return redirect()->back()->with('error', 'User name or password is not correct');

            }
        }
      
        // notify()->error('خطا في البيانات  برجاء المجاولة مجدا ');
        return redirect()->back()->with('error', 'User name or password is not correct');

    }


    public function logout()
    {

        Auth::guard('admin')->user()->login_status = 0;
        auth()->guard('admin')->user()->login_at = null;
        auth()->guard('admin')->user()->d_lang = session()->get('locale');
        auth()->guard('admin')->user()->save();
        Auth::guard('admin')->logout();
        return redirect('/');
    }

    public function UpdateLoginStatus()
    {
        $users = User::where('login_at', '!=', NULL)->where('status' , 0)->get();

        if ($users) {

            foreach ($users as $user) {

                if ($user->login_at < \Carbon\Carbon::now()->addHour(2)->addMinutes(10)) {
                    //   dd( \Carbon\Carbon::now()->addHour(2)->addMinutes(10));
                    $user->login_status = 0;
                    $user->save();
                } else {
                    //  dd('hii');
                    $user->login_status = 1;
                    $user->save();
                }

            }
        }


        $users2 = User::where('login_status', 1)->where('status' , 0)->get();

        $data = view('admin.tasks.online_users', compact('users2'))->render();

        return response()->json(['options' => $data]);


    }


    public function ChangeLoginStatus()
    {
        auth()->guard('admin')->user()->login_status = 1;
        $mytime = \Carbon\Carbon::now()->addHour(2)->addMinutes(10);
        auth()->guard('admin')->user()->login_at = $mytime->toDateTimeString();
        auth()->guard('admin')->user()->save();
        $users2 = User::where('login_status', 1)->where('status' , 0)->get();
        $data = view('admin.tasks.online_users', compact('users2'))->render();
        return response()->json(['options' => $data]);

    }

    public function my_cryption($string, $action = 'e', $code = 'login')
    {
        $secret_key = 'thisIsmySecretKey:)';
        $secret_iv = 'thisIsmySecretIv:)';
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'e') {
            $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        } else if ($action == 'd') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    public function userTasks($user_id, $status)
    {

        session()->forget('catt_id');
        session()->forget('tagg_id');
        $categories = Category::where(['account_id'=> Auth::user()->account_id])->get();
        $users = User::where('role', '!=', 3)->where(['account_id'=> Auth::user()->account_id])->where('status' , 0)->get();
        $tasksids = TaskTeam::where(['account_id'=> Auth::user()->account_id])->where('user_id', $user_id)->pluck('task_id');

        if ($status == 1) {
            $title = 'Pripo Completed';
            $tasks = Task::whereIn('id', $tasksids)->where('task_status', 1)
                ->Orwhere('task_added_by', $user_id)->where('task_status', 1)
                ->Orwhere('task_responsible', $user_id)->where('task_status', 1)
                ->orderBy('task_priority', 'asc')->limit(12);

        } else if ($status == 2) {
            $title = 'Pripo Deleted';
            $tasks = Task::whereIn('id', $tasksids)->where('task_status', 2)
                ->Orwhere('task_added_by', $user_id)->where('task_status', 2)
                ->Orwhere('task_responsible', $user_id)->where('task_status', 2)
                ->orderBy('task_priority', 'asc')->limit(12);

        } else {
            $title = 'Pripo';
            $tasks = Task::whereIn('id', $tasksids)->where('task_status', 0)
                ->Orwhere('task_added_by', $user_id)->where('task_status', 0)
                ->Orwhere('task_responsible', $user_id)->where('task_status', 0)
                ->orderBy('task_priority', 'asc')->limit(12)->get();
        }
        return view('admin.users.all_user_tasks', compact('tasks', 'users', 'categories', 'title', 'status', 'user_id'));
    }

    public function storeAccount(Request $request)
    {


        //     dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'image' => 'required',
            'user_name' => 'required|unique:users',
            'package_id' => 'required'

        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(array('errors' => $validator->getMessageBag()));
        }

        //--- Validation Section Ends

        $user = new User;

        if ($request->hasFile('image') && !empty($request->hasFile('image'))) {
            $image = $request->file('image');
            $image_ext = $image->getClientOriginalExtension();
            $path = rand(123456, 999999) . "." . $image_ext;
            $destination_path = public_path('assets/images/users/');
            $image->move($destination_path, $path);
            $input['image'] = $path;

        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->role = 4;
        $user->password = bcrypt($request->password);
        $user->image = $path;
        $user->package_id = $request->package_id;
        $user->save();
        $user->account_id = $user->id;
        $user->save();
        return redirect()->route('admin.accounts')->with(['success' => 'Account Added Successfully']);

    }


    public function storeInvite(Request $request)
    {


        //     dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(array('errors' => $validator->getMessageBag()));
        }


        //--- Validation Section Ends

        $user = User::where('email', $request->email)->first();

        if (!empty($user)) {
            $invite = new InviteUser();
            $invite->inviter_id = auth()->user()->id;
            $invite->user_id = $user->id;

            $invite->save();

            // \Mail::send('mails.mail',
            //  array(
            //
            //      'invite_id' => $invite->id ,
            //      'email' => $request->email,
            //
            //  ), function($message) use ($request)
            //    {
            //       $message->from('pripo@germaniatek.co');
            //       $message->to($request->email);
            //       $message->subject('Invitation From Pripo');
            //
            //    });

        } else {
            return redirect()->back()->with(['error' => 'This User Not Found']);
        }

        return redirect()->route('admin.dashboard')->with(['success' => 'Invite Sended Successfully']);

    }

    public function AcceptInvite(Request $request)
    {
        $invite = InviteUser::where('id', $request->invite_id)->first();
        $invite->active = 1;
        $invite->save();
        return redirect()->route('admin.dashboard');
    }

    public function createAccount()
    {
        $status = 3;
        $packages = Package::all();
        return view('admin.accounts.create', compact('status', 'packages'));
    }


    public function editAccount(Request $request)
    {
        $id = $request->id;
        $account = User::where('role', 4)->where('id', $id)->first();
        //   dd($account);
        $packages = Package::all();
        return view('admin.accounts.edit', ['account' => $account, 'id' => $id, 'packages' => $packages]);
    }

    public function updateAccount(Request $request, $id)
    {

        //     dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'user_name' => 'required|unique:users,user_name,' . $id,
            'package_id' => 'required'

        ]);


        if ($validator->fails()) {
            return redirect()->back()->with(array('errors' => $validator->getMessageBag()));
        }


        //--- Validation Section Ends

        $user = User::find($id);

        if ($request->hasFile('image') && !empty($request->hasFile('image'))) {
            $image = $request->file('image');
            $image_ext = $image->getClientOriginalExtension();
            $path = rand(123456, 999999) . "." . $image_ext;
            $destination_path = public_path('assets/images/users/');
            $image->move($destination_path, $path);
            $input['image'] = $path;
            $user->image = $path;

        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->package_id = $request->package_id;
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }


        $user->save();


        return redirect()->route('admin.accounts')->with(['success' => 'Data Updated Successfully']);

    }

    public function deleteAccount(Request $request)
    {
        $id = $request->id;
        $data = User::find($id);
        if ($data) {
            $data->deleted = 1;
            $data->save();
        }
        $msg = 'Data Deleted Successfully';
        return response()->json([
            "status" => true,
            "msg" => $msg
        ], 200);

    }

    public function editUserModal(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) {
            return response()->json(['error' => 'user not found']);
        }

        $view = view('front.models.edit_user',compact('user'))->render();
        return response()->json(['html' => $view]);
    }

    public function updateUserModal(Request $request){
        try {

            $id = decrypt($request->id);
            $user = User::find($id);

            if (!$user) {
                return response()->json(['message' => 'invalid data']);
            }
            $validator = $request->validate([
                'username' => 'required|unique:users,user_name,' . $id,
                'email' => 'required|unique:users,email,' . $id,
                'firstname' => 'required',
                'lastname' => 'required',
                'priority' => 'required',
                'role' => 'required',
            ]);

            if ($request->hasFile('image') && !empty($request->hasFile('image'))) {
                $image = $request->file('image');
                $image_ext = $image->getClientOriginalExtension();
                $path = rand(123456, 999999) . "." . $image_ext;
                $destination_path = public_path('assets/images/users/');
                $image->move($destination_path, $path);
                $user->image = $path;
            }
            if ($request->has('password')){
                $password = Hash::make($request->password);
                $user->password = $password;
            }

            $user->user_name = $request->username;
            $user->email = $request->email;
            $user->last_name = $request->lastname;
            $user->first_name = $request->firstname;
            $user->user_name = $request->username;
            $user->user_piriority = $request->priority;

            $user->save();
            return response()->json(['success' => 'user data updated']);

        }catch (\Exception $exception){
            return response()->json(['error'=>$exception->getMessage()]);
        }

    }
    public function deleteUser(Request $request){
        try {
            if (!$request->id) {
                return response()->json(['message' => 'invalid request']);
            }
            $id = $request->id;
            $user = User::find($id);
            if ($user) {
                $user->deleted = 1;
                $user->save();
                return redirect()->back()->with('flash_message_success', 'User Deleted Successfuly');
            } else
            {
                return redirect()->back()->with('flash_message_danger', 'No User Found');
            }
        } catch (\Exception $exception) {
            return response()->json(['error'=>$exception->getMessage()]);

        }
    }


}
