@php use App\Models\TaskTeam; @endphp
@extends('layouts.dashboard')
@section('css')
    <link rel="stylesheet" href="{{asset('public/public/assets/css/animate.css')}}"/>
    <link rel="stylesheet" href="{{asset('public/public/assets/css/fontawesome6.css')}}"/>
    <style>
        .pripo-btn {
            border-radius: 0;
            background: linear-gradient(180deg, #ec6630, #ec6630);
            border: 0;
            padding: 5px 18px;
            color: #fff;
            font-size: 15px;
            border-radius: 4px;
            text-decoration: none;
            box-shadow: 3px 4px #437193;
        }

        .pripo-btn i {
            margin-left: 5px;
        }

        .pripo-btn:hover {
            color: #cccccc;
        }
        .idea
        {
            background: linear-gradient(180deg, #ec6630, #ec6630);
            min-height: 278px;
        }
        .idea .middle-content {
            margin-top: 37px !important;
            margin-bottom: 62px !important;
        }
    </style>
@endsection
@section('title')
    {{$title}}
@endsection
@section('content')
    <div class="continer">
        <div class="row justify-content-center ">
            <div class="col-md-12">
                <div class="alert-messages">
                    <!--Success Messages -->
                    @if (session('success'))
                        <div class="alert alert-success" id="successMessage">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-11">
            <section class="bg-diffrent">
                <div class="row">
                    <div class="col-md-3 text-center">
                        @if(Auth::user()->id  == 27 )
                            @if(Session::has('user_name'))
                                <a class="pripo-btn"
                                   href="https://gtek.pri-po.com/admin/custom_login/{{Session::get('user_name')}}/{{Session::get('user_pass')}}"
                                   class="btn btn-warning">Gtek.com <i class="fa-solid fa-link"></i></a>
                            @endif
                        @endif
                    </div>
                    <div class="col-md-9">
                        <div class="category-lists-slider">
                            <div class="swiper-container" id="catgory-slider">
                                <div class="swiper-wrapper" id="swiper">


                                    @if(!empty($users))
                                        @foreach($users as $user)
                                            <div class="swiper-slide cat_list">
                                                <a href="{{route('admin.user.tasks',['user_id' => $user->id ,'status' => $status ])}}">
                                                    <div class="category-button  filter" data-type="user"
                                                         data-status="{{$status}}" data-id="{{$user->id}}">
                                                        @if(!empty($user->image))
                                                            <img src="{{asset('public/assets/images/users/'.$user->image)}}"/> <span>{{ Str::limit($user->user_name, 8) }}</span>
                                                        @else
                                                            <img src="{{asset('public/assets/images/default.png')}}"/> {{ Str::limit($user->user_name, 8) }}
                                                        @endif
                                                    </div>
                                                </a>
                                            </div>

                                        @endforeach
                                    @endif

                                    @if(!empty($invited_users))
                                        @foreach($invited_users as $invited_user)
                                            <div class="swiper-slide cat_list">
                                                <a href="{{route('admin.user.tasks',['user_id' => $invited_user->id ,'status' => $status ])}}">
                                                    <div class="category-button  filter" data-type="user"
                                                         data-status="{{$status}}" data-id="{{$user->id}}">
                                                        {{$invited_user->user_name}}
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif


                                </div>
                            </div>
                            <div class="slider-button slider-prev"><i class="fa fa-chevron-left"></i></div>
                            <div class="slider-button slider-next"><i class="fa fa-chevron-right"></i></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="cards" id="cards">

        <div class="row justify-content-center ">
            <div class="col-md-2">
                <div class="category_sidebar">
                    <ul>
                        <a href="{{route('admin.cat.tasks',['cat_id' => 0,'status' => $status])}}">
                            <li class="category-button  filter"
                                data-status="{{$status}}"> {{__('messages.Alle')}}  </li>
                        </a>
                        @if(count($categories) > 0)
                            @foreach($categories as $cat)
                                <a href="{{route('admin.cat.tasks',['cat_id' => $cat->id ,'status' => $status ])}}">
                                    <li class="category-button  filter"
                                        data-status="{{$status}}">  {{$cat->category_name}} </li>
                                </a>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <!--end Success Messages -->
                <div class="row sortable-cards" id="shuffle">
                    <!--Start Ideas Cards -->
                    @if(!empty($ideas))
                        @foreach($ideas as $task)
                            <div class="col-md-3  sortable-divs mix ui-state-default"
                                 data-id="{{$task->id}}" id="task{{$task->id}}">
                                <div class="card sort  @if(!empty($task->type == 1 )) idea  @endif">
                                    <div class="card-contents">
                                        <div class="middle-content">
                                            <h3>{!!substr($task->task_title,0,70)!!}</h3>
                                            <br>
                                            <div class="members">
                                                <ul>
                                                    <button class="btn btn-default btn-task-popup" data-id="{{$task->id}}"><i class="fa fa-plus"></i></button>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="button-bar">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    @if(!empty($task->added_by))

                                                        @if(file_exists(public_path().'/assets/images/users/'.$task->added_by->image))
                                                            <img src="{{asset('public/assets/images/users/'.$task->added_by->image)}}"
                                                                 alt="member">
                                                        @else
                                                            <img src="https://source.unsplash.com/user/c_v_r">
                                                        @endif

                                                    @endif
                                                    <span> {{--!empty($task->added_by->user_name) ? $task->added_by->user_name :' ' --}} Erstellt von </span>
                                                </div>
                                                <div class="col-md-6">
                                                    <p> {{ date('d.m.Y', strtotime($task->task_due_date))}} </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <!--End Ideas Cards -->
                    @if(count($categories) > 0)
                        @foreach ($categories as $key => $cat)
                            @if($status == 0)
                                @foreach ($cat->tasks as $key => $task)
                                    <div class="col-md-3  sortable-divs mix ui-state-default {{$task->category->category_name}}"
                                         data-id="{{$task->id}}" id="task{{$task->id}}">
                                        <div class="card sort animate__animated animate__fadeIn"
                                             @if(!empty($task->image))
                                                 style="background-size: cover; background-image: linear-gradient(to right bottom, rgba(6, 46, 78, 0.42), rgba(20, 25, 53, 0.53)), url('{{asset('uploads/images/compressed/'.$task->image)}}'); background-position: center center;"
                                             @elseif(!empty($task->category->category_color)) style="background-color: {{ $task->category->category_color }}"
                                             @else
                                                 @if(!empty($task->category->category_color) && !empty($task->second_category->category_color)) style="background:linear-gradient(0deg, {{$task->category->category_color }} 50%,  {{$task->second_category->category_color}} 50%);"
                                             @elseif(!empty($task->category->category_color)) style="background-color:{{$task->category->category_color}}" @endif >
                                            @endif
                                            >


                                            <div class="card-contents">
                                                <div class="top-bar">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>{{!empty($task->category->category_name) ? $task->category->category_name :' ' }} {{!empty($task->second_category->category_name) ? '/'.$task->second_category->category_name :' ' }}</p>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p> {{$task->completed_subtasks->count()}}
                                                                /{{$task->subtasks->count()}}</p>
                                                        </div>
                                                        <div class="col-md-3">

                                                            @if(!empty($task->responsible))
                                                                @if(file_exists(public_path().'/assets/images/users/'.$task->responsible->image))
                                                                    <img src="{{asset('public/assets/images/users/'.$task->responsible->image)}}"
                                                                         alt="member2">
                                                                @else
                                                                    <img src="https://source.unsplash.com/user/c_v_r">
                                                                @endif

                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="middle-content">

                                                    <h3 style="font-size:17px;">{!!substr($task->task_title,0,70)!!}</h3>
                                                    <br>
                                                    <div class="members">
                                                        <ul>

                                                            @php
                                                                $teamids = TaskTeam::where('task_id' , $task->id)->pluck('user_id');
                                                                $teams   =  \App\Models\User::whereIn('id',$teamids)->get();
                                                            @endphp

                                                            @if(!empty($teams))
                                                                @foreach ($teams->take(4) as $key => $team)
                                                                    <li>
                                                                        @if(!empty($team->image))
                                                                            @if(file_exists(public_path().'/assets/images/users/'.$team->image))
                                                                                <img src="{{asset('public/assets/images/users/'.$team->image)}}"
                                                                                     alt="member">
                                                                            @endif
                                                                        @else
                                                                            <img src="{{asset('public/assets/images/default.png')}}">
                                                                        @endif


                                                                    </li>
                                                                @endforeach
                                                            @endif

                                                            @if(count($teams) > 4)
                                                                ....
                                                            @endif

                                                            <button class="btn btn-default btn-task-popup"
                                                                    data-id="{{$task->id}}"><i
                                                                        class="fa fa-solid fa-plus"></i></button>
                                                        </ul>

                                                    </div>
                                                </div>
                                                <div class="button-bar">
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            @if(!empty($task->added_by))

                                                                @if(file_exists(public_path().'/assets/images/users/'.$task->added_by->image))
                                                                    <img src="{{asset('public/assets/images/users/'.$task->added_by->image)}}"
                                                                         alt="member">
                                                                @else
                                                                    <img src="https://source.unsplash.com/user/c_v_r">
                                                                @endif

                                                            @endif
                                                            <button class="btn btn-default copy"
                                                                    data-id="{{$task->id}}"><i
                                                                        class="fa fa-solid fa-copy"></i></button>
                                                            <span> {{--!empty($task->added_by->user_name) ? $task->added_by->user_name :' ' --}} </span>
                                                        </div>
                                                        <div class="col-md-6">

                                                            <p> {{ date('d.m.Y', strtotime($task->task_due_date))}} </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            @endif
                            @if($status == 1)
                                @foreach ($cat->completed_tasks as $key => $task)

                                    <div class="col-md-3  sortable-divs mix ui-state-default {{$task->category->category_name}}"
                                         data-id="{{$task->id}}" id="task{{$task->id}}">
                                        <div class="card sort"
                                             @if(!empty($task->category->category_color) && !empty($task->second_category->category_color)) style="background:linear-gradient(0deg, {{$task->category->category_color }} 50%,  {{$task->second_category->category_color}} 50%);"
                                             @elseif(!empty($task->category->category_color)) style="background-color:{{$task->category->category_color}}" @endif >
                                            <div class="card-contents">
                                                <div class="top-bar">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p>{{!empty($task->category->category_name) ? $task->category->category_name :' ' }} {{!empty($task->second_category->category_name) ? '/'.$task->second_category->category_name :' ' }}</p>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p> {{$task->completed_subtasks->count()}}
                                                                /{{$task->subtasks->count()}}</p>
                                                        </div>
                                                        <div class="col-md-3">

                                                            @if(!empty($task->responsible))

                                                                @if(file_exists(public_path().'/assets/images/users/'.$task->responsible->image))
                                                                    <img src="{{asset('public/assets/images/users/'.$task->responsible->image)}}"
                                                                         alt="member">
                                                                @else
                                                                    <img src="https://source.unsplash.com/user/c_v_r">
                                                                @endif
                                                                <p>Verantwortlich</p>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="middle-content">

                                                    <h3>{!!substr($task->task_title,0,70)!!}</h3>
                                                    <br>
                                                    <div class="members">
                                                        <ul>


                                                            @php
                                                                $teamids = TaskTeam::where('task_id' , $task->id)->pluck('user_id');
                                                                $teams   =  \App\Models\User::whereIn('id',$teamids)->get();
                                                            @endphp

                                                            @if(!empty($teams))
                                                                @foreach ($teams->take(4) as $key => $team)
                                                                    <li>
                                                                        @if(file_exists(public_path().'/assets/images/users/'.$team->image))
                                                                            <img src="{{asset('public/assets/images/users/'.$team->image)}}"
                                                                                 alt="member">
                                                                        @else
                                                                            <img src="https://source.unsplash.com/user/c_v_r">
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            @endif

                                                            @if(count($teams) > 4)
                                                                ....
                                                            @endif

                                                            <button class="btn btn-default btn-task-popup"
                                                                    data-id="{{$task->id}}"><i
                                                                        class="bi bi-plus-circle"></i></button>
                                                        </ul>

                                                    </div>
                                                </div>
                                                <div class="button-bar">
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            @if(!empty($task->added_by))

                                                                @if(file_exists(public_path().'/assets/images/users/'.$task->added_by->image))
                                                                    <img src="{{asset('public/assets/images/users/'.$task->added_by->image)}}"
                                                                         alt="member">
                                                                @else
                                                                    <img src="https://source.unsplash.com/user/c_v_r">
                                                                @endif

                                                            @endif
                                                            <span> {{--!empty($task->added_by->user_name) ? $task->added_by->user_name :' ' --}} Erstellt von </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p>Falligkeitsdatum</p>
                                                            <p> {{ date('d.m.Y', strtotime($task->task_due_date))}} </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif


                            @if($status == 2)
                                @foreach ($cat->deleted_tasks as $key => $task)

                                    <div class="col-md-3  sortable-divs mix ui-state-default {{$task->category->category_name}}"
                                         data-id="{{$task->id}}" id="task{{$task->id}}">
                                        <div class="card sort"
                                             @if(!empty($task->category->category_color) && !empty($task->second_category->category_color)) style="background:linear-gradient(0deg, {{$task->category->category_color }} 50%,  {{$task->second_category->category_color}} 50%);"
                                             @elseif(!empty($task->category->category_color)) style="background-color:{{$task->category->category_color}}" @endif >

                                            <div class="card-contents">
                                                <div class="top-bar">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <p>{{!empty($task->category->category_name) ? $task->category->category_name :' ' }} {{!empty($task->second_category->category_name) ? '/'.$task->second_category->category_name :' ' }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p> {{$task->completed_subtasks->count()}}
                                                                /{{$task->subtasks->count()}}</p>
                                                        </div>
                                                        <div class="col-md-5">
                                                            @if(!empty($task->responsible))

                                                                @if(file_exists(public_path().'/assets/images/users/'.$task->responsible->image))
                                                                    <img src="{{asset('public/assets/images/users/'.$task->responsible->image)}}"
                                                                         alt="member">
                                                                @else
                                                                    <img src="https://source.unsplash.com/user/c_v_r">
                                                                @endif
                                                                <p>Verantwortlich</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="middle-content">

                                                    <h3>{!!substr($task->task_title,0,70)!!}</h3>
                                                    <br>
                                                    <div class="members">
                                                        <ul>

                                                            @php
                                                                $teamids = TaskTeam::where('task_id' , $task->id)->pluck('user_id');
                                                                $teams   =  \App\Models\User::whereIn('id',$teamids)->get();
                                                            @endphp

                                                            @if(!empty($teams))
                                                                @foreach ($teams->take(4) as $key => $team)
                                                                    <li>
                                                                        @if(file_exists(public_path().'/assets/images/users/'.$team->image))
                                                                            <img src="{{asset('public/assets/images/users/'.$team->image)}}"
                                                                                 alt="member">
                                                                        @else
                                                                            <img src="https://source.unsplash.com/user/c_v_r">
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            @endif

                                                            @if(count($teams) > 4)
                                                                ....
                                                            @endif

                                                            <button class="btn btn-default btn-task-popup"
                                                                    data-id="{{$task->id}}"><i
                                                                        class="bi bi-plus-circle"></i></button>
                                                        </ul>

                                                    </div>
                                                </div>
                                                <div class="button-bar">
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            @if(!empty($task->added_by))

                                                                @if(file_exists(public_path().'/assets/images/users/'.$task->added_by->image))
                                                                    <img src="{{asset('public/assets/images/users/'.$task->added_by->image)}}"
                                                                         alt="member">
                                                                @else
                                                                    <img src="https://source.unsplash.com/user/c_v_r">
                                                                @endif

                                                            @endif
                                                            <span> {{--!empty($task->added_by->user_name) ? $task->added_by->user_name :' ' --}} Erstellt von </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p>Falligkeitsdatum</p>
                                                            <p> {{ date('d.m.Y', strtotime($task->task_due_date))}} </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach

                    @else
                        <!--iF No Category  Add New Task -->
                        <div class="col-md-3">

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('public/public/assets/js/fontawesome6.js')}}"></script>
    <script src="{{asset('public/assets/admin/assets2/js/mixitup.min.js')}}"></script>
    <script src="{{asset('public/assets/admin/assets2/js/slick.min.js')}}"></script>
    <script src="{{asset('/js/app.js')}}"></script>
@endsection
