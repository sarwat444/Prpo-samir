@extends('layouts.dashboard')
@section('css')
    <link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
    <script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}" ></script>
    <link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
    <link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">
    <style>
        .commentslist .responsable
        {
            width: 130px;
        }
        .commentslist img
        {
            float: left;
        }
        .responsable p{
            float: right;
        }
        .search-btn {
            background-color: #009eff;
            color: #fff;
            border: 0;
            padding: 9px;
            height: 40px;
            border-radius: 4px;
            margin-top: 6px;
            transition: all .5 ease-in-out;
        }

        .search-btn:hover {
            background-color: #ffffff;
            color: #009eff;
        }

        .search-btn:hover .bi-search::before {
            transform: rotate(90deg);
        }

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
            text-align: center;
        }
        .commentslist p{
            font-size: 13px ;
        }
        .testing
        {
            margin-left: 34px;
            mrgin-top: -7px;
            margin-top: -8px;
        }
        .testing .form-checkbox-field:checked ~ .form-checkbox-button
        {
            color: #ec6731 !important;
        }
        .testing .form-checkbox-button::before, .testing .form-checkbox-button::after
        {
            background-color: #ec6731 !important;
        }
        .testing .form-checkbox-label:hover i,
        .testing  .form-radio-label:hover i
        {
            color: #ec6731 !important;
        }
        .tester
        {
            font-size: 12px;
            text-align: center;
            background-color: #eeeeee;
            color: #00000;
        }
        .tester:hover
        {
            cursor: pointer;
        }
        .testing .form-checkbox-label
        {
            color: #ec6731 !important;
        }
        .show_completed_comments
        {
            float: right;
            margin: 4px;
            font-size: 12px;
            color: #fff;
            font-weight: 500;
            background-color: #ec6731;
            text-align: center;
            border-radius: 4px;
            box-shadow: 3px 3px 0px -1px #21252938;
            padding: 3px;
            margin: 0;
            margin-right: 9px;
            margin-top: 14px;
            padding: 6px;
            background-color: #009eff;
            color: #fff;
            border: 0;
            padding: 9px;
            border-radius: 5px;
            margin-top: 10px;
            margin-left: -29px;
            transition: all 0.5 ease-in-out;
            background-color: #2778c4;
        }
        .show_completed_comments .form-checkbox-button
        {
            visibility: hidden;
        }
        .show_completed_comments:hover{
            background-color: #FFFFFF;
            color:#009eff ;
        }
    </style>
@endsection
@section('title')  Vergebene Aufgaben   @endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-11">
                 <div class="mytasks">
            <div class="fillter comments_filter">
                <div class="row justify-content-center" style="padding-left: 10px;">
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

                    <div class="col-md-1">
                        <div class="search_filter">
                            <button class="search-btn"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <input type="hidden" name="usercomment" value="{{Auth::user()->id}}"  id="userid"/>
                </div>
            </div>

                <!--Start  Data table-->
                <div class="filtered_data">
                     <table id="assignedtasks" class="table table-bordered" cellspacing="0" width="100%" >
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>{{__('messages.subtasks')}}</th>
                        <th>{{__('messages.Post-it')}}</th>
                        <th>{{__('messages.Category')}}</th>
                        <th>{{__('messages.responsible')}} </th>
                        <th> {{__('messages.Added_By')}} </th>
                        <th> {{__('messages.created_at')}} </th>
                        <th> {{__('messages.done_at')}} </th>
                        <th>{{__('messages.due_date')}} </th>
                        <th>{{__('messages.details')}}</th>
                    </tr>
                </thead>
                <tbody  class="tasks user_subtasks commentslist">
                @foreach($tests  as $subtask)

                        <tr>
                            <td>

                                            @if($subtask->tested == 1 )
                                                <label class="form-checkbox-label testing">
                                                    <input name="completed" class="form-checkbox-field tested" value="0" type="checkbox" data-id="{{$subtask->id}}"   checked   />
                                                    <i class="form-checkbox-button"></i>
                                                </label>

                                            @endif
                                            @if($subtask->tested == 0 )
                                                    <label class="form-checkbox-label testing">
                                                        <input name="completed" class="form-checkbox-field tested" value="1" type="checkbox" data-id="{{$subtask->id}}"   />
                                                        <i class="form-checkbox-button"></i>
                                                    </label>
                                            @endif

                            </td>

                            <td class="col-md-2">
                                <p> {!!$subtask->subtask_title!!} </p>
                            </td>
                            <td class="col-md-3">
                                <p data-id="{{$subtask->id}}">  @if(!empty($subtask->task->task_title))    {{$subtask->task->task_title }}     @else "No Task"  @endif </p>
                            </td>

                            <td class="col-md-1">
                                <p>@if(!empty($subtask->task->category->category_name))    {{$subtask->task->category->category_name }}     @else "No Category"  @endif</p>
                            </td>

                            <td class="col-md-1">
                                <div class="responsable">
                                    @if(!empty($subtask->responsible))
                                        @if(file_exists(public_path().'/assets/images/users/'.$subtask->responsible->image) && !empty($subtask->responsible->image))
                                            <img src="{{asset('public/assets/images/users/'.$subtask->responsible->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member"> <p class="addedby_id">{{$subtask->responsible->first_name}}</p>
                                        @else
                                            <img src="https://pri-po.com/public/assets/images/default.png" style="height: 25px ; width: 25px; border-radius: 50% ; ">
                                            <p class="addedby_id">{{$subtask->responsible->first_name}}</p>
                                        @endif
                                    @else
                                        -------
                                    @endif
                                </div>
                            </td>

                            <td class="col-md-1">
                                <div class="responsable">
                                    @if(!empty($subtask->added_by))
                                        @if(file_exists(public_path().'/assets/images/users/'.$subtask->added_by->image) && !empty($subtask->added_by->image))
                                            <img src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member"> <p class="addedby_id">{{$subtask->added_by->first_name}}</p>
                                        @else
                                            <img src="https://pri-po.com/public/assets/images/default.png" style="height: 25px ; width: 25px; border-radius: 50% ; ">
                                            <p class="addedby_id">{{$subtask->added_by->first_name}}</p>
                                        @endif
                                    @else
                                        -------
                                    @endif
                                </div>
                            </td>





                            <td class="col-md-1">
                                <p style="visibility: hidden ; height: 0 "> {{$subtask->created_at}}</p>
                                <p class="sub-date">
                                    {{ date('d.m.Y', strtotime($subtask->created_at->addhours(2)))}}  </p>
                            </td>
                            <td class="col-md-1">
                                <p class="sub-date">
                                <p style="visibility: hidden ; height: 0 "> {{$subtask->created_at}}</p>
                                    @if(!empty($subtask->subtask_completed_at)) {{ date('d.m.Y', strtotime($subtask->subtask_completed_at))}} @else -- @endif  </p>
                            </td>

                            <td class="col-md-1">
                                <p class="sub-date">
                                <p style="visibility: hidden ; height: 0 "> {{$subtask->created_at}}</p>
                                    @if(!empty($subtask->subtask_due_date))
                                        {{ date('d.m.Y', strtotime($subtask->subtask_due_date))}}
                                    @endif
                                </p>
                            </td>
                            <td>
                                <p><i class="fa fa-list btn-task-popup" data-id="{{$subtask->task->id}}"></i></p>
                            </td>
                        </tr>
                @endforeach

                </tbody>
            </table>
                 </div>
        </div>
            </div>
    </div>
    </div>
        <!--End Assigned Tasks -->
