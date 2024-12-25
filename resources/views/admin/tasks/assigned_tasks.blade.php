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
        /* Fillter Design */
        .assigned_tasks_fillter
        {
            padding: 22px;
            background-color: #141834;
            margin-top: 34px;
            padding: 0;
            margin: 0 auto;
            margin-top: 5px;
            border-radius: 4px;
            text-align: center;
            padding-top: 20px;
            padding-bottom: 25px;
            text-align: center;
        }
        .assigned_tasks_fillter .form-control {
            font-size: 12px;
            padding: 9px ;
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
            margin-left: -29px;
            transition: all .5 ease-in-out;
        }
        .search-btn:hover {
            background-color: #ffffff;
            color: #009eff;
        }
    </style>
@endsection
@section('title')  Vergebene Aufgaben   @endsection
@section('content')
    <div class="container">
        <div class="assigned_tasks_fillter">
            <div class="form_inputs">
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <select class="form-control status" name="subtusk_status">
                          <option>.....</option>
                            <option value="both">Both</option>
                            <option value="0">Completed</option>
                            <option value="1">UnCompoleted</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control test"  name="subtusk_test">
                            <option>.....</option>
                            <option value="both">Both</option>
                            <option value="0">Tested</option>
                            <option value="1">Un Tested</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <div class="search_filter">
                            <button class="search-btn">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table id="assignedtasks" class="table table-striped table-bordered" cellspacing="0" width="100%" >
            <thead>
                <tr>
                    <th>Status</th>
                    <th>{{__('messages.subtasks')}}</th>
                    <th>Post-iT</th>
                    <th>{{__('messages.category')}}</th>
                    <th>{{__('messages.responsible')}} </th>
                    <th> {{__('messages.created_at')}} </th>
                    <th> {{__('messages.done_at')}} </th>
                    <th>{{__('messages.due_date')}} </th>
                    <th>{{__('messages.tester')}} </th>
                    <th>{{__('messages.details')}}</th>
                </tr>
            </thead>
            <tbody  class="tasks user_subtasks commentslist">
            @foreach($assigned_tasks  as $subtask)
                @if($subtask->status == 0 )
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

                              @if(auth::user()->id == $subtask->subtask_added_by  ||  auth::user()->id == $subtask->tester )
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


                                  @else
                                    <label class="form-checkbox-label testing">
                                        <input name="completed" class="form-checkbox-field" value="0" type="checkbox" data-id="{{$subtask->id}}" disabled />
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
                            @if(!empty($subtask->responsible))

                                @if(file_exists(public_path().'/assets/images/users/'.$subtask->task->responsible->image))
                                    <img src="{{asset('public/assets/images/users/'.$subtask->responsible->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member"> <p class="addedby_id">{{$subtask->responsible->first_name}}</p>
                                @else
                                    <img src="https://source.unsplash.com/user/c_v_r">
                                @endif

                            @endif
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
                        <td class="col-md-1">
                            <select  name="tester" class="form-control tester" data-id="{{$subtask->id}}">
                                @php
                                    $users = \App\Models\User::get() ;
                                @endphp
                                @if(!empty($users))
                                    @foreach ($users as  $user)
                                        @if(!empty($subtask->tester))

                                               <option  value="{{$user->id}}"  @if($user->id == $subtask->tester)  selected    @endif  >{{$user->user_name}}

                                            @else

                                                   <option  value="{{$user->id}}"   @if($user->id == $subtask->subtask_added_by) selected   @endif >{{$user->user_name}}

                                         @endif


                                        </option>
                                    @endforeach
                                @endif

                            </select>
                        </td>


                        <td>
                            <p><i class="bi bi-card-list btn-task-popup" data-id="{{$subtask->task->id}}"></i></p>
                        </td>
                    </tr>
                @endif

            @endforeach

            </tbody>
        </table>
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


            //Add Tester

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
                            // need to create this post route
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
            //Change Completed
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


                /* Start Fillter */
                $('.search-btn').on('click' , function () {

                    var status = $('.status').val() ;
                    var test = $('.test').val() ;

                    alert(status) ;
                    alert(test) ;



                });

            });




    </script>
@endsection
