

<div class="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid headercontainer">
            @php

                $currentDate = \Carbon\Carbon::now();
                $sevenDaysAgo = date('Y-m-d' , strtotime($currentDate->subDays(7)));

                $replay_cont = 0 ;
                $comments_count  = 0 ;

                $replays = \App\Models\Replay::where('added_by_id','!=', auth()->user()->id )->orderBy('id' ,'DESC')->whereDate('created_at', '>=' ,$sevenDaysAgo)->get();

                foreach($replays as $replay)
                {

                    $doneeplays =  json_decode($replay->is_read) ;
                    $read_users =  json_decode($replay['is_readnotify']) ;

                    if(empty($doneeplays) ||  !in_array(auth()->user()->id , $doneeplays))
                     {
                       /* if($replay->comment_author == auth()->user()->id)
                         {
                                  if(empty($read_users) || !in_array(auth()->user()->id , $read_users)){
                                      $replay_cont += 1 ;
                                   }

                          }*/

                        if(!empty($replay->tags))
                        {
                                $tags = explode(',', $replay->tags);
                                if (in_array( auth()->user()->id, $tags))
                                {
                                     if(empty($read_users) || !in_array(auth()->user()->id , $read_users))
                                     {
                                         $replay_cont += 1 ;
                                     }
                                }
                        }


                     }
                }


                   $comments  = \App\Models\Comment::where('comment_added_by','!=', auth()->user()->id)->orderBy('id','DESC')->whereDate('created_at', '>=' ,$sevenDaysAgo)->get();

                   foreach($comments as $comment)
                   {

                      $donecomments =  json_decode($comment->readby) ;
                      $read_users =  json_decode($comment->is_readnotify) ;


                        if(empty($donecomments) ||  !in_array(auth()->user()->id , $donecomments))
                        {

                            if(!empty($comment->tags))
                            {
                                    $tags = explode(',', $comment->tags);
                                    if (in_array( auth()->user()->id, $tags))
                                    {
                                        if(empty($read_users) || !in_array(auth()->user()->id , $read_users))
                                        {
                                            $comments_count += 1 ;
                                        }
                                    }
                            }


                        }

                    }




            @endphp



            <div class="row" style="width: 100%">
                <div class="col-md-2 text-center">
                        <a class="navbar-brand" href="{{url('/admin')}}">
                              <img src="{{asset('public/assets/images/header-logo.png')}}" style="width: 92px; height: 44px">
                         </a>
                </div>
                <div class="col-md-3">
                           <div class="search-wrapper active">
                               <div class="input-holder">
                                   <form id="searchBar"
                                         action="{{route('admin.cat.tasks',['cat_id'=> Session::has('catt_id')?Session::get('catt_id'):0,'status'=>$status])}}"
                                         method="get">
                                       <input type="text" class="search-input" style="background-color: transparent"
                                              placeholder='{{__('messages.search_placeholder')}}' name="search_name"
                                              id="search_input"
                                              value="{{ request()->has('search_name') ? request()->get('search_name') : '' }}"/>
                                   </form>
                                   <button id="search_button" class="search-icon" ><span
                                           class="searchclick"></span></button>
                               </div>
                           </div>
                </div>
                <div class="col-md-2" style="padding-top: 9px; text-align: center">
                    <span class="tasktimer2"></span>
                    <div id="timer_control" style="padding-top: 9px;text-align: center;position: relative;text-align: center;">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-3 replaysvscomments">
                            <div class="notify_messages">

                                <i class="fa-regular fa-comments replay_icon">
                                    <span class="messages">{{$comments_count}}</span>
                                    <span class="replays_count">{{$replay_cont}}</span>
                                </i>
                                <!--Replay Notifation -->
                                <div class="notifi-box" id="box">
                                    <div class="notifaction-header">
                                        <h2>{{__('messages.Benachrichtigung')}} </h2>
                                        <!--Tabs -->
                                        <nav>
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa-solid fa-comments"></i> {{$comments_count}} </button>
                                                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fa-solid fa-reply"></i> {{$replay_cont}}</button>
                                            </div>
                                        </nav>
                                    </div>

                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">


                                            @if(!empty($comments))
                                                @foreach($comments as $comment)
                                                    @if($comment->comment_added_by !=auth()->user()->id)
                                                        @php
                                                            $donecomments =  json_decode($comment->readby) ;
                                                            $readusers =  json_decode($comment->is_readnotify) ;
                                                        @endphp
                                                        @if(empty($donecomments) ||  !in_array(auth()->user()->id , $donecomments))
                                                            @if(empty($readusers) || !in_array(auth()->user()->id , $readusers))

                                                                @if(!empty($comment->tags))
                                                                    @php
                                                                        $tags = explode(',', $comment->tags);
                                                                    @endphp
                                                                    @if (in_array(Auth()->user()->id, $tags))

                                                                        @if(empty($readusers) ||  !in_array(auth()->user()->id , $readusers))
                                                                            <div class="notifi-item btn_comments_notifactions"   data-id="{{$comment->task_id}}" data-comment="{{$comment->id}}" data-done="{{$comment->done}}">

                                                                                @if(!empty($comment->user->image))
                                                                                    <img src="https://pri-po.com/public/assets/images/users/{{$comment->user->image}}" alt="img">
                                                                                @else
                                                                                    <img src="https://pri-po.com/public/assets/images/default.png" alt="img">
                                                                                @endif

                                                                                <div class="text">
                                                                                    <h4><span>{{$comment->added_by->first_name}}  </span> {{__('messages.hat_einen_neuen_Kommentar_hinzugefügt')}}</h4>
                                                                                    <p><span><i class="bi bi-calendar"></i> {{ date('d.m.Y', strtotime($comment->created_at->addhours(2))) }}</span> <span  style="margin-left: 10px"> <i class="bi bi-alarm"></i> {{ date('h:i:s', strtotime($comment->created_at->addHours(2))) }}</span> </p>
                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                    @endif

                                                                @endif
                                                            @endif

                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif


                                        </div>
                                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">


                                        @if(!empty($replays))
                                            @foreach($replays as $replay)
                                                @if($replay->added_by_id !=auth()->user()->id)
                                                    @php
                                                        $readusers =  json_decode($replay->is_readnotify) ;
                                                        $doneeplays =  json_decode($replay->is_read) ;
                                                    @endphp

                                                    @if(empty($doneeplays) ||  !in_array(auth()->user()->id , $doneeplays))


                                                        <!--Owner Of Comment -->
                                                        @if($replay->comment_author == auth()->user()->id)
                                                            @if(empty($readusers) || !in_array(auth()->user()->id , $readusers))


                                                                @if(!empty($replay->tags))

                                                                    @php
                                                                        $tags = explode(',', $replay->tags);
                                                                    @endphp
                                                                    @if (in_array(Auth()->user()->id, $tags))

                                                                        @if(empty($readusers) ||  !in_array(auth()->user()->id , $readusers))

                                                                            <!--Taged You On Your Replay   -->
                                                                                <div class="notifi-item btn-task-replaycommentNotifaction"  data-id="{{$replay->task_id}}" data-comment="{{$replay->comment_id}}" data-replay="{{$replay->id}}"   data-done="@if(!empty($replay->comment)){{$replay->comment->done}}@endif"
                                                                                     @if(!empty($readusers))
                                                                                     @if(in_array(auth()->user()->id,$readusers)) style="background-color: #FFFFFF"  @endif
                                                                                    @endif
                                                                                >

                                                                                    <img src="https://pri-po.com/public/assets/images/users/{{$replay->user->image}}" alt="img">
                                                                                    <div class="text">

                                                                                        <h4><span>{{$replay->added_by}}  </span>{{__('messages.Ich_habe_Sie_als_Antwort_auf_einen_Kommentar_erwähnt')}}   </h4>
                                                                                        <p><span><i class="bi bi-calendar"></i> {{ date('d.m.Y', strtotime($replay->created_at->addhours(2))) }}</span> <span  style="margin-left: 10px"> <i class="bi bi-alarm"></i> {{ date('h:i:s', strtotime($replay->created_at->addHours(2))) }}</span> </p>

                                                                                    </div>
                                                                                </div>
                                                                        @endif
                                                                    @else
                                                                        <!--Replay On Your Comment IF  Tags Has Value But You Not On It -->
                                                                            <div class="notifi-item btn-task-replaycommentNotifaction"  data-id="{{$replay->task_id}}" data-comment="{{$replay->comment_id}}" data-replay="{{$replay->id}}" data-done="@if(!empty($replay->comment)){{$replay->comment->done}}@endif"
                                                                                 @if(!empty($readusers))
                                                                                 @if(in_array(auth()->user()->id,$readusers)) style="background-color: #FFFFFF"  @endif
                                                                                @endif
                                                                            >

                                                                                <img src="https://pri-po.com/public/assets/images/users/{{$replay->user->image}}" alt="img">
                                                                                <div class="text">
                                                                                    <h4><span>{{$replay->added_by}}  </span> {{__('messages.hat_dein_Kommentar_beantwortet')}} </h4>
                                                                                    <p><span><i class="bi bi-calendar"></i> {{ date('d.m.Y', strtotime($replay->created_at->addhours(2))) }}</span> <span  style="margin-left: 10px"> <i class="bi bi-alarm"></i> {{ date('h:i:s', strtotime($replay->created_at->addHours(2))) }}</span> </p>


                                                                                </div>
                                                                            </div>

                                                                    @endif


                                                                @else
                                                                    <!--Replay On Your Comment -->
                                                                        <div class="notifi-item btn-task-replaycommentNotifaction"  data-id="{{$replay->task_id}}" data-comment="{{$replay->comment_id}}" data-replay="{{$replay->id}}" data-done="@if(!empty($replay->comment)){{$replay->comment->done}}@endif"
                                                                             @if(!empty($readusers))
                                                                             @if(in_array(auth()->user()->id,$readusers)) style="background-color: #FFFFFF"  @endif
                                                                            @endif
                                                                        >

                                                                            <img src="https://pri-po.com/public/assets/images/users/{{$replay->user->image}}" alt="img">
                                                                            <div class="text">
                                                                                <h4><span>{{$replay->added_by}}  </span> {{__('messages.hat_dein_Kommentar_beantwortet')}} </h4>
                                                                                <p><span><i class="bi bi-calendar"></i> {{ date('d.m.Y', strtotime($replay->created_at)) }}</span> <span  style="margin-left: 10px"> <i class="bi bi-alarm"></i> {{ date('h:i:s', strtotime($replay->created_at->addHours(2))) }}</span> </p>


                                                                            </div>
                                                                        </div>

                                                                @endif

                                                            @endif



                                                        @else

                                                            @if(!empty($replay->tags))
                                                                @php
                                                                    $tags = explode(',', $replay->tags);
                                                                @endphp
                                                                @if (in_array(Auth()->user()->id, $tags))

                                                                    @if(empty($readusers) ||  !in_array(auth()->user()->id , $readusers))

                                                                        <!--Taged You On Your Replay   -->
                                                                            <div class="notifi-item btn-task-replaycommentNotifaction"  data-id="{{$replay->task_id}}" data-comment="{{$replay->comment_id}}" data-replay="{{$replay->id}}"  data-done="@if(!empty($replay->comment)){{$replay->comment->done}}@endif"
                                                                                 @if(!empty($readusers))
                                                                                 @if(in_array(auth()->user()->id,$readusers)) style="background-color: #FFFFFF"  @endif
                                                                                @endif
                                                                            >

                                                                                <img src="https://pri-po.com/public/assets/images/users/{{$replay->user->image}}" alt="img">
                                                                                <div class="text">

                                                                                    <h4><span>{{$replay->added_by}}  </span> {{__('messages.Ich_habe_Sie_als_Antwort_auf_einen_Kommentar_erwähnt')}}  </h4>
                                                                                    <p><span><i class="bi bi-calendar"></i> {{ date('d.m.Y', strtotime($replay->created_at)) }}</span> <span  style="margin-left: 10px"> <i class="bi bi-alarm"></i> {{ date('h:i:s', strtotime($replay->created_at->addHours(2))) }}</span> </p>

                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                @endif


                                                            @endif

                                                        @endif

                                                    @endif
                                                @endforeach

                                            @endif
                                        </div>
                                    </div>
                                    <!--End Tabs -->


                                </div>
                                <!--Start  Login Status -->
                            </div>
                        </div>
                        <div class="col-3 " style="padding: 0;">
                            <div class="btn-group profile_list statuslist" >
                                <a href="#" class="dropdown-toggle text-decoration-none text-light" data-bs-toggle="dropdown">
                                    <span><i class="fa-regular fa-circle-check"></i>  Status    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" style="    width: 182px;
    margin-top: 6px;
    padding: 1px;">
                                    @if($status == 1)
                                        <li>
                                            <a class="nav-link" href="{{route('admin.dashboard','completed')}}" role="button"
                                               aria-expanded="false">
                                                <i class="fa fa-solid fa-check-double"></i>
                                                <span>{{__('messages.Erledigte_Aufgaben')}}</span>
                                            </a>
                                        </li>
                                    @else
                                        <li >
                                            <a class="nav-link" href="{{route('admin.dashboard','completed')}}" role="button"
                                               aria-expanded="false">
                                                <i class="fa fa-solid fa-check-double"></i>
                                                <span >{{__('messages.Erledigte_Aufgaben')}} </span>
                                            </a>

                                        </li>
                                    @endif
                                    @if($status == 2)

                                        <li>

                                            <a class="nav-link" href="{{route('admin.dashboard','deleted')}}" role="button" aria-expanded="false">
                                                <i class="fa fa-solid fa-trash"  ></i>
                                                <span >{{__('messages.Aufgaben_gelösch')}}   </span>
                                            </a>
                                        </li>

                                    @else
                                        <li>
                                            <a class="nav-link" href="{{route('admin.dashboard','deleted')}}" role="button"
                                               aria-expanded="false">
                                                <i class="fa fa-solid fa-trash" ></i>
                                                <span >{{__('messages.Aufgaben_gelösch')}}  </span>
                                            </a>

                                        </li>
                                    @endif


                                    @if($status == 0)
                                        <li>
                                            <a class="nav-link" href="{{route('admin.dashboard')}}" role="button" aria-expanded="false">
                                                <i class="fa fa-solid fa-check" ></i>
                                                <span> {{__('messages.Ausstehende_Aufgaben')}}    </span>
                                            </a>

                                        </li>
                                    @else

                                        <li>
                                            <a class="nav-link" href="{{route('admin.dashboard')}}" role="button" aria-expanded="false">
                                                <i class="fa fa-solid fa-check" ></i>
                                                <span> {{__('messages.Ausstehende_Aufgaben')}}  </span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-3">
                        <div class="btn-group">

                            <ul style="list-style-type: none">
                                @auth


                                    <li class="nav-item">
                                        @php
                                            $logs_count = \App\Models\Log::where('account_id', auth()->user()->account_id)->whereDate('created_at', '>=', '2023-08-16')->orderBy('id','DESC')->count();
                                            if ($logs_count > 20){
                                                $logs_count ='+20';
                                            }
                                        @endphp
                                        <!--
                                        <nav class="notfi">
                                            <div class="notify_count"> {{$logs_count}}</div>
                                            <div class="notfi-logo"></div>
                                            <div class="notfi-icon" id="notfi-bell"><img src="{{asset('public/assets/images/notification.png')}}" alt=""></div><div>
                                                <div class="notfi-notifications" id="notfi-box">
                                                    <div class="notifation-header">
                                                        <h3>{{__('messages.notifications')}}</h3>
                                                        <a class="notifactino-button" href="{{route('admin.get.all_logs')}}"
                                                           style="color:#000;"> {{__('messages.view_all')}} </a>
                                                    </div>
                                                    <div id="notifayitems">
                                                        @php
                                                            $logs = \App\Models\Log::orderBy('id','DESC')->limit(20)->get();
                                                        @endphp

                                                        @if(!empty($logs))

                                                            @foreach($logs as $log )

                                                                @php

                                                                    $arr = json_decode($log->is_read) ;
                                                                @endphp

                                                                @if(!empty($arr))
                                                                    @if((!in_array(auth()->user()->id , $arr)))

                                                                            @if(!empty($log->log_task_id))
                                                                                        <div class="notfi-notifications-item" style="background-color: #d4efff;">
                                                                                            <a href="" data-log="{{$log->id}}"
                                                                                               class="btn-task-popup"
                                                                                               data-id="{{$log->log_task_id}}">
                                                                                                <div class="display-flex">
                                                                                                    @if(!empty($log->userImage->image))
                                                                                                        <img src="{{asset('assets/images/users/'.$log->userImage->image) }}" alt="img2">  @else     <img
                                                                                                        src="https://i.imgur.com/uIgDDDd.jpg"
                                                                                                        alt="img">
                                                                                                    @endif
                                                                                                </div>
                                                                                                <div class="text">
                                                                                                    <p>  <span> @if(!empty($log->userImage->user_name)) {{$log->userImage->user_name}}    @else "User deleted" @endif  </span>   {!!$log->log_desc!!}
                                                                                                    </p>
                                                                                                </div>
                                                                                            </a>
                                                                                        </div>


                                                                            @else

                                                                                    <div class="notfi-notifications-item" style="background-color: #d4efff;">
                                                                                        <a class="notifactino-button"
                                                                                           href="{{url('admin/categories/all/'.$log->id)}}">
                                                                                            <div class="display-flex">
                                                                                                @if(!empty($log->userImage->image))   <img
                                                                                                    src="{{asset('assets/images/users/'.$log->userImage->image) }}"
                                                                                                    alt="img2">  @else     <img
                                                                                                    src="https://i.imgur.com/uIgDDDd.jpg"
                                                                                                    alt="img"> @endif
                                                                                            </div>
                                                                                            <div class="text">
                                                                                                <p> <span> @if(!empty($log->userImage->user_name)) {{$log->userImage->user_name}}    @else "User deleted" @endif  </span>  {!!$log->log_desc!!}
                                                                                                </p>
                                                                                            </div>
                                                                                        </a>
                                                                                    </div>

                                                                            @endif


                                                                        @else

                                                                            @php
                                                                                continue;
                                                                            @endphp
                                                                        @endif

                                                                     @else


                                                                    @if(!empty($log->subtask->task_id))

                                                                        <div class="notfi-notifications-item" style="background-color: #d4efff;" >
                                                                            <a href="" data-log="{{$log->id}}"
                                                                               class="btn-task-popup"
                                                                               data-id="{{$log->subtask->task_id}}">
                                                                                <div class="display-flex">
                                                                                    @if(!empty($log->userImage->image))   <img
                                                                                        src="{{asset('public/assets/images/users/'.$log->userImage->image) }}"
                                                                                        alt="img2">  @else     <img
                                                                                        src="https://i.imgur.com/uIgDDDd.jpg"
                                                                                        alt="img"> @endif

                                                                                </div>
                                                                                <div class="text">
                                                                                    <p><span> @if(!empty($log->userImage->user_name)) {{$log->userImage->user_name}}    @else "User deleted" @endif  </span>  {!!$log->log_desc!!}
                                                                                    </p>
                                                                                </div>
                                                                            </a>
                                                                        </div>



                                                                    @else
                                                                        <div class="notfi-notifications-item" style="background-color: #d4efff;" >
                                                                            <a href="{{url('admin/categories/all/'.$log->id)}}">
                                                                                <div class="display-flex">
                                                                                    @if(!empty($log->userImage->image))   <img
                                                                                        src="{{asset('public/assets/images/users/'.$log->userImage->image) }}"
                                                                                        alt="img2">  @else     <img
                                                                                        src="https://i.imgur.com/uIgDDDd.jpg"
                                                                                        alt="img"> @endif

                                                                                </div>
                                                                                <div class="text">
                                                                                    <p><span> @if(!empty($log->userImage->user_name)) {{$log->userImage->user_name}}    @else "User deleted" @endif  </span>  {!!$log->log_desc!!}
                                                                                    </p>
                                                                                </div>
                                                                            </a>
                                                                        </div>

                                                                    @endif



                                                                @endif




                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                        </nav>
                                        -->
                                    </li>



                                @endauth

                                @php
                                    $login_users = \App\Models\User::where(['account_id'=> auth()->user()->account_id])->where('login_status',1)->get();
                                    $users_images = \App\Models\User::where(['account_id'=> auth()->user()->account_id])->where('login_status',1)->limit(3)->get();
                                @endphp


                                    <div class="btn-group  profile_list">
                                        <a href="#" class="dropdown-toggle text-decoration-none text-light login_images" data-bs-toggle="dropdown">
                                            <!--<i class="bi bi-person-circle"></i>-->
                                            @foreach($users_images as $image)
                                                <img src="{{asset('public/assets/images/users/'.$image->image)}}" style="width:30px;height:30px;" class="rounded-circle">

                                            @endforeach
                                        </a>
                                        @if(!empty($users))
                                        <ul class="dropdown-menu dropdown-menu-end">
                                                    @foreach($login_users as $user)
                                                        <li>
                                                            <a class="dropdown-item user-data" href="#">
                                                                @if(!empty($user->image))
                                                                    <img src="{{asset('public/assets/images/users/'.$user->image)}}" alt="img"
                                                                         class="img-user">
                                                                @else
                                                                    <img src="{{asset('public/assets/images/default.png')}}" alt="img"
                                                                         class="img-user">
                                                                @endif

                                                                <h5> {{$user->user_name}}  </h5>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                    </div>
                        </div>
                        </div>
                        <div class="col-3" style="padding: 0">
                            <div class="btn-group  profile_list" style="margin-right: 40px">
                                <a href="#" class="dropdown-toggle text-decoration-none text-light" data-bs-toggle="dropdown">
                                    <!--<i class="bi bi-person-circle"></i>-->
                                    <img src="{{asset('public/assets/images/users/'.auth()->user()->image)}}"
                                         style="width:30px;height:30px;" class="rounded-circle">
                                    <span>{{ Str::limit(auth()->user()->user_name, 8) }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" >

                                    <li><a href="#" class="dropdown-item" data-type="profile_update" id="update_profile"><i
                                                class="bi bi-person-circle"></i>{{__('messages.profile_update')}}</a></li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    @if(auth()->user()->role == 1 || auth()->user()->role == 4)
                                        <li><a class="dropdown-item" data-type="user_create" href="{{route('admin.crm')}}"><i class="bi bi-menu-button-wide-fill"></i> CRM</a></li>
                                    @endif
                                    @if(auth()->user()->role == 1)
                                        <li>
                                            @if(Session::has('user_name'))
                                                <a class="dropdown-item" data-type="user_create" href="https://pri-po.com/admin/custom_login/{{Session::get('user_name')}}/{{Session::get('user_pass')}}" class="btn btn-warning">Pri-po.com </a>
                                            @endif
                                        </li>
                                    @endif

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li class="dropdown-item" style="padding: 0">
                                        <form action="{{route('changeLang')}}" method="get">
                                            <select name="lang" id="lang" onchange="this.form.submit()" class="form-control"
                                                    style="background-color: #141833;color: white;border: none">
                                                <option value="en" {{(session()->get('locale') === 'en' || session()->get('locale') === '')?'selected' :''}}><span>🇺🇸</span>
                                                    <span>English</span></option>
                                                <option value="de" {{session()->get('locale') === 'de'?'selected' :''}}><span>🇩🇪</span>
                                                    <span>Deutsch</span></option>
                                                <option value="tr" {{session()->get('locale') === 'tr'?'selected' :''}}><span>🇹🇷</span>
                                                    <span>Turkish</span></option>
                                            </select>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>


<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Noch da?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> {{__('messages.are_you_there')}}</p>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary" id="popup_button">Ja</button>
                </div>
            </div>
        </div>
    </div>


    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <div class="right-sidebar">
        <nav class="sidebar-navigation">
            <ul>

                <li class="nav-item myposts_icon">
                    <a  class="nav-link" href="{{route('admin.tasks.pending_posts')}}" target="_blank" role="button" aria-expanded="false">
                        <i class="fa-solid fa-boxes-stacked" style="color:#fff;background-color:#e2a03f;display: none"></i>
                        <span class="tooltip">{{__('messages.pending_posts')}}</span>
                    </a>
                </li>

                <li class="nav-item myposts_icon">
                    <a class="nav-link" href="{{route('admin.tasks.my_posts')}}" target="_blank" role="button" aria-expanded="false">
                        <i class="fa-solid fa-boxes-stacked" style="color:#fff;background-color:#74a7ff;"></i>
                        <span class="tooltip">{{__('messages.my_posts')}}</span>
                    </a>
                </li>

                <li class="nav-item admintasks">
                    <a class="nav-link" href="{{route('admin.usertasks')}}" target="_blank" role="button" aria-expanded="false">
                        <i class="fa fa-solid fa-list-check" style="color:#fff;"></i>
                        <span class="tooltip">{{__('messages.my_tasks')}}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.subtasks.viewcomments')}}" target="_blank" role="button" aria-expanded="false">
                        <i class="fa fa-solid fa-comments" style="color:#fff;"></i>
                        <span class="tooltip">{{__('messages.comments')}}</span>
                    </a>
                </li>

                <li class="nav-item test">
                    <a class="nav-link" href="{{route('admin.subtasks.tests')}}" target="_blank" role="button" aria-expanded="false">
                        <i class="fa fa-solid fa-check-to-slot" style="color:#fff;"></i>
                        <span class="tooltip">{{__('messages.tests')}}</span>
                    </a>
                </li>
                <li class="nav-item history">
                    <a class="nav-link" href="{{route('admin.subtasks.task_history')}}" target="_blank" role="button" aria-expanded="false">
                        <i class="fa fa-solid fa-clock-rotate-left" style="color:#fff;"></i>
                        <span class="tooltip">{{__('messages.time_tracking')}}</span>
                    </a>
                </li>

                <li class="nav-item assignedtasks">
                    <a class="nav-link" href="{{route('admin.subtasks.assigned_tasks')}}" target="_blank" role="button" aria-expanded="false">
                        <i class="fa fa-solid fa-list-ul" style="color:#fff;"></i>
                        <span class="tooltip">{{__('messages.assigned_tasks')}}</span>
                    </a>
                </li>
                <li class="nav-item chat">
                    <a class="nav-link" href="{{route('admin.chat.chat_rooms')}}" target="_blank" role="button" aria-expanded="false">
                        <i class="fa fa-solid fa-comments" style="color:#fff;background-color:#ec6630;"></i>
                        <span class="tooltip">Chat</span>
                    </a>
                </li>

                <li class="nav-item logout">
                    <a class="nav-link" href="{{route('admin.logout')}}"  role="button" aria-expanded="false">
                        <i class="fa fa-solid fa-arrow-right-from-bracket" style="color:#fff;"></i>
                        <span class="tooltip">Ausloggen</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

</div>

<!--START PLUS -->
<nav class="float-action-button">


    @if(auth()->user()->role == 1)

        <a href="#" data-type="user_create"  class="buttons"   data-bs-toggle="tooltip" data-bs-placement="right" title="{{__('messages.user')}}"  >
            <i class="fa fa-solid fa-user-plus"></i>
        </a>
        <a href="#" data-type="invite_create" class="buttons"   data-bs-toggle="tooltip" data-bs-placement="right" title="{{__('messages.invite')}}"  >

            <i class="fa fa-solid fa-envelope"></i>
        </a>
        <a href="#" data-type="guest_create" class="buttons"  data-bs-toggle="tooltip" data-bs-placement="right" title="{{__('messages.guest')}}"  >
            <i class="fa fa-solid fa-user-check"></i>
        </a>

    @endif

    @if(auth()->user()->role == 4)
    <a href="#"  data-type="user_create" class="buttons"  data-bs-toggle="tooltip" data-bs-placement="right" title="Benutzer" >
        <i class="fa fa-solid fa-user"></i>
    </a>
    @endif
  <a href="#" data-type="tag_create" class="buttons" data-bs-toggle="tooltip" data-bs-placement="right" title="Tag" >
          <i class="fa fa-solid fa-tag"></i>
  </a>



  <a href="#" data-type="project_create"  class="buttons" data-bs-toggle="tooltip" data-bs-placement="right" title="Task">
          <i class="fa fa-solid fa-list"></i>
  </a>
    <a href="#" data-type="task_create" class="buttons" data-bs-toggle="tooltip" data-bs-placement="right" title="Post-it">
          <i class="fa-solid fa-clipboard"></i>
  </a>
        <a href="#" data-type="ideen_create" class="buttons" data-bs-toggle="tooltip" data-bs-placement="right" title="Ideen" >
            <i class="fa fa-solid fa-bookmark"></i>
        </a>

  <a href="#" class="buttons main-button" data-bs-toggle="tooltip" data-bs-placement="right" title="Share" >
          <i class="fa fa-times"></i>
          <i class="fa fa-solid fa-plus"></i>
  </a>



</nav>


<ul class="dropdown-menu" id="links" aria-labelledby="navbarDropdownMenuLink">
    <li><a class="dropdown-item" data-type="task_create" href="#">Post-it</a></li>
    <li><a class="dropdown-item" data-type="project_create" href="#">Task</a></li>

    <li><a class="dropdown-item" data-type="tag_create" href="#">Tag</a></li>

    @if(auth()->user()->role == 4)
        <li><a class="dropdown-item" data-type="user_create" href="#">Benutzer</a></li>
    @endif


    @if(auth()->user()->role == 1)
        <li><a class="dropdown-item" data-type="user_create"
               href="#">{{__('messages.user')}}</a></li>
        <li><a class="dropdown-item" data-type="guest_create"
               href="#">{{__('messages.guest')}}</a></li>
        <li><a class="dropdown-item" data-type="invite_create"
               href="#">{{__('messages.invite')}}  </a></li>
    @endif
</ul>

