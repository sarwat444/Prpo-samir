@extends('layouts.dashboard')
@section('css')
    <link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
    <script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}" ></script>
    <link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
    <link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">
    <style>
        .resposiple
        {
            height: 30px ;
            width: 30px ;
            border-radius: 50% ;
            margin-left: 10px ;
            border: 1px solid #eee ;
        }
        .sub-tasks
        {
            font-size: 13px;
            text-align: center;
        }
        .timetrakingdescription
        {
            font-size: 13px;
        }
        .timetrakingdescription thead
        {
            color: #009eff;
        }
      /* Start  Filter Designing */
        .subtasks_history_filter
        {
            margin-bottom: 10px  !important;
        }
        #subtasks_history
        {
            background-color: #fff;
            font-size: 11px;
            text-align: center;
        }
    </style>
@endsection
@section('title')Meine Aufgaben @endsection
@section('content')
    <!--Start  Users Tasks -->
    <div class="container">
        <!--Popup-->
        <!-- Modal -->
        <div class="modal fade timetrakingdescription" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> {{__('messages.Time_Traking')}} </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body historybody">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col t-head">#id</th>
                                <th scope="col t-head">{{__('messages.time_start')}}  </th>
                                <th scope="col t-head">{{__('messages.time_end')}} - {{__('messages.date')}}  </th>
                                <th scope="col t-head"> {{__('messages.Dauer')}}  </th>
                            </tr>
                            </thead>
                            <tbody  class="tablecontent">
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!--End Popup-->
        <div class="mytasks">
            <div class="fillter subtasks_history_filter">
                <div class="row justify-content-center">

                    @if(Auth::user()->role == 1 )
                        <div class="col-md-2">
                            <div class="form-control">
                                <select  name="users" id="subtasks_users" is="ms-dropdown" data-type="user_filter" data-gender="list"  required>
                                    <option value="all">{{__('messages.Alle_Mitarbeiter')}} </option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}" data-image="{{asset('public/assets/images/users/'.$user->image)}}">{{$user->user_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-2">
                        <div class="datepicker" data-type="date_filter" data-gender="list">
                            <input  type="text"  class="start_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target" data-name="task_due_date"  name="task_due_date"  placeholder="{{__('messages.von')}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="datepicker">
                            <input  type="text"   data-type="date_filter" data-gender="list"   class="end_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target" data-name="task_due_date"  name="task_due_date"  placeholder="{{__('messages.an')}}">
                        </div>
                    </div>

                </div>
            </div>
            <!--Sub tasks  History  -->
            <table id="subtasks_history" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Status</th>
                    <th>{{__('messages.Aufgabe')}}</th>
                    <th>{{__('messages.Kategorie')}}</th>
                    <th>{{__('messages.Hinzugefügt_von')}} </th>
                    <th> {{__('messages.Hinzugefügt_Zeit')}}  </th>
                    <th>Details</th>
                </tr>
                </thead>
                <tbody  class="tasks  user_subtasks">

                @foreach($taskshistory as $subtask)
                    @if($subtask->history->count() !== 0 )
                        <tr>
                            <td>
                                @if($subtask->subtask_status == 1)
                                    <label class="form-checkbox-label">
                                        <input name="completed" class="form-checkbox-field change_statusss" data-id="{{$subtask->id}}"  type="checkbox" value="1" checked  />
                                        <i class="form-checkbox-button"></i>
                                    </label>


                                @else

                                    <label class="form-checkbox-label">
                                        <input name="completed" class="form-checkbox-field change_statusss" data-id="{{$subtask->id}}"  type="checkbox" value="0"  />
                                        <i class="form-checkbox-button"></i>
                                    </label>


                                @endif
                            </td>
                            <td>
                                {!!$subtask->subtask_title!!}

                            </td>
                            <td>
                                @if(!empty($subtask->task->category->category_name))    {{$subtask->task->category->category_name }}     @else "No Category"  @endif
                            </td>
                            <td>
                                @if(!empty($subtask->added_by))

                                    @if(file_exists(public_path().'/assets/images/users/'.$subtask->added_by->image))
                                        <img src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member">
                                    @else
                                        <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                                    @endif
                                @endif
                            </td>
                            <td >
                                <!---Time History -->

                            <?php
                            $timeonsecondes = 0 ;
                            ?>

                            @foreach($subtask->history as $history)
                                <?php $timeonsecondes += $history->Time ;  ?>
                            @endforeach
                            <?php
                            $hours = floor($timeonsecondes / 3600);
                            $mins = floor($timeonsecondes / 60 % 60);
                            $secs = floor($timeonsecondes % 60);
                            $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

                            if($hours=='00'  && $mins =='00'  && $secs== '00')
                            {
                                echo "<p class='totaltimedanger'>". 'kein Zeitrekord' ."</p>" ;
                            }
                            else
                            {
                                echo "<p class='totaltime'> <i class='bi bi-stopwatch'></i>
                                                            ".  $timeFormat ."</p>" ;
                            }
                            ?>

                            <!---End Time History -->
                            </td>
                            <td> <i class="bi bi-card-list  historydescription" data-id="{{$subtask->id}}"  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"></i></td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <!--End Sub tasks  History  -->
        </div>
    </div>
    <!--End Users Tasks -->
