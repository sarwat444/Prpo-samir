@extends('layouts.dashboard')
@section('css')
    <link  rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <style>
       .cards{
           padding: 0px 64px 0px 23px;
       }
       .search-btn {
           background-color: #009eff;
           color: #fff;
           border: 0;
           padding: 9px;
           height: 40px;
           width: 40px;
           border-radius: 50%;
           margin-top: 10px;
           margin-left: -29px;
           transition: all .5 ease-in-out;
       }
       .search-btn:hover {
           background-color: #ffffff;
           color: #009eff;
       }

       .search-btn:hover .bi-search::before {
           transform: rotate(90deg);
       }

       .ms-options {
           display: block;
           max-height: 222px;
       }
       .fillter
       {
           padding: 12px 0 11px 0 !important;
       }
       .task_status
       {
           background-color: #fff !important;
           border-radius: 0 !important;
           font-size: 13px !important;
           padding: 10px !important;
           margin-top: 7px !important;
       }
       .filtered_data
       {
           background-color: transparent;
       }
    </style>
@endsection
@section('title'){{$title}}@endsection
@section('content')
    <div class="container-fluid">
        <div class="cards mytasks" id="cards">
            @if(Auth::user()->role == 1 )
                <div class="fillter">
                    <div class="row justify-content-center">
                            <div class="col-md-2">
                                <div class="form-control">
                                    <select name="users" id="subtasks_users" is="ms-dropdown" data-type="user_filter"  data-gender="list" data-enable-auto-filter="true" required>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}" @if(Auth::user()->id  == $user->id)  selected @endif data-image="{{asset('public/assets/images/users/'.$user->image)}}">{{$user->user_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control task_status" id="task_status">
                                    <option value="0"> {{__('messages.pending')}} </option>
                                    <option value="1"> {{__('messages.completed')}} </option>
                                    <option value="2"> {{__('messages.deleted')}} </option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <div class="search_filter">
                                    <button class="search-btn"><i class="fa fa-search"></i></button>
                                </div>
                            </div>

                    </div>
                </div>
            @endif
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="row sortable-cards filtered_data" id="shuffle">
                        @if(!empty($tasks))
                             @foreach ($tasks as $key => $task)
                                @if(!empty($task->category))
                                        <div class="col-md-3  sortable-divs mix ui-state-default {{$task->category->category_name}}" data-id="{{$task->id}}" id="task{{$task->id}}">
                                            <div class="card sort animate__animated animate__fadeIn" @if(!empty($task->image)) style="background-size: cover; background-image: linear-gradient(to right bottom, rgba(6, 46, 78, 0.42), rgba(20, 25, 53, 0.53)), url('{{asset('uploads/images/compressed/'.$task->image)}}'); background-position: center center;" @elseif(!empty($task->category->category_color)) style="background-color: {{ $task->category->category_color }}" @endif >
                                                <div class="card-contents">
                                                    <div class="top-bar">
                                                        <div class="row">

                                                            <div class="col-md-6">
                                                                <p>{{!empty($task->category->category_name) ? $task->category->category_name :' ' }} {{!empty($task->second_category->category_name) ? '/'.$task->second_category->category_name :' ' }}</p>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <p> {{$task->completed_subtasks->count()}} /{{$task->subtasks->count()}}</p>
                                                            </div>
                                                            <div class="col-md-3">

                                                                @if(!empty($task->responsible))
                                                                    @if(file_exists(public_path().'/assets/images/users/'.$task->responsible->image))
                                                                        <img src="{{asset('public/assets/images/users/'.$task->responsible->image)}}" alt="member2">
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
                                                                    $teamids = \App\Models\TaskTeam::where('task_id' , $task->id)->pluck('user_id');
                                                                    $teams   =  \App\Models\User::whereIn('id',$teamids)->get();
                                                                @endphp

                                                                @if(!empty($teams))
                                                                    @foreach ($teams->take(4) as $key => $team)
                                                                        <li>
                                                                            @if(!empty($team->image))
                                                                                @if(file_exists(public_path().'/assets/images/users/'.$team->image))
                                                                                    <img src="{{asset('public/assets/images/users/'.$team->image)}}" alt="member">
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

                                                                <button class="btn btn-default btn-task-popup" data-id="{{$task->id}}" ><i class="fa fa-solid fa-plus"></i></button>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                    <div class="button-bar">
                                                        <div class="row">

                                                            <div class="col-md-6">
                                                                @if(!empty($task->added_by))

                                                                    @if(file_exists(public_path().'/assets/images/users/'.$task->added_by->image))
                                                                        <img src="{{asset('public/assets/images/users/'.$task->added_by->image)}}" alt="member">
                                                                    @else
                                                                        <img src="https://source.unsplash.com/user/c_v_r">
                                                                    @endif

                                                                @endif
                                                                <button class="btn btn-default copy" data-id="{{$task->id}}" ><i class="fa fa-solid fa-copy"></i></button>
                                                                <span> {{--!empty($task->added_by->user_name) ? $task->added_by->user_name :' ' --}} </span></div>
                                                            <div class="col-md-6">

                                                                <p> {{ date('d.m.Y', strtotime($task->task_due_date))}} </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endif
                           @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('public/assets/admin/assets2/js/mixitup.min.js')}}"></script>

    <script>

        $('.search-btn').on('click', function () {
            var subtask_user_id = $('#subtasks_users').val();
            var task_status  = $("#task_status").val();

            //  Users
            if (subtask_user_id != '' && task_status != '' ) {
                $.ajax({
                    type: "POST",
                    url: '{{route('admin.filter.myposts')}}',   // need to create this post route
                    data: {
                        subtask_user_id: subtask_user_id,
                        task_status: task_status,
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    success: function (data) {
                        $('.filtered_data').html(data.options);
                    },
                    error: function (jqXHR, status, err) {
                    },
                });
            }
        });
    </script>

@endsection
