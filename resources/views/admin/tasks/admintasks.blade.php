@extends('layouts.dashboard')
@section('css')
    <link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
    <script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}"></script>
    <link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
    <link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">
    <style>
        .swal2-styled.swal2-confirm
        {
            background-color: #105386 !important;
            font-size: 13px;
            padding: 5px 21px !important;
        }
        .swal2-title
        {
            margin-top: -27px;
        }
        .swal2-styled.swal2-cancel
        {
            font-size: 13px;
            padding: 5px 21px !important;
        }
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
            font-size: 9px;
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
            text-align: center;
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
        .search-btn {
            background-color: #009eff;
            color: #fff;
            border: 0;
            padding: 9px;
            height: 40px;
            width: 40px;
            border-radius: 4px;
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
@section('title') Meine Aufgaben @endsection
@section('content')
    <!--Start  Users Tasks -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-11">
        <!--Start Final Timer Alert -->
        <alert class="alert alert-success recodtime">
            <p><i class="fa fa-check-circle"></i> Time Entery wurde erfolgreich erstellt </p>
        </alert>
        <!--End Timer Alert -->
        <div class="mytasks">
            <input type="hidden" id="gender" name="gender" value="list">
            <div class="sub-tasks">
                    <div class="fillter">
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="datepicker" data-type="date_filter" data-gender="list">
                                            <input  type="text" data-type="date_filter"
                                                    class="start_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target"
                                                    id="start_due_date"
                                                    data-name="task_due_date"
                                                    name="task_due_date"
                                                    placeholder="{{__('messages.from')}}"
                                            >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="datepicker">
                                        <input type="text" data-type="date_filter" data-gender="list"
                                               id="end_due_date"
                                               class="end_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target"
                                               data-name="task_due_date" name="task_due_date"
                                               placeholder="{{__('messages.to')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <div class="col-md-1">
                            <label class="control control--radio">{{__('messages.pending')}}
                                <input id="pending" type="radio" name="subtask_status"    value='2'  checked="checked"  data-gender="list"  />
                                <div class="control__indicator"></div>
                                <div class="control__indicator"></div>
                            </label>
                            <label class="control control--radio">{{__('messages.done')}}
                                <input id="done" type="radio" name="subtask_status"    value='1'   data-gender="list" />
                                <div class="control__indicator"></div>
                                <div class="control__indicator"></div>
                            </label>

                        </div>

                        <div class="col-md-2">
                            <div class="form-control status">
                                <label class="control control--radio">{{__('messages.created_at')}}
                                    <input id="pending" type="radio" name="subtask_status2"    value='3'   data-gender="list"  checked />
                                    <div class="control__indicator"></div>
                                    <div class="control__indicator"></div>
                                </label>

                                <label class="control control--radio">{{__('messages.due_date')}}
                                    <input id="pending" type="radio" name="subtask_status2"    value='4'   data-gender="list"     />
                                    <div class="control__indicator"></div>
                                    <div class="control__indicator"></div>
                                </label>

                            </div>
                        </div>
<!--
                        <div class="col-md-2">
                            <div class="form-control status">
                                <label class="control control--radio">{{__('messages.defaultsort')}}
                                    <input id="sorting" type="radio" name="sorting"    value='6' data-type="sorting" data-gender="list" checked />
                                    <div class="control__indicator"></div>
                                    <div class="control__indicator"></div>
                                </label>
                                <label class="control control--radio">{{__('messages.mysort')}}
                                    <input id="sorting" type="radio" name="sorting"    value='7' data-type="sorting"  data-gender="list" />
                                    <div class="control__indicator"></div>
                                    <div class="control__indicator"></div>
                                </label>
                            </div>
                        </div>
  -->
                        <div class="col-md-1">
                            <div class="search_filter">
                                <button class="search-btn"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                </div>
                    </div>
                <div class="row" >
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
                                <th>{{__('messages.subtask')}} </th>
                                <th>{{__('messages.post')}}</th>
                                <th>{{__('messages.category')}}</th>
                                <th>{{__('messages.created_by')}}</th>
                                <th>{{__('messages.created_at')}}</th>
                                <th>{{__('messages.done_at')}}</th>
                                <th>{{__('messages.due_date')}}</th>
                                <th>{{__('messages.timer')}}</th>
                                <th> Details </th>
                            </tr>
                            </thead>
                            <tbody class="tasks  user_subtasks" id="bodycontent">
                                @if(!empty($user_subtasks))
                                    @foreach($user_subtasks as $subtask)
                                        <tr class="row1" data-id="{{ $subtask->id }}">
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
                                                        <input task-id="@if(!empty($subtask->task)) {{$subtask->task->id}} @endif" name="completed"
                                                            class="form-checkbox-field change_statusss"
                                                            data-id="{{$subtask->id}}" type="checkbox" value="0"/>
                                                        <i class="form-checkbox-button"></i>
                                                    </label>

                                                @endif
                                            </td>
                                            <td>
                                                <p>{!!$subtask->subtask_title!!}</p>
                                            </td>
                                            <td>
                                                @if(!empty($subtask->task->task_title))
                                                    {!! $subtask->task->task_title  !!}
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
                                                            style="width:40px;height:40px;border-radius:50%;" alt="member">
                                                    @else
                                                        <img src="https://source.unsplash.com/user/c_v_r"
                                                            style="width:40px;height:40px;border-radius:50%;">
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <p style="visibility: hidden ; height: 0 "> {{ $subtask->created_at }} </p>
                                                {{ date('d.m.Y', strtotime($subtask->created_at->addhours(2)))}}
                                            </td>
                                            <td>
                                                <p style="visibility: hidden ; height: 0 "> {{ $subtask->created_at }} </p>
                                                @if(!empty($subtask->subtask_completed_at)) {{ date('d.m.Y', strtotime($subtask->subtask_completed_at))}} @else
                                                    -- @endif
                                            </td>

                                            <td>
                                                <p style="visibility: hidden ; height: 0 "> {{ $subtask->created_at }} </p>
                                                @if(!empty($subtask->subtask_due_date))
                                                    {{ date('d.m.Y', strtotime($subtask->subtask_due_date))}}
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Start Timer  -->
                                                <section id="stopWatch">
                                                    <p class="timer{{$subtask->id}}" style="
                                                                                font-weight: 500;
                                                                                font-size: 12px;
                                                                                color: rgb(255, 255, 255);
                                                                                background-color: #ddd;
                                                                                padding: 4px;
                                                                                border-radius: 4px;
                                                                                width: 100%;
                                                                                margin: 0px auto 10px;
                                                                                /* font-weight: bold; */
                                                                                color: #ffffff;
                                                                                padding: 5px;
                                                            "> {{!empty($subtask->subtask_time) ?  $subtask->subtask_time  : '00:00:00' }} </p>
                                                    <i class="start{{$subtask->id}} fa fa-play  start"
                                                    data-id="{{$subtask->id}}" data-toggle="play"></i>
                                                    <i class="stop{{$subtask->id}} fa fa-stop stop stotime_con"
                                                    data-id="{{$subtask->id}}" data-toggle="stop"></i>
                                                    <i class="pause{{$subtask->id}} fa fa-pause  pause"
                                                    data-id="{{$subtask->id}}" data-toggle="pause"></i>
                                                    <i class="continue{{$subtask->id}} fa fa-continue   bi bi-play-circle" hidden
                                                    data-id="{{$subtask->id}}"></i>
                                                    <p class="fulltime{{$subtask->id}} fulltime"></p>
                                                </section>
                                                <!-- End Timer -->
                                            </td>

                                            <td>
                                                <i class="fa fa-list btn-task-popup" data-id="@if(!empty($subtask->task)) {{$subtask->task->id}} @endif"></i>
                                            </td>
                                        </tr>
                                    @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>


                    <!-- BOx TOdos -->
                    <div class="todosbox" style="display:none;">
                        <div class="cards" id="cards">
                            <div class="overlay"></div>

                            <div class="row sortable-cards" id="shuffle">


                                @foreach($user_subtasks as $subtask)

                                    <div  class="col-md-3 btn-task-popup  sortable-divs mix ui-state-default"


                                         @if(!empty($subtask->task->category))
                                                    {{$subtask->task->category->category_name}}
                                                @endif

                                         @if(!empty($subtask->task)) data-id="{{$subtask->task->id}} " @endif>
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
                                                            <p> @if(!empty($subtask->task)){{ date('d.m.Y', strtotime($subtask->task->task_due_date))}} @endif</p>
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
            </div>
        </div>
    </div>
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
            let  newposition = '' ;
            let  cuurentItem  = '' ;
            let  cuurentItemIndex = '' ;
            const table = $('#subtasks_history').DataTable({
                "paging": true
            });

            $('#bodycontent').sortable({
                items : "tr" ,
                cursor : "move" ,
                opacity : 0.6 ,
                start: function( event, ui ) {
                    cuurentItem = $(ui.item).data('id');
                    cuurentItemIndex = ui.item.index();
                },
                update: function (event,ui){
                    newposition = ui.item.index() ;
                    sendOrderToServer(cuurentItem , newposition) ;
                 },
            }) ;

            function sendOrderToServer(cuurentItem , newposition ) {
                var slecteddata = [];
                var token = $('meta[name="csrf-token"]').attr('content');
                $('tr.row1').each(function(index,element) {
                    slecteddata.push($(this).attr('data-id'));
                });
                // the Ajax Post update
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.subtasks.order') }}",
                    data: {
                        newposition : newposition ,
                        cuurentItem : cuurentItem ,
                        cuurentItemIndex : cuurentItemIndex ,
                        slecteddata: slecteddata,
                        _token: token
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            console.log(response);
                        } else {
                            console.log(response);
                        }
                    }
                });
            }




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
            /* Sortable Data Table */

            $(document).on('click', '.change_statusss', function () {
                var id = $(this).data('id');
                var task_id = $(this).attr('task-id');
                //Ask To Make done Comments

                Swal.fire({
                    title: 'Sollen alle Kommentare die zu dieser Aufgabe gehören als Erledigt gesetzt werden ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'JA',
                    cancelButtonText: 'Nein',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.subtasks.update_status') }}',
                            data: {id: id, task_id: task_id , deletedcomment:true , _token: '{{ csrf_token() }}'},
                            success: function (data) {
                                        var x = Math.floor(Math.random() * 3);
                                        if(x == 0 ){
                                            $('.success-image1').css('display', 'block');
                                            $('.success-image2').css('display', 'none');
                                            $('.success-image3').css('display', 'none');
                                            setTimeout(()=>{ $('.success-image1').css('display' , 'none')}, 3000);
                                            setTimeout(()=>{ $('.success-image2').css('display' , 'none')}, 3000);
                                            setTimeout(()=>{ $('.success-image3').css('display' , 'none')}, 3000);

                                        }
                                        else if(x == 1)
                                        {
                                            $('.success-image2').css('display', 'block');
                                            $('.success-image1').css('display', 'none');
                                            $('.success-image3').css('display', 'none');
                                            setTimeout(()=>{ $('.success-image2').css('display','none')}, 3000);
                                            setTimeout(()=>{ $('.success-image1').css('display','none')}, 3000);
                                            setTimeout(()=>{ $('.success-image3').css('display','none')}, 3000);
                                        }
                                        else if(x == 2)
                                        {
                                            $('.success-image3').css('display', 'block');
                                            $('.success-image2').css('display', 'none')
                                            $('.success-image1').css('display', 'none')
                                            setTimeout(()=>{ $('.success-image3').css('display','none')}, 3000);
                                            setTimeout(()=>{ $('.success-image2').css('display','none')}, 3000);
                                            setTimeout(()=>{ $('.success-image1').css('display','none')}, 3000);
                                        }

                                        $('#task' + task_id).html('');
                                        $('#task' + task_id).html(data.options);
                            }
                        });
                    }else {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.subtasks.update_status') }}',
                            data: {id: id, task_id: task_id,deletedcomment:false , _token: '{{ csrf_token() }}'},
                            success: function (data) {
                                var x = Math.floor(Math.random() * 3);
                                if(x == 0 ){
                                    $('.success-image1').css('display', 'block');
                                    $('.success-image2').css('display', 'none');
                                    $('.success-image3').css('display', 'none');
                                    setTimeout(()=>{ $('.success-image1').css('display' , 'none')}, 3000);
                                    setTimeout(()=>{ $('.success-image2').css('display' , 'none')}, 3000);
                                    setTimeout(()=>{ $('.success-image3').css('display' , 'none')}, 3000);

                                }
                                else if(x == 1)
                                {
                                    $('.success-image2').css('display', 'block');
                                    $('.success-image1').css('display', 'none');
                                    $('.success-image3').css('display', 'none');
                                    setTimeout(()=>{ $('.success-image2').css('display','none')}, 3000);
                                    setTimeout(()=>{ $('.success-image1').css('display','none')}, 3000);
                                    setTimeout(()=>{ $('.success-image3').css('display','none')}, 3000);
                                }
                                else if(x == 2)
                                {
                                    $('.success-image3').css('display', 'block');
                                    $('.success-image2').css('display', 'none')
                                    $('.success-image1').css('display', 'none')
                                    setTimeout(()=>{ $('.success-image3').css('display','none')}, 3000);
                                    setTimeout(()=>{ $('.success-image2').css('display','none')}, 3000);
                                    setTimeout(()=>{ $('.success-image1').css('display','none')}, 3000);
                                }

                                $('#task' + task_id).html('');
                                $('#task' + task_id).html(data.options);

                            }
                        });

                    }
                });
            });
            var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
                dateFormat: "d.m.Y"
            });

// Create a new Date object
            var date = new Date();

// Set the date to the first day of the month
            date.setDate(1);

// Get the month and year values
            var month = date.getMonth() + 1;
            var year = date.getFullYear();

// Calculate the last day of the month
            var lastDay = new Date(year, month, 0).getDate();

// Set the start date
            $('#start_due_date').val(`01.${month}.${year}`);

// Set the end date
            $('#end_due_date').val(`${lastDay}.${month}.${year}`);

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
                //Sorting
                var sorting = $('input[name=sorting]:checked').val();
                //  Users
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
                            sorting :  sorting ,
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
            });
        });
    </script>
@endsection
