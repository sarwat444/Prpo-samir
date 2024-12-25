@extends('layouts.dashboard')
@section('css')
    <link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
    <script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}"></script>
    <link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
    <link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">
    <style>
        .sortdate {

            visibility: hidden !important;

        }

        .resposiple {
            height: 30px;
            width: 30px;
            border-radius: 50%;
            margin-left: 10px;
            border: 1px solid #eee;
        }

        .sub-tasks {
            text-align: center;
        }

        .assigned_tasks_fillter select {
            appearance: auto;
        }

        .commentslist p {
            font-size: 13px;
        }

        .testing .form-checkbox-field:checked ~ .form-checkbox-button {
            color: #ec6731 !important;
        }

        .testing .form-checkbox-button::before, .testing .form-checkbox-button::after {
            background-color: #ec6731 !important;
        }

        .testing .form-checkbox-label:hover i,
        .testing .form-radio-label:hover i {
            color: #ec6731 !important;
        }

        .tester {
            font-size: 12px;
            text-align: center;
            color: #00000;
            appearance: auto;
        }

        .commentslist .responsable {
            width: 130px;
        }

        .commentslist img {
            float: left;
        }

        .responsable p {
            float: right;
        }

        .tester:hover {
            cursor: pointer;
        }

        .testing .form-checkbox-label {
            color: #ec6731 !important;
        }

        /* Fillter Design */
        .assigned_tasks_fillter {
            padding: 22px;
            background-color: #2778c461;
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
            padding: 9px;
        }

        .search-btn {
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

        .status_check {
            width: 100px;
        }

        .select2-container {
            width: 145px !important;
        }
    </style>
@endsection
@section('title')
    Vergebene Aufgaben
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="assigned_tasks_fillter">
                    <div class="form_inputs">
                        <div class="row justify-content-center" style="padding-left: 20px">
                            <div class="col-md-2">
                                <select class="form-control status" name="status">
                                    <option value="2">{{__('messages.uncompleted')}}</option>
                                    <option value="1">{{__('messages.completed')}}</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control tested" name="test">
                                    <option value="2">{{__('messages.untested')}}</option>
                                    <option value="1">{{__('messages.tested')}}</option>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <div class="search_filter">
                                    <button class="search-btn">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filtered_data">
                    <div class="table-responsive">
                        <table id="assignedtasks" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Status</th>
                                <th>{{__('messages.subtasks')}}</th>
                                <th>{{__('messages.post')}}</th>
                                <th>{{__('messages.category')}}</th>
                                <th>{{__('messages.responsible')}} </th>
                                <th> {{__('messages.Added_By')}} </th>
                                <th> {{__('messages.created_at')}} </th>
                                <th> {{__('messages.done_at')}} </th>
                                <th>{{__('messages.due_date')}} </th>
                                <th>{{__('messages.tester')}} </th>
                                <th>{{__('messages.details')}}</th>
                            </tr>
                            </thead>
                            <tbody class="tasks user_subtasks commentslist">
                            @foreach($assigned_tasks  as $subtask)
                                @if(!empty($subtask->task))
                                    @if($subtask->subtask_status == 1 &&   $subtask->tested == 1)
                                    @else
                                        <tr>
                                            <td>
                                                <div class="status_check">

                                                    @if($subtask->subtask_status == 1)
                                                        <label class="form-checkbox-label">
                                                            <input task-id="{{$subtask->task->id}}" name="completed"
                                                                   class="form-checkbox-field  change_statusss subtask_status{{$subtask->id}}"
                                                                   data-id="{{$subtask->id}}" type="checkbox" value="1"
                                                                   checked/>
                                                            <i class="form-checkbox-button"></i>
                                                        </label>
                                                    @else
                                                        <label class="form-checkbox-label">
                                                            <input task-id="{{$subtask->task->id}}" name="completed"
                                                                   class="form-checkbox-field change_statusss subtask_status{{$subtask->id}}"
                                                                   data-id="{{$subtask->id}}" type="checkbox"
                                                                   value="0"/>
                                                            <i class="form-checkbox-button"></i>
                                                        </label>
                                                    @endif
                                                    @if(auth::user()->id == $subtask->subtask_added_by  ||  auth::user()->id == $subtask->tester )
                                                        @if($subtask->tested == 1 )
                                                            <label class="form-checkbox-label testing">
                                                                <input name="completed"
                                                                       class="form-checkbox-field tested" value="0"
                                                                       type="checkbox" data-id="{{$subtask->id}}"
                                                                       checked/>
                                                                <i class="form-checkbox-button"></i>
                                                            </label>

                                                        @endif

                                                        @if($subtask->tested == 0 )
                                                            <label class="form-checkbox-label testing">
                                                                <input name="completed"
                                                                       class="form-checkbox-field tested subtask_tested{{$subtask->id}}"
                                                                       value="1" type="checkbox"
                                                                       data-id="{{$subtask->id}}"/>
                                                                <i class="form-checkbox-button"></i>
                                                            </label>
                                                        @endif

                                                    @else
                                                        <label class="form-checkbox-label testing">
                                                            <input name="completed"
                                                                   class="form-checkbox-field subtask_tested{{$subtask->id}}"
                                                                   value="0" type="checkbox" data-id="{{$subtask->id}}"
                                                                   disabled/>
                                                            <i class="form-checkbox-button"></i>
                                                        </label>
                                                    @endif


                                                </div>
                                            </td>

                                            <td class="col-md-2">
                                                <p> {!!$subtask->subtask_title!!} </p>
                                            </td>
                                            <td class="col-md-3">
                                                <p data-id="{{$subtask->id}}">  @if(!empty($subtask->task->task_title))
                                                        {{$subtask->task->task_title }}
                                                    @else
                                                        "No Task"
                                                    @endif </p>
                                            </td>

                                            <td class="col-md-1">
                                                <p>@if(!empty($subtask->task->category->category_name))
                                                        {{$subtask->task->category->category_name }}
                                                    @else
                                                        "No Category"
                                                    @endif</p>
                                            </td>

                                            <td class="col-md-1">
                                                <div class="responsable">
                                                    @if(!empty($subtask->responsible))
                                                        @if(file_exists(public_path().'/assets/images/users/'.$subtask->responsible->image) && !empty($subtask->responsible->image))
                                                            <img
                                                                src="{{asset('public/assets/images/users/'.$subtask->responsible->image)}}"
                                                                style="height:25px;width:25px;border-radius:50%;"
                                                                alt="member"> <p
                                                                class="addedby_id">{{$subtask->responsible->first_name}}</p>
                                                        @else
                                                            <img
                                                                src="https://pri-po.com/public/assets/images/default.png"
                                                                style="height: 25px ; width: 25px; border-radius: 50% ; ">
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
                                                            <img
                                                                src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}"
                                                                style="height:25px;width:25px;border-radius:50%;"
                                                                alt="member"> <p
                                                                class="addedby_id">{{$subtask->added_by->first_name}}</p>
                                                        @else
                                                            <img
                                                                src="https://pri-po.com/public/assets/images/default.png"
                                                                style="height: 25px ; width: 25px; border-radius: 50% ; ">
                                                            <p class="addedby_id">{{$subtask->added_by->first_name}}</p>
                                                        @endif
                                                    @else
                                                        -------
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="col-md-1">
                                                <p class="sub-date">
                                                <p class="sortdate" style="height: 0">{{$subtask->created_at}}</p>
                                                {{ date('d.m.Y', strtotime($subtask->created_at->addhours(2)))}}

                                                </p>
                                            </td>
                                            <td class="col-md-1">
                                                <p class="sub-date">
                                                <p class="sortdate" style="height: 0">{{$subtask->created_at}}</p>
                                                @if(!empty($subtask->subtask_completed_at)) {{ date('d.m.Y', strtotime($subtask->subtask_completed_at))}} @else
                                                    -- @endif  </p>
                                            </td>

                                            <td class="col-md-1">
                                                <p class="sub-date">
                                                @if(!empty($subtask->subtask_due_date))
                                                    <p class="sortdate" style="height: 0">{{$subtask->created_at}}</p>
                                                    {{ date('d.m.Y', strtotime($subtask->subtask_due_date))}}
                                                    @endif
                                                    </p>
                                            </td>
                                            <td class="col-md-1">
                                                <select name="tester" class="form-control tester selecttester"
                                                        data-id="{{$subtask->id}}">
                                                    @php
                                                        $users = \App\Models\User::where(['account_id'=> Auth::user()->account_id, 'deleted' => 0 ])->where('status' , 0)->get();
                                                    @endphp
                                                    @if(!empty($users))
                                                        @foreach ($users as  $user)
                                                            @if(!empty($subtask->tester))
                                                                <option value="{{$user->id}}"
                                                                        @if($user->id == $subtask->tester)  selected @endif >{{$user->user_name}}
                                                            @else
                                                                <option value="{{$user->id}}"
                                                                        @if($user->id == $subtask->subtask_added_by) selected @endif >{{$user->user_name}}
                                                                    @endif


                                                                </option>
                                                                @endforeach
                                                            @endif

                                                </select>
                                            </td>


                                            <td>
                                                <p><i class="fa fa-list  btn-task-popup"
                                                      data-id="{{$subtask->task->id}}"></i></p>
                                            </td>
                                        </tr>
                                    @endif
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


        $(document).ready(function () {
            /*$('.selecttester').select2() ;*/
            // DataTable initialisation
            var table = $('#assignedtasks').DataTable(
                {
                    "dom": '<"dt-buttons"Bfli>rtp',
                    "paging": true,
                    "autoWidth": true,
                    "fixedHeader": true,
                }
            );


            var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
                enableTime: true,
                dateFormat: "d.m.Y  H:i",
            });

            /* Start Fillter */
            $(document).on('click', '.search-btn', function () {
                var status = $('.status').val();
                var test = $('.tested').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.subtasks.filter_assigned') }}',
                    data: {status: status, test: test, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        table.clear().destroy();
                        $('.filtered_data').html(data.options);
                        $('.filtered_table').DataTable({
                            "paging": true
                        });

                    }
                });


            });


        });


        //Add Tester

        $(document).on('change', '.tester', function () {

            $.ajax({
                url: '{{route('admin.subtasks.test')}}',
                type: "POST",
                data: {
                    subtask_id: $(this).data('id'),
                    user_id: $(this).val(),
                    _token: '{{ csrf_token() }}'
                },
                cache: false,
                success: function (data) {
                    let timerInterval;
                    Swal.fire({
                        title: 'Tester wurde erfolgreich zugewiesen ',
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
                },
                error: function (jqXHR, status, err) {


                },
            });


        });

        // Change Tested

        $(document).on('click', '.tested', function () {

            var data_id = $(this).data('id');
            if ($('.subtask_status' + data_id).is(':checked')) {
                if ($('.subtask_tested' + data_id).val() == 1) {
                    $(this).parents('tr').css('display', 'none');
                }
            } else {
                // Checkbox is not checked
                console.log('Checkbox is not checked');
            }

            $.ajax({
                url: '{{ route('admin.subtasks.tested') }}',
                type: 'POST',
                // need to create this post route
                data: {
                    subtask_id: $(this).data('id'),
                    value: $(this).val(),
                    _token: '{{ csrf_token() }}'
                },
                cache: false,
                success: function(data) {
                },
                error: function(jqXHR, status, err) {
                    // Handle error response
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


        });


    </script>
@endsection