@endsection
@section('script')
    <script src="{{asset('public/assets/admin/assets2/js/dd.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            // DataTable initialisation
            var  assignedtasks  = $('#assignedtasks').DataTable(
                {
                    "dom": '<"dt-buttons"Bfli>rtp',
                    "paging": true,
                    "autoWidth": true,
                    "fixedHeader": true,
                }
            );
        });



        $(document).ready(function(){
            var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
                enableTime: true,
                dateFormat: "d.m.Y  H:i",
            });

        });


        $(document).ready(function() {
            $('.search-btn').on('click', function () {

                var type = $(this).data('type');
                var end_due_date = $('.end_due_date').val();
                var start_due_date = $('.start_due_date').val();
                var commentuserid = $('#userid').val();

                if (start_due_date && end_due_date) {
                    $.ajax({
                        url: '{{route('admin.filter.filltertest')}}',
                        type: "POST",
                        data: {
                            type: type,
                            start_due_date: start_due_date,
                            end_due_date: end_due_date,
                            commentuserid: commentuserid,
                            _token: '{{ csrf_token() }}'
                        },
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

            $(".deletecomment").each(function(){
                $(this).on('change', function (event) {
                    $.ajax({
                        url :'{{route('admin.comments.deletecomment')}}' ,
                        type: "POST",
                        // need to create this post route
                        data: {
                            comment_id: $(this).data('id'),
                            value:  $(this).val() ,
                            _token: '{{ csrf_token() }}'
                        },
                        cache: false,
                        success: function (data) {
                            /*
                             $('.user_subtasks').html('');
                             $('.user_subtasks').html(data.options);
                             */

                        },
                        error: function (jqXHR, status, err) {

                        },
                    });

                });
            });


            //Add Tester


            //Delete Comment
                $(document).on('click', '.tester', function () {
                    $.ajax({
                        url :'{{route('admin.subtasks.test')}}' ,
                        type: "POST",
                        data: {
                            subtask_id : $(this).data('id'),
                            user_id :  $(this).val() ,
                            _token: '{{ csrf_token() }}'
                        },
                        cache: false,
                        success: function (data) {
                            /*
                             $('.user_subtasks').html('');
                             $('.user_subtasks').html(data.options);
                             */

                        },
                        error: function (jqXHR, status, err) {


                        },
                    });


            });
            // Change Tested
            $(document).on('click', '.tested', function () {
                        $.ajax({
                            url :'{{route('admin.subtasks.tested')}}' ,
                            type: "POST",

                            data: {
                                subtask_id: $(this).data('id'),
                                value:  $(this).val() ,
                                _token: '{{ csrf_token() }}'
                            },
                            cache: false,
                            success: function (data) {
                            },
                            error: function (jqXHR, status, err) {
                            },
                        });

                    });
            });

    </script>
@endsection
