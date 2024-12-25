@extends('layouts.dashboard')
@section('css')
    <link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
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
        .user_subtasks
        {
            text-align: left;
        }
       .ms-dd .ms-dd-header .option-selected
        {
            font-weight: 500  !important;
            color: #777777 !important;
            font-size: 13px !important;
           background-color: #ffffff;
        }
        .totaltime
        {
            font-size: 14px;
            width: 120px;
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
        .datepicker {
            padding: 7px !important;
            height: 44px !important;
            border-radius: 0 !important;
        }
        .search-btn
        {
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
        .search-btn:hover
        {
            background-color: #ffffff;
            color:#009eff ;
        }
        .search-btn:hover .bi-search::before
        {
            transform: rotate(90deg);
        }
        .ms-options
        {
            display: block;
            max-height: 222px;
        }
    </style>
@endsection
@section('title')Meine Aufgaben @endsection
@section('content')
    <!--Start  Users Tasks -->
    <div class="modal fade timetrakingdescription" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{__('messages.task_timing')}}   </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body historybody">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col t-head">#ID</th>
                            <th scope="col t-head">{{__('messages.start_time')}}</th>
                            <th scope="col t-head"> {{__('messages.end_time')}} </th>
                            <th scope="col t-head">   {{__('messages.duration')}}</th>
                            <th scope="col t-head">  {{__('messages.date')}}</th>
                        </tr>
                        </thead>
                        <tbody  class="tablecontent">
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
         <div class="row justify-content-center">
             <div class="col-md-11">
                  <div class="mytasks">
                <div class="fillter subtasks_history_filter">
                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <div class="datepicker" data-type="date_filter" data-gender="list">
                                <input  type="text"  class="start_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target" data-name="task_due_date"  name="task_due_date"  placeholder="Von">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="datepicker">
                                <input  type="text"   data-type="date_filter" data-gender="list"   class="end_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target" data-name="task_due_date"  name="task_due_date"  placeholder="An">
                            </div>
                        </div>

                        @if(Auth::user()->role == 1 )
                            <div class="col-md-2">
                                <div class="form-control">
                                    <select  name="users" id="subtasks_users" is="ms-dropdown" data-type="user_filter" data-gender="list" data-enable-auto-filter="true"  required>
                                        <option value="all" >All Employess</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}" data-image="{{asset('public/assets/images/users/'.$user->image)}}">{{$user->user_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                            <div class="col-md-1">
                                <div class="search_filter">
                                    <button class="search-btn"><i class="fa fa-search"></i></button>
                                </div>
                            </div>

                    </div>
                </div>
                <!--Sub tasks  History  -->

                <div class="filtered_data">
                     <table id="subtasks_history" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>{{__('messages.subtask')}}</th>
                            <th>{{__('messages.category')}}</th>
                            <th>{{__('messages.created_by')}} </th>
                            <th> {{__('messages.time')}} </th>
                            <th>{{__('messages.details')}}</th>
                        </tr>
                    </thead>
                    <tbody  class="tasks  user_subtasks" id="bodycontent">

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
                                <td> <i class="fa fa-list  historydescription" data-id="{{$subtask->id}}"  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"></i></td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                </div>
                <!--End Sub tasks  History  -->
            </div>
             </div>
         </div>
    </div>
    <!--End Users Tasks -->
@endsection
@section('script')
        <script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}" ></script>
       <script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
       <script src="{{asset('public/assets/admin/assets2/js/dd.min.js')}}"></script>

    <script>

        $(document).ready(function(){
            // start  Flat  Picker
            var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
                enableTime: false,
                dateFormat: "d.m.Y",
            });
            //End Flat  Picker

           //Start  Data Tables
            const table =  $('#subtasks_history').DataTable({
                "paging": true
            });
            //End Data tables
            $('.search-btn').on('click' , function (){
                //user requirements

                var userstype = $('#subtasks_users').data('type') ;
                var subtask_user_id = $('#subtasks_users').val();

                //start and end due date requirements
                var datetype = $('.end_due_date').data('type');
                var end_due_date = $('.end_due_date').val()
                var start_due_date = $('.start_due_date').val() ;

                // Filter Users Tasks

                if(userstype !='' && start_due_date == '' && end_due_date == '') {
                    console.log('users filter ') ;
                    $.ajax({
                        type: "POST",
                        url: '{{route('admin.filter.userhistorytasks')}}',   // need to create this post route
                        data: {type: userstype, subtask_user_id: subtask_user_id, _token: '{{ csrf_token() }}'},
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

                else if(start_due_date !=''  && end_due_date != '' && subtask_user_id =='' )
                {
                    console.log('Date filter only ') ;
                    $.ajax({

                        type: "POST",
                        url:   '{{route('admin.filter.userhistorytasks')}}',
                        data: {type:datetype ,start_due_date:start_due_date , end_due_date: end_due_date , _token: '{{ csrf_token() }}'},
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

                else if( start_due_date !=''  && end_due_date != '' && subtask_user_id !='' && start_due_date != end_due_date )
                {

                    $.ajax({
                        type: "POST",
                        url:   '{{route('admin.filter.userhistorytasks')}}',   // need to create this post route
                        data: {type:datetype , start_due_date:start_due_date , end_due_date: end_due_date , subtask_user_id : subtask_user_id , _token: '{{ csrf_token() }}'},
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

                //All  data  of  one  day
                else if(subtask_user_id !=''  && start_due_date != '' && end_due_date != '' && start_due_date == end_due_date )
                {
                    $.ajax({
                        type: "POST",
                        url:   '{{route('admin.filter.userhistorytasks')}}',   // need to create this post route
                        data: {type:datetype , start_due_date:start_due_date , end_due_date: end_due_date , subtask_user_id : subtask_user_id , _token: '{{ csrf_token() }}'},
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


            /* Start  History */
            $('.historydescription').each(function(){
                $(this).on('click' , function(){
                    var end_due_date = $('.end_due_date').val()
                    var start_due_date = $('.start_due_date').val() ;

                    $('.modal-dialog .historybody .tablecontent').html('');
                    var subtask =  $(this).data('id') ;
                    $.ajax({
                        type: "POST",
                        url:   '{{route('admin.subtasks.historydescription')}}',   // need to create this post route
                        data: {task_id:subtask , start_due_date:start_due_date , end_due_date: end_due_date ,  _token: '{{ csrf_token() }}'},
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
