@if(!empty($tasks))
    @foreach ($tasks as $key => $task)
        <div class="col-md-3  sortable-divs mix ui-state-default {{!empty($task->category->category_name) ? $task->category->category_name :' ' }}" data-id="{{$task->id}}" id="task{{$task->id}}">
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
    @endforeach
@endif
