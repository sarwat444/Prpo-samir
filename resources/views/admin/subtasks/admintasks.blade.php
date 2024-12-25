@extends('layouts.dashboard')
@section('css')
    <link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
    <script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}"></script>
    <link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
    <link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">
    <style>
        #stopWatch {
            height: auto;
            text-align: center;
            display: block;
            padding: 5px;
             width: 130px;
        }

        #timer,
        #fulltime {
            height: auto;
            font-size: 13px;
            font-family: ubuntu;
            display: block;
            text-align: center;
            color: #013c60;
        }

        #fulltime {
            display: none;
            font-size: 16px;
            font-weight: bold;
        }

        .mytasks .tasks .task {
            background-color: #fff;
            width: 100%;
            margin: 0 auto;
            padding-top: 10px;
            border-bottom: 1px solid #ccc;
            margin-bottom: 2px;
            font-size: 12px;
            text-align: center;
            /* font-weight: bold; */
        }

        .start,
        #stop,
        #pause {
            font-size: 14px;
            margin-right: 4px;
        }

        .start,
        #continue {
            color: #0576eb;
        }

        #start:hover,
        #continue:hover {
            color: #0261c3;
            cursor: pointer;
        }

        #stop,
        .stop {
            color: #f00;
        }

        #stop:hover,
        .stop:hover {
            color: #b30404d6;
            cursor: pointer;
        }

        #pause,
        .pause {
            color: #ccc;
        }

        #pause:hover,
        #pause:hover {
            color: #777;
            cursor: pointer;
        }

        .hidden {
            display: none;
        }

        .recodtime {
            position: fixed;
            right: 49px;
            bottom: 2px;
            border-radius: 0;
            background-color: #107a28;
            color: #fff;
            width: 25%;
            text-align: center;
            padding-top: 12px;
            border-radius: 4px;
            border: 0;
            padding-bottom: 0;
            display: none;
            font-size: 13px;
        }

        .recodtime i {
            margin-right: 5px;
        }

        .timerecorder {
            border: 1px solid #ccc;
            */ /* padding: 10px; */ text-align: center;
            font-size: 13px;
            margin-top: 16px;
            padding: 0px;
            color: #198754;
        }

        #todos,
        #list_todos {
            font-size: 13px;
            margin-top: 5px;
            background-color: #eee;
            padding: 5px 25px;
            border: 1px solid #00000012;
            margin-bottom: 15px;

        }

        .todoslist .heading {
            color: #009eff;
            font-weight: 500;
            font-size: 13px;
        }

        #stopWatch i {
            font-size: 18px;
        }

        .datepicker {
            padding: 7px !important;
            height: 44px !important;
            border-radius: 0 !important;
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

    </style>
@endsection
@section('title')Meine Aufgaben @endsection
@section('content')
    <!--Start  Users Tasks -->
    <div class="container">
        <!--Start Final Timer Alert -->
        <alert class="alert alert-success recodtime">
            <p><i class="fa fa-check-circle"></i> Time Entery wurde erfolgreich erstellt </p>
        </alert>


        <!--End Timer Alert -->
        <div class="mytasks">
            <input type="hidden" id="gender" name="gender" value="list">
            <div class="sub-tasks">
                    <div class="fillter">
                    <div class="row ">
                        @if(Auth::user()->role == 1 )
                            <div class="col-md-2">
                                <div class="form-control">
                                    <select name="users" id="subtasks_users" is="ms-dropdown" data-type="user_filter"
                                            data-gender="list" data-enable-auto-filter="true" required>
                                        <option value="all"> All Employees</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}"
                                                    data-image="{{asset('public/assets/images/users/'.$user->image)}}">{{$user->user_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="datepicker" data-type="date_filter" data-gender="list">
                                        <input type="text" data-type="date_filter"
                                               class="start_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target"
                                               data-name="task_due_date" name="task_due_date"
                                               placeholder="{{__('messages.from')}}">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="datepicker">
                                        <input type="text" data-type="date_filter" data-gender="list"
                                               class="end_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target"
                                               data-name="task_due_date" name="task_due_date"
                                               placeholder="{{__('messages.to')}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-control status">
                                <input id="done" type="radio" name="subtask_status" value='1' data-type="status_filter"
                                       data-gender="list"/> <label>{{__('messages.done')}}</label>
                                <input id="pending" type="radio" name="subtask_status" value='2'
                                       data-type="status_filter"
                                       data-gender="list"/> <label>{{__('messages.pending')}}</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-control status">
                                <input type="radio" name="subtask_status2" value='3' data-type="status2_filter"
                                       data-gender="list"/> <label>{{__('messages.created_at')}}</label>
                                <input type="radio" name="subtask_status2" value='4' data-type="status2_filter"
                                       data-gender="list"/> <label> {{__('messages.due_date')}} </label>
                                <input type="radio" name="subtask_status2" value='5' data-type="status2_filter"
                                       data-gender="list"/> <label>{{__('messages.done_at')}} </label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="search_filter">
                                <button class="search-btn"><i class="fa fa-search"></i></button>
                            </div>
                        </div>

                </div>
                <div class="row" style="
                  direction: rtl;
                    background-color: #ffff;
                    width: 100%;
                    margin: 0;">
                    <div class="col-md-2">
                                <button id="todos" class="btn">
                                    <img width="22" src="https://img.icons8.com/external-dreamstale-lineal-dreamstale/32/000000/external-grid-alignment-dreamstale-lineal-dreamstale.png"/>
                                </button>
                                <button id="list_todos" class="btn">
                                    <img width="22" src="https://img.icons8.com/ios/50/000000/list--v1.png"/>
                                </button>
                   </div>
                </div>

                @if(!empty($user_subtasks))

                    <div class="filtered_data">
                        <table id="subtasks_history" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Status</th>
                                <th>{{__('messages.subtask')}}</th>
                                <th>{{__('messages.post')}}</th>
                                <th>{{__('messages.category')}}</th>
                                <th>{{__('messages.created_by')}}</th>
                                <th>{{__('messages.created_at')}}</th>
                                <th>{{__('messages.done_at')}}</th>
                                <th>{{__('messages.due_date')}}</th>
                                <th>{{__('messages.timer')}}</th>
                                <th>{{__('messages.details')}}</th>
                            </tr>
                            </thead>
                            <tbody class="tasks  user_subtasks" id="bodycontent">
                            @foreach($user_subtasks as $subtask)
                                <tr>
                                    <td>
                                        @if($subtask->subtask_status == 1)
                                            <label class="form-checkbox-label">
                                                <input task-id="{{$subtask->task->id}}" name="completed"
                                                       class="form-checkbox-field  change_statusss"
                                                       data-id="{{$subtask->id}}" type="checkbox" value="1" checked/>
                                                <i class="form-checkbox-button"></i>
                                            </label>
                                        @else

                                            <label class="form-checkbox-label">
                                                <input task-id="{{$subtask->task->id}}" name="completed"
                                                       class="form-checkbox-field change_statusss"
                                                       data-id="{{$subtask->id}}" type="checkbox" value="0"/>
                                                <i class="form-checkbox-button"></i>
                                            </label>

                                        @endif
                                    </td>
                                    <td>
                                        {!!$subtask->subtask_title!!}
                                    </td>
                                    <td>
                                        @if(!empty($subtask->task->task_title))
                                            {{$subtask->task->task_title }}
                                        @else
                                            "No Task"
                                        @endif
                                    </td>

                                    <td>
                                        {{!empty($subtask->task->category->category_name) ? $subtask->task->category->category_name :' ' }} {{!empty($subtask->task->second_category->category_name) ? '/'.$subtask->task->second_category->category_name :' ' }}
                                    </td>
                                    <td>
                                        @if(!empty($subtask->added_by))

                                            @if(file_exists(public_path().'/assets/images/users/'.$subtask->added_by->image))
                                                <img
                                                    src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}"
                                                    style="width:20px;height:20px;border-radius:50%; border: 1px solid #eee ; " alt="member">
                                            @else
                                                <img src="https://source.unsplash.com/user/c_v_r"
                                                     style="width:20px;height:20px;border-radius:50%;  border: 1px solid #eee ; ">
                                            @endif
                                        @endif
                                    </td>


                                    <td>
                                        {{ date('d.m.Y', strtotime($subtask->created_at->addhours(2)))}}
                                    </td>
                                    <td>
                                        @if(!empty($subtask->subtask_completed_at)) {{ date('d.m.Y', strtotime($subtask->subtask_completed_at))}} @else
                                            -- @endif
                                    </td>

                                    <td>

                                        @if(!empty($subtask->subtask_due_date))
                                            {{ date('d.m.Y', strtotime($subtask->subtask_due_date))}}
                                        @endif

                                    </td>
                                    <td>
                                        <!-- Start Timer  -->
                                        <section id="stopWatch">
                                            <p class="timer{{$subtask->id}}" style="
                                                                       font-weight: 500;
                                                                        font-size: 10px;
                                                                        color: rgb(255, 255, 255);
                                                                        background-color:#cccccc;
                                                                        padding: 4px;
                                                                        border-radius: 20px;
                                                                        width: 100%;
                                                                        margin: 0px auto 10px;
                                                                        font-weight: bold;
                                                    "> {{!empty($subtask->subtask_time) ?  $subtask->subtask_time  : '00:00:00' }} </p>
                                            <i class="start{{$subtask->id}} bi bi-play-circle  start"
                                               data-id="{{$subtask->id}}" data-toggle="play"></i>
                                            <i class="stop{{$subtask->id}} bi bi-stop-circle stop stotime_con"
                                               data-id="{{$subtask->id}}" data-toggle="stop"></i>
                                            <i class="pause{{$subtask->id}} bi bi-pause-circle pause"
                                               data-id="{{$subtask->id}}" data-toggle="pause"></i>
                                            <i class="continue{{$subtask->id}} continue bi bi-play-circle" hidden
                                               data-id="{{$subtask->id}}"></i>
                                            <p class="fulltime{{$subtask->id}} fulltime"></p>
                                        </section>
                                        <!-- End Timer -->
                                    </td>
                                    <td>
                                        <i class="bi bi-card-list btn-task-popup" data-id="{{$subtask->task->id}}"></i>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>


                    <!-- BOx TOdos -->
                    <div class="todosbox" style="display:none;">
                        <div class="cards" id="cards">
                            <div class="overlay"></div>

                            <div class="row sortable-cards" id="shuffle">


                                @foreach($user_subtasks as $subtask)

                                    <div
                                        class="col-md-3 btn-task-popup  sortable-divs mix ui-state-default {{$subtask->task->category->category_name}}"
                                        data-id="{{$subtask->task->id}}">
                                        <div class="card sort"
                                             @if(!empty($subtask->task->category->category_color)) style="background-color:{{$subtask->task->category->category_color}}" @endif >
                                            <div class="card-contents">
                                                <div class="top-bar">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <p>{{!empty($subtask->task->category->category_name) ? $subtask->task->category->category_name :' ' }}</p>
                                                        </div>

                                                        <div class="col-md-5">

                                                            @if(!empty($subtask->responsible))

                                                                @if(file_exists(public_path().'/assets/images/users/'.$subtask->responsible->image))
                                                                    <img
                                                                        src="{{asset('public/assets/images/users/'.$subtask->responsible->image)}}"
                                                                        alt="member"
                                                                        style="height:25px;width:25px;border-radius:50%;">
                                                                @else
                                                                    <img
                                                                        src="https://source.unsplash.com/user/c_v_r">
                                                                @endif
                                                                <p>Verantwortlich</p>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="middle-content">

                                                    <h3>{!!substr($subtask->subtask_title,0,70)!!}</h3>
                                                    <br>

                                                </div>
                                                <div class="button-bar">
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            @if(!empty($subtask->added_by))

                                                                @if(file_exists(public_path().'/assets/images/users/'.$subtask->added_by->image))
                                                                    <img
                                                                        src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}"
                                                                        alt="member"
                                                                        style="height:25px;width:25px;border-radius:50%;">
                                                                @else
                                                                    <img
                                                                        src="https://source.unsplash.com/user/c_v_r">
                                                                @endif

                                                            @endif
                                                            <span>  Erstellt von </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p>DeadLine</p>
                                                            <p> {{ date('d.m.Y', strtotime($subtask->task->task_due_date))}} </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div>

                        </div>
                    </div>
                    <!-- End Box Todos -->
                @endif

            </div>
        </div>
    </div>
    <!--End Users Tasks -->
