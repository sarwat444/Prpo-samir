@extends('layouts.dashboard')
@section('css')
    <link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
    <script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}" ></script>
    <link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
    <link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">
    <style>
        .custom_buttons
        {
            float: left;
            margin-top: -53px;
            margin-left: 21px;
        }
        .custom_buttons .btn-primary
        {
            font-size: 13px;
            background-color: #009eff;
            color: #ffffff;
            border: 0 ;
        }
        .custom_buttons .btn-primary:hover
        {
            background-color: #ffffff;
            color: #009eff;
        }
        .custom_buttons .btn-warning
        {
            font-size: 13px;
            background-color: #ec6731 ;
            color: #ffffff;
            border: 0 ;
        }
        .custom_buttons .btn-warning:hover
        {
            background-color: #ffffff;
            color:  #ec6731 ;
        }
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
                    <div class="col-md-2">
                        <label style="text-align: left;color: #fff;" class="control control--radio">{{__('messages.my_test')}}
                            <input id="done" type="radio" name="createdfilter"    value='1' data-type="createdfilter"  data-gender="list" />
                            <div class="control__indicator"></div>
                            <div class="control__indicator"></div>
                        </label>

                        <label style="text-align: left;color: #fff;" class="control control--radio">{{__('messages.my_created')}}
                            <input id="pending" type="radio" name="createdfilter"    value='2' data-type="createdfilter"    data-gender="list"  />
                            <div class="control__indicator"></div>
                            <div class="control__indicator"></div>
                        </label>
                    </div>

                    <div class="col-md-2 " style="text-align:left ;margin-top: 9px;">
                        <label style="text-align: left;color: #fff;"  for="completed" >
                            <input  type="checkbox" name="completed_checkbox" data-gender="list" value="1"   id="completed_checkbox">
                            {{__('messages.done')}}
                        </label>
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
                        <th> {{__('messages.tester')}} </th>
                        <th> {{__('messages.created_at')}} </th>
                        <th> {{__('messages.done_at')}} </th>
                        <th>{{__('messages.due_date')}} </th>
                        <th>{{__('messages.details')}}</th>
                    </tr>
                </thead>
                <tbody  class="tasks user_subtasks commentslist">
                @foreach($tests  as $subtask)
                    @if(!empty($subtask))
                          
                                <tr>
                                <td>
                                    <span class="task_status">
                                                @if($subtask->subtask_status == 1)
                                                    <label class="form-checkbox-label">
                                                        <input task-id="{{$subtask->task->id}}" name="completed"
                                                               class="form-checkbox-field  change_statusss  task_status{{$subtask->task->id}}"
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
                                    </span>
                                    <span class="task_test" style="    height: 0 !important;margin-top: -19px !important;float: right;">
                                                @if($subtask->tested == 1 )
                                                    <label class="form-checkbox-label testing">
                                                        <input name="completed" class="form-checkbox-field tested" value="0" type="checkbox" data-id="{{$subtask->id}}"   checked   />
                                                        <i class="form-checkbox-button"></i>
                                                    </label>

                                                @endif
                                                @if($subtask->tested == 0 )
                                                        <label class="form-checkbox-label testing" >
                                                            <input name="completed" class="form-checkbox-field tested" value="1" type="checkbox" data-id="{{$subtask->id}}"   />
                                                            <i class="form-checkbox-button"></i>
                                                        </label>
                                                @endif
                                   </span>
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
                                    <div class="responsable">
                                        @if(!empty($subtask->testerfun))
                                            @if(file_exists(public_path().'/assets/images/users/'.$subtask->testerfun->image) && !empty($subtask->testerfun->image))
                                                <img src="{{asset('public/assets/images/users/'.$subtask->testerfun->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member"> <p class="addedby_id">{{$subtask->testerfun->first_name}}</p>
                                            @else
                                                <img src="https://pri-po.com/public/assets/images/default.png" style="height: 25px ; width: 25px; border-radius: 50% ; ">
                                                <p class="addedby_id">{{$subtask->testerfun->first_name}}</p>
                                            @endif
                                        @else
                                            -------
                                        @endif
                                    </div>
                                </td>
                                <td class="col-md-1">
                                    <p class="sub-date">
                                        {{ date('d.m.Y', strtotime($subtask->created_at->addhours(2)))}}  </p>
                                </td>
                                <td class="col-md-1">
                                    <p class="sub-date">

                                        @if(!empty($subtask->subtask_completed_at)) {{ date('d.m.Y', strtotime($subtask->subtask_completed_at))}} @else -- @endif  </p>
                                </td>

                                <td class="col-md-1">
                                    <p class="sub-date">
                                        @if(!empty($subtask->subtask_due_date))
                                            {{ date('d.m.Y', strtotime($subtask->subtask_due_date))}}
                                        @endif
                                    </p>
                                </td>
                                <td>
                                    <p><i class="fa fa-list btn-task-popup" data-id="{{$subtask->task->id}}"></i></p>
                                </td>
                            </tr>
                            @endif
                       
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

            //Change

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

            $('.search-btn').on('click', function () {

                var type = $(this).data('type');
                var end_due_date = $('.end_due_date').val();
                var start_due_date = $('.start_due_date').val();
                var commentuserid = $('#userid').val();
                var tested_or_crested = $('input[name=createdfilter]:checked').val();
                var completed_checkbox = $('input[name=completed_checkbox]:checked').val();
                if (typeof completed_checkbox == 'undefined') {
                    completed_checkbox = 0
                }
                if (start_due_date == '' && end_due_date == '' && tested_or_crested !='' ) {
                    if(tested_or_crested == 1 ) {
                        $.ajax({
                            url: '{{route('admin.subtasks.filtertestbtn')}}',
                            type: "POST",
                            data: {
                                completed_checkbox : completed_checkbox ,
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
                    }else if(tested_or_crested == 2 )
                    {
                        $.ajax({
                            url: '{{route('admin.subtasks.filtercreatedbtn')}}',
                            type: "POST",
                            data: {
                                completed_checkbox : completed_checkbox ,
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

                }
                else if (start_due_date != '' && end_due_date != '' && tested_or_crested == null ) {

                    $.ajax({
                        url: '{{route('admin.filter.filltertest')}}',
                        type: "POST",
                        data: {
                            type: type,
                            completed_checkbox : completed_checkbox ,
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
                }else if(start_due_date != '' && end_due_date != '' && tested_or_crested != null)
                {
                    $.ajax({
                        url: '{{route('admin.filter.filltertest')}}',
                        type: "POST",
                        data: {
                            type: type,
                            completed_checkbox : completed_checkbox ,
                            start_due_date: start_due_date,
                            end_due_date: end_due_date,
                            tested_or_crested : tested_or_crested ,

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


                        },
                        error: function (jqXHR, status, err) {


                        },
                    });


            });
            // Change Tested
            $(document).on('click', '.tested', function () {
                var subtask = $(this).data('id') ;
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