@endsection
@section('script')
    <script src="{{asset('public/assets/admin/assets2/js/dd.min.js')}}"></script>

    <script>

        $(document).ready(function(){
            var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
                enableTime:false ,
                dateFormat: "d.m.Y",
            });

            /* Start  History */
            $('.historydescription').each(function(){
                $(this).on('click' , function(){
                    $('.modal-dialog .historybody .tablecontent').html('');
                    var subtask =  $(this).data('id') ;
                    $.ajax({
                        type: "POST",
                        url:   '{{route('admin.subtasks.historydescription')}}',   // need to create this post route
                        data: {task_id:subtask , _token: '{{ csrf_token() }}'},
                        cache: false,
                        success: function (data) {
                            //  $('.modal-dialog .historybody').html('');
                            $('.modal-dialog .historybody .tablecontent').html(data);
                        },
                        error: function (jqXHR, status, err) {

                        },
                    });

                })
            });
            /* End History */
        });


        $(document).ready(function(){

            $("#all").on('click',function (event) {
                //alert('hello');


                var type = $(this).data('type');
                var gender = $("#gender").val();
                var start_due_date = $('.start_due_date').val();
                var end_due_date = $('.end_due_date').val();
                var subtask_user_id = $('#subtasks_users').val();
                var subtask_status  =  $('input[name=subtask_status]:checked', '.status').val();
                // alert(type);
                $.ajax({

                    type: "POST",
                    url:   '{{route('admin.filter.usertasks')}}',   // need to create this post route
                    data: {type:type , gender : gender ,start_due_date : start_due_date , end_due_date:end_due_date , subtask_user_id : subtask_user_id , subtask_status : subtask_status  , _token: '{{ csrf_token() }}'},
                    cache: false,
                    success: function (data) {
                        $('.user_subtasks').html('');
                        $('.user_subtasks').html(data.options);

                    },
                    error: function (jqXHR, status, err) {


                    },
                });

            });





            $(".end_due_date").on('change',function (event) {

                var type = $(this).data('type');
                var end_due_date = $(this).val()
                var start_due_date = $('.start_due_date').val()
                var subtask_user_id = $('#subtasks_users').val();


                if( start_due_date &&  end_due_date ) {
                    $.ajax({

                        type: "POST",
                        url:   '{{route('admin.filter.userhistorytasks')}}',   // need to create this post route
                        data: {type:type ,start_due_date:start_due_date , end_due_date: end_due_date , subtask_user_id : subtask_user_id , _token: '{{ csrf_token() }}'},
                        cache: false,
                        success: function (data) {

                            $('.user_subtasks').html('');
                            $('.user_subtasks').html(data.options);

                        },
                        error: function (jqXHR, status, err) {


                        },
                    });
                }
            });

            $(".start_due_date").on('change',function (event) {

                var type = $(this).data('type');
                var start_due_date  = $(this).val()
                var end_due_date = $('.end_due_date').val()
                var subtask_user_id = $('#subtasks_users').val();


                if(start_due_date && end_due_date) {
                    $.ajax({

                        type: "POST",
                        url:   '{{route('admin.filter.userhistorytasks')}}',   // need to create this post route
                        data: {type:type , start_due_date:start_due_date , end_due_date: end_due_date , subtask_user_id : subtask_user_id , _token: '{{ csrf_token() }}'},
                        cache: false,
                        success: function (data) {

                            $('.user_subtasks').html('');
                            $('.user_subtasks').html(data.options);

                        },
                        error: function (jqXHR, status, err) {


                        },
                    });
                }
            });

            $('#subtasks_users').each(function(){
                $(this).on('change' , function(){

                    var type = $(this).data('type');
                    var subtask_user_id = $(this).val();
                    var start_due_date = $('.start_due_date').val();
                    var end_due_date = $('.end_due_date').val();
                    //   alert(subtask_user_id);
                    $.ajax({

                        type: "POST",
                        url:   '{{route('admin.filter.userhistorytasks')}}',   // need to create this post route
                        data: {type : type  , subtask_user_id:subtask_user_id, _token: '{{ csrf_token() }}'},
                        cache: false,
                        success: function (data) {

                            $('.user_subtasks').html('');
                            $('.user_subtasks').html(data.options);

                        },
                        error: function (jqXHR, status, err) {


                        },
                    });

                });
            })








            $('.todos').on('click' , function(){

                $('.todoslist').css('display','none');
                $('.todosbox').css('display','block');
                $('#gender').val("box");
            });

            $('.list_todos').on('click' , function(){

                $('.todoslist').css('display','block');
                $('.todosbox').css('display','none');
                $('#gender').val("list");


            });


        });

    </script>
@endsection
