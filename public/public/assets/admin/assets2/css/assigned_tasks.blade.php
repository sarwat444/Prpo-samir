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

    </style>
@endsection
@section('title')Meine Aufgaben @endsection
@section('content')
    <!--Start  Users Tasks -->
    <div class="container">
        <div class="mytasks">
            <div class="sub-tasks">
                <div class="tasks user_subtasks commentslist">
                    <div class="row task  heading">
                        <div class="col-md-1">
                            Status
                        </div>
                        <div class="col-md-3">
                            <p> Unteraufgabe </p>
                        </div>
                        <div class="col-md-2">
                            <p> Post-it</p>
                        </div>

                        <div class="col-md-1">
                            <p >Kategorie</p>
                        </div>

                        <div class="col-md-1">
                            <p >verantwortlich</p>
                        </div>

                        <div class="col-md-1">
                            <p>
                                Erstellt am
                            </p>
                        </div>
                        <div class="col-md-1">
                            <p>
                                Erledigt am
                            </p>
                        </div>

                        <div class="col-md-1">
                            <p>
                                Falligkeitsdatum
                            </p>
                        </div>

                        <div class="col-md-1">
                            <p>
                                Details
                            </p>
                        </div>
                    </div>

                    @foreach($assigned_tasks  as $subtask)
                        @if($subtask->status == 0 )
                            <div class="row task">

                                <div class="col-md-1">
                                    @if($subtask->subtask_status == 1)
                                        <label class="form-checkbox-label">
                                            <input name="completed" class="form-checkbox-field deletecomment" value="1" type="checkbox" checked data-id="{{$subtask->id}}" />
                                            <i class="form-checkbox-button"></i>
                                        </label>
                                    @else
                                        <label class="form-checkbox-label">
                                            <input name="completed" class="form-checkbox-field deletecomment" value="0" type="checkbox" data-id="{{$subtask->id}}"  />
                                            <i class="form-checkbox-button"></i>
                                        </label>

                                    @endif
                                </div>

                                <div class="col-md-2">
                                    <p> {!!$subtask->subtask_title!!} </p>
                                </div>
                                <div class="col-md-3">
                                    <p data-id="{{$subtask->id}}">  @if(!empty($subtask->task->task_title))    {{$subtask->task->task_title }}     @else "No Task"  @endif </p>
                                </div>

                                <div class="col-md-1">
                                    <p>@if(!empty($subtask->task->category->category_name))    {{$subtask->task->category->category_name }}     @else "No Category"  @endif</p>
                                </div>

                                <div class="col-md-1">
                                    @if(!empty($subtask->responsible))

                                        @if(file_exists(public_path().'/assets/images/users/'.$subtask->task->responsible->image))
                                            <img src="{{asset('public/assets/images/users/'.$subtask->responsible->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member">
                                        @else
                                            <img src="https://source.unsplash.com/user/c_v_r">
                                        @endif
                         
                                    @endif
                                </div>

                                <div class="col-md-1">
                                    <p class="sub-date">

                                        {{ date('d.m.Y', strtotime($subtask->created_at->addhours(2)))}}  </p>
                                </div>
                                <div class="col-md-1">
                                    <p class="sub-date">

                                        @if(!empty($subtask->subtask_completed_at)) {{ date('d.m.Y', strtotime($subtask->subtask_completed_at))}} @else -- @endif  </p>
                                </div>

                                <div class="col-md-1">
                                    <p class="sub-date">
                                        @if(!empty($subtask->subtask_due_date))
                                            {{ date('d.m.Y', strtotime($subtask->subtask_due_date))}}
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-1">
                                    <p><i class="bi bi-card-list btn-task-popup" data-id="{{$subtask->task->id}}"></i></p>
                               </div>
                            </div>
                        @endif

                    @endforeach

            </div>
        </div>
    </div>
    <!--End Users Tasks -->
@endsection
@section('script')
    <script src="{{asset('public/assets/admin/assets2/js/dd.min.js')}}"></script>
    <script>

        $(document).ready(function(){
            var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
                enableTime: true,
                dateFormat: "d.m.Y  H:i",
            });

        });


        $(document).ready(function() {

            $(".end_due_date").on('change', function (event) {
                var type = $(this).data('type');
                var end_due_date = $(this).val() ;
                var start_due_date = $('.start_due_date').val() ;
                var  commentuserid  = $('#userid').val() ;
                if (start_due_date && end_due_date) {
                    $.ajax({
                        url :'{{route('admin.filter.filtercomments')}}' ,
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

            $(".start_due_date").on('change', function (event) {

                var type = $(this).data('type');
                var start_due_date = $(this).val()
                var end_due_date = $('.end_due_date').val()
                var  commentuserid  = $('#userid').val() ;


                if (start_due_date && end_due_date) {
                    $.ajax({
                        url :'{{route('admin.filter.filtercomments')}}' ,
                        type: "POST",
                        // need to create this post route
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

            //Delete Comment
            $(".deletecomment").each(function(){
                $(this).on('change', function (event) {
                    console.log($(this).data('id')) ;
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
            })

        });

    </script>
@endsection