@endsection
@section('script')
    <script src="{{asset('public/assets/admin/assets2/js/dd.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>

        $(document).ready(function () {


            // Start  To Do  List
            $('#todos').on('click', function () {
                $('.todosbox').css('display', 'block');
                $('#subtasks_history_wrapper').css('display', 'none');
                $('#todos').addClass(' btn-success');
                $('#list_todos').removeClass(' btn-success');
                $('#gender').val("box");
            });
            $('#list_todos').on('click', function () {
                $('#subtasks_history_wrapper').css('display', 'block');
                $('.todosbox').css('display', 'none');
                $('#list_todos').addClass('btn-success');
                $('#todos').removeClass('btn-success');
                $('#gender').val("list");

            });

            //Start  Data Tables
            const table = $('#subtasks_history').DataTable({
                "paging": true
            });
            table.on('draw', function () {
                $('.pause').css({'display': 'none'});
                $('.stop').css({'display': 'none'});
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.subtasks.get_timer') }}',
                    data: {userid: '{{Auth::user()->id}}', _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        var sethours = data.hours;
                        var setminutes = data.minutes;
                        var setseconds = data.seconds;
                        data = data.taskdata;

                        if (data) {
                            if (data['timer'] == 1) {
                                $('.timer' + data['id']).css({'background-color': '#198754', 'color': '#fff'});
                                $('.pause' + data['id']).css('display', 'inline-block');
                                $('.start').css({'display': 'none'});
                                $('.stop' + data['id']).css('display', 'inline-block');
                                $('#toptimer').attr('data-bs-original-title', data['subtask_title']);
                            }
                        } else {
                            $('.user_subtasks .stop').each(function () {
                                $(this).css('display', 'none');
                            });
                            $('.user_subtasks .pause').each(function () {
                                $(this).css('display', 'none');
                            });
                        }
                    }
                });
            });
            //End Data tables


            $(document).on('click', '.change_statusss', function () {
                var id = $(this).data('id');
                var task_id = $(this).attr('task-id');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.subtasks.update_status') }}',
                    data: {id: id, task_id: task_id, _token: '{{ csrf_token() }}'},
                    success: function (data) {

                        let timerInterval
                        Swal.fire({
                            title: 'Task Updated Successfuly',
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {

                            }
                        })
                        $('#task' + task_id).html('');
                        $('#task' + task_id).html(data.options);
                    }
                });
            });

            var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
                enableTime: true,
                dateFormat: "d.m.Y  H:i",
            });


            /*Start Filterion*/
            $('.search-btn').on('click', function () {
                //user requirements
                var userstype = $('#subtasks_users').data('type');
                var subtask_user_id = $('#subtasks_users').val();
                var gender = $("#gender").val();
                var subtask_status = $('input[name=subtask_status]:checked').val();
                var subtask_status2 = $('input[name=subtask_status2]:checked').val();
                //start and end due date requirements
                var datetype = $('.end_due_date').data('type');
                var end_due_date = $('.end_due_date').val()
                var start_due_date = $('.start_due_date').val();


                //  Users
                if (userstype != '' && start_due_date == '' && end_due_date == '' && subtask_status == undefined && subtask_status2 == undefined) {
                    $.ajax({
                        type: "POST",
                        url: '{{route('admin.filter.usertasks')}}',   // need to create this post route
                        data: {
                            type: userstype,
                            gender: gender,
                            subtask_user_id: subtask_user_id,
                            start_due_date: start_due_date,
                            end_due_date: end_due_date,
                            subtask_status: subtask_status,
                            subtask_status2: subtask_status2,
                            _token: '{{ csrf_token() }}'
                        },
                        cache: false,
                        success: function (data) {
                            table.clear().destroy();
                            $('.filtered_data').html(data.options);
                            $('.filtered_table').DataTable({
                                "paging": true
                            });


                        },
                        error: function (jqXHR, status, err) {
                        },
                    });
                }

                //Users And Two Dates

                if (datetype != '' && start_due_date != '' && end_due_date != '' && subtask_status == null && subtask_status2 == null) {

                    $.ajax({
                        type: "POST",
                        url: '{{route('admin.filter.usertasks')}}',   // need to create this post route
                        data: {
                            type: datetype,
                            gender: gender,
                            start_due_date: start_due_date,
                            end_due_date: end_due_date,
                            subtask_user_id: subtask_user_id,
                            subtask_status: subtask_status,
                            subtask_status2: subtask_status2,
                            _token: '{{ csrf_token() }}'
                        },
                        cache: false,
                        success: function (data) {
                            console.log(data.total_time)
                            table.clear().destroy();
                            $('.filtered_data').html(data.options);
                            $('#time_holder').show();
                            $('#total_time').html(data.total_time);
                            $('.filtered_table').DataTable({
                                "paging": true
                            });

                        },
                        error: function (jqXHR, status, err) {


                        },
                    });
                }


                if (datetype != '' && start_due_date != '' && end_due_date != '' && subtask_status != undefined || subtask_status2 != undefined) {

                    $.ajax({
                        type: "POST",
                        url: '{{route('admin.filter.usertasks')}}',   // need to create this post route
                        data: {
                            type: datetype,
                            gender: gender,
                            subtask_status: subtask_status,
                            subtask_status2: subtask_status2,
                            start_due_date: start_due_date,
                            end_due_date: end_due_date,
                            subtask_user_id: subtask_user_id,
                            _token: '{{ csrf_token() }}'
                        },
                        cache: false,
                        success: function (data) {

                            table.clear().destroy();
                            $('.filtered_data').html(data.options);
                            $('.filtered_table').DataTable({
                                "paging": true
                            });

                        },
                        error: function (jqXHR, status, err) {


                        },
                    });
                }
                if (datetype != '' && start_due_date != '' && end_due_date != '' && subtask_status != undefined &&  subtask_status2 == undefined) {
                    $.ajax({
                        type: "POST",
                        url: '{{route('admin.filter.usertasks')}}',   // need to create this post route
                        data: {
                            type: datetype,
                            gender: gender,
                            subtask_status: subtask_status,
                            subtask_status2: subtask_status2,
                            start_due_date: start_due_date,
                            end_due_date: end_due_date,
                            subtask_user_id: subtask_user_id,
                            _token: '{{ csrf_token() }}'
                        },
                        cache: false,
                        success: function (data) {

                            table.clear().destroy();
                            $('.filtered_data').html(data.options);
                            $('.filtered_table').DataTable({
                                "paging": true
                            });

                        },
                        error: function (jqXHR, status, err) {


                        },
                    });
                }



            });


        });

    </script>


@endsection
