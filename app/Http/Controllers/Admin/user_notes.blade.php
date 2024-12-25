@extends('layouts.dashboard')
@section('css')
<link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
<script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}" ></script>
<link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
<link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">
<style>
    .badge
    {
        background-color: #035d94 !important;
        font-size: 9px;
        font-weight: 100;
        margin-right: 7px;
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
    .show_completed_comments
    {
        float: right;
        margin: 4px;
        font-size: 12px;
        color: #fff;
        font-weight: 500;
        background-color: #03658c;
        text-align: center;
        border-radius: 4px;
        box-shadow: 3px 3px 0px -1px #21252938;
        padding: 3px;
        margin: 0;
        margin-right: 9px;
        margin-top: 14px;
        padding: 6px;
    }
    .show_completed_comments .form-checkbox-button
    {
        visibility: hidden;
    }
    .show_completed_comments:hover{
        background-color: #FFFFFF;
        color:#03658c ;
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
#example
{
    padding: 0 !important;
}
    .addedby_id ,
    .sortdate
    {
        visibility: hidden !important;
    }
    .replay_text
    {
        color: #0298f3 !important;
       font-weight: 500;
    }
    .erledigt,.abgahackt
    {
        text-align: left;
        font-size: 10px;
        color: #fff;
         padding-top: 10px;
    }

</style>
@endsection
@section('title')Meine Aufgaben @endsection
@section('content')
<!--Start  Users Tasks -->
<div class="container">
    <div class="mytasks">
                    <div class="fillter comments_filter">
                                  <div class="row" style="padding-left: 10px;">
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

                                          <div class="col-md-1">
                                              <div class="status erledigt">
                                                  <input id="Kommentar" type="checkbox" name="Kommentar" value='1'/> <label> Kommentar </label>
                                              </div>
                                          </div>

                                          <div class="col-md-1">
                                              <div class=" status abgahackt">
                                                  <input name="Antwort" type="checkbox"  value='1' /> <label> Antwort </label>
                                              </div>
                                          </div>


                                          <div class="col-md-1">
                                              <div class="status erledigt">
                                                  <input id="erledigt" type="checkbox" name="erledigt" value='1' data-type="erledigt_filter" /> <label> erledigt </label>
                                              </div>
                                          </div>

                                          <div class="col-md-1">
                                              <div class=" status abgahackt">
                                                  <input class="show_read_comments" name="seen" type="checkbox"  value='1' /> <label> abgahackt </label>
                                              </div>
                                          </div>





                                      <div class="col-md-1">
                                          <div class="search_filter">
                                              <button class="search-btn"><i class="bi bi-search"></i></button>
                                          </div>
                                      </div>
                                          <input type="hidden" name="usercomment" value="{{Auth::user()->id}}"  id="userid"/>
                                      </div>
                    </div>

<!--Start  Data table-->
        <div class="filtered_data">
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>

                            <th>{{__('messages.hide')}}</th>
                            <th>{{__('messages.comments')}}</th>
                            <th>{{__('messages.created_by')}}</th>
                            <th>{{__('messages.created_at')}}</th>
                            <th>{{__('messages.details')}} </th>
                        </tr>
                    </thead>
                    <tbody  class="tasks user_subtasks commentslist">

                                @foreach($notes as $note)
                                        @if(!empty($note->readby))
                                         @php
                                            $readed   = json_decode($note->readby) ;

                                            @endphp


                                          @if(!in_array(auth::user()->id , $readed ) && $note->status != 1 )

                                                <tr>

                                                    <td>
                                                                  <label class="form-checkbox-label">
                                                                      <input name="completed" class="form-checkbox-field deletecomment" value="1" type="checkbox" data-id="{{$note->id}}"  />
                                                                      <i class="form-checkbox-button"></i>
                                                                  </label>


                                                    </td>
                                                    <td>
                                                         {!!$note->comment!!}

                                                    </td>
                                                    <td>
                                                        <p class="addedby_id">{{$note->id}}</p>
                                                        @if(!empty($note->comment_added_by))
                                                                              @if(file_exists(public_path().'/assets/images/users/'.$note->added_by->image))
                                                                                 <img src="{{asset('public/assets/images/users/'.$note->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member"> <p>{{$note->added_by->first_name}}</p>
                                                                              @else
                                                                                   <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                                                                              @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <p class="sortdate">{{$note->created_at}}</p>
                                                        {{ date('d.m.Y', strtotime($note->created_at->addhours(2)))}}

                                                    </td>
                                                    <td data-order="1000">
                                                        <i class="bi bi-card-list btn-task-popup btn-task-comments2"  data-id="{{$note->task_id}}" data-comment="{{$note->id}}" ></i>
                                                    </td>
                                                </tr>
                                          @endif

                                            @else

                                            <tr>
                                                <td>
                                                    <label class="form-checkbox-label">
                                                        <input name="completed" class="form-checkbox-field deletecomment" value="0" type="checkbox" data-id="{{$note->id}}"  />
                                                        <i class="form-checkbox-button"></i>
                                                    </label>


                                                </td>
                                                <td>
                                                    @if($note->done == 1)
                                                        <span class="badge rounded-pill bg-primary">Erledigt</span>
                                                    @endif
                                                    {!!$note->comment!!}

                                                </td>
                                                <td>
                                                  <p class="addedby_id">{{$note->id}}</p>
                                                    @if(!empty($note->comment_added_by))
                                                        @if(file_exists(public_path().'/assets/images/users/'.$note->added_by->image))
                                                            <img src="{{asset('public/assets/images/users/'.$note->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member"> <p>{{$note->added_by->first_name}}</p>
                                                        @else
                                                            <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                     <p class="sortdate">{{$note->created_at}}</p>
                                                    {{ date('d.m.Y', strtotime($note->created_at->addhours(2)))}}
                                                </td>
                                                <td data-order="1000">
                                                    <i class="bi bi-card-list btn-task-popup btn-task-comments2"  data-id="{{$note->task_id}}" data-comment="{{$note->id}}" data-ergite="@if($note->done == 1 ) 1 @else 0 @endif"></i>
                                                </td>
                                            </tr>

                                      @endif


                                @endforeach


                                <!--Start  Replays -->
                                @foreach($replays as $replay)
                                        @if(!empty($replay->is_read))
                                         @php
                                            $readed   = json_decode($replay->is_read) ;

                                            @endphp

                                          @if(!in_array(auth::user()->id , $readed ))

                                                <tr>

                                                    <td>
                                                                  <label class="form-checkbox-label">
                                                                      <input name="completed" class="form-checkbox-field checkreplay" value="1" type="checkbox" data-id="{{$replay->id}}"  />
                                                                      <i class="form-checkbox-button"></i>
                                                                  </label>

                                                    </td>
                                                    <td class="replay_text">
                                                    <i class="bi bi-reply-all"></i> {!!$replay->replay!!}
                                                    </td>
                                                    <td>
                                                        <p class="addedby_id">{{$replay->id}} </p>
                                                        @if(!empty($replay->added_by_id))
                                                                              @if(file_exists(public_path().'/assets/images/users/'.$replay->user->image))
                                                                                 <img src="{{asset('public/assets/images/users/'.$replay->user->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member"> <p>{{$note->added_by->first_name}}</p>
                                                                              @else
                                                                                   <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                                                                              @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <p class="sortdate">{{$replay->created_at}}</p>
                                                        {{ date('d.m.Y', strtotime($replay->created_at->addhours(2)))}}

                                                    </td>
                                                    <td data-order="1000">
                                                    <i class="bi bi-card-list btn-task-popup btn-task-replaycomment"  data-id="{{$replay->task_id}}" data-comment="{{$replay->comment_id}}"  data-replay="{{$replay->id}}"></i>
                                                    </td>
                                                </tr>
                                          @endif

                                            @else

                                            <tr>
                                                <td>
                                                    <label class="form-checkbox-label">
                                                        <input name="completed" class="form-checkbox-field checkreplay" value="0" type="checkbox" data-id="{{$replay->id}}"  />
                                                        <i class="form-checkbox-button"></i>
                                                    </label>


                                                </td>
                                                <td class="replay_text">

                                                <i class="bi bi-reply-all"></i> {!!$replay->replay!!}

                                                </td>
                                                <td>
                                                  <p class="addedby_id">{{$replay->id}}</p>
                                                  @if(!empty($replay->added_by_id))
                                                                              @if(file_exists(public_path().'/assets/images/users/'.$replay->user->image))
                                                                                 <img src="{{asset('public/assets/images/users/'.$replay->user->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member"> <p>{{$note->added_by->first_name}}</p>
                                                                              @else
                                                                                   <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                                                                              @endif
                                                        @endif
                                                </td>
                                                <td>
                                                     <p class="sortdate">{{$replay->created_at}}</p>
                                                    {{ date('d.m.Y', strtotime($replay->created_at->addhours(2)))}}
                                                </td>
                                                <td data-order="1000">
                                                <i class="bi bi-card-list btn-task-popup btn-task-replaycomment"  data-id="{{$replay->task_id}}" data-comment="{{$replay->comment_id}}"  data-replay="{{$replay->id}}"></i>
                                                </td>
                                            </tr>

                                      @endif


                                @endforeach
                                <!--End Replyas -->
                    </tbody>
                </table>
        </div>
<!--End data Table -->


    </div>
</div>

<!--End Users Tasks -->
@endsection
@section('script')
<script src="{{asset('public/assets/admin/assets2/js/dd.min.js')}}"></script>
<!--Start Data Table -->



<!--End Data Table -->
<script>

	$(document).ready(function(){
					 var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
					enableTime: true,
					dateFormat: "d.m.Y  H:i",
				 });

	});


	$(document).ready(function() {
            $(document).on('click', '.btn-task-comments2', function (event) {
                event.preventDefault();
                var id = $(this).data('id');
                var comment_id  = $(this).data('comment') ;
                var ergite  = $(this).data('ergite') ;
                var type = '1';


                $.ajax({
                    type: "post",
                    url: "{{route('admin.get.task_data')}}", // need to create this post route
                    data: {id: id, type: type, _token: '{{ csrf_token() }}'},
                    cache: false,
                    success:  function (data) {
                        $('#tasks').modal('show');
                        $('.overlay').css('display', 'block');
                        $(".sidebar-model").html( data);
                        $(".sidebar-model").css({'width': '50%'});

                        if(ergite == 1)
                        {
                            $('.form-check-input').prop('checked',true)
                            $('.uncompleted_comments').css('display' ,'none');
                            $('.completed_comments').css('display' ,'block ');
                        }
                        $('#comment_name'+comment_id).parent('.comment-content').css('background-color' , 'rgb(1 122 199 / 9%)');
                       setTimeout(()=>{
                           $('.sidebar').animate({
                               scrollTop: $('.comments-list'+comment_id).offset().top
                           }, 1000);
                       },1000);

                    },
                    error: function (jqXHR, status, err) {
                    },
                });

            });


            $(document).on('change','.deletecomment' ,  function (e) {
                    /*if ($(this).prop("checked")) {*/
                        $.ajax({
                            url: '{{route('admin.comments.deletecomment')}}',
                            type: "POST",
                            // need to create this post route
                            data: {
                                comment_id: $(this).data('id'),
                                readby: "{{auth::user()->id}}",
                                value: $(this).val(),
                                _token: '{{ csrf_token() }}'
                            },
                            cache: false,
                            success: function (data) {
                            },
                            error: function (jqXHR, status, err) {


                            },
                        });
                   /* }*/
                });

//Make Replay  Is seen

                $(document).on('change','.checkreplay' ,  function (e) {
                        $.ajax({
                        type: "post",
                        url: "{{route('admin.update_replay_read')}}", // need to create this post route
                        data: {replay_id: $(this).data('id') , _token: '{{ csrf_token() }}'},
                        cache: false,
                        success: function (data) {

                          },
                        error: function (jqXHR, status, err) {
                        },
                    });
                });




            // DataTable initialisation
            var  commoenttable  = $('#example').DataTable(
                {
                    "dom": '<"dt-buttons"Bfli>rtp',
                    "paging": true,
                    "autoWidth": true,
                    "fixedHeader": true,
                }
            );
       /* Start  Fillter */
/*
        $(document).on('change','.show_read_comments' ,  function (e) {
            if ($(this).prop("checked")) {

            }
        });
*/
        /*Start Filtertion*/

        $('.search-btn').on('click', function () {
            var type = 'date_filter' ;
            var erledigt = $('input[name=erledigt]:checked').val();
            var Kommentar = $('input[name=Kommentar]:checked').val();
            var Antwort = $('input[name=Antwort]:checked').val();
            var end_due_date = $('.end_due_date').val() ;
            var start_due_date = $('.start_due_date').val();
            var seen = $('input[name=seen]:checked').val();

            /*Comments*/
            if(Kommentar == 1 && Antwort ==  undefined )
            {
                    if (start_due_date != '' && end_due_date != '' && erledigt == undefined && seen == undefined) {

                        $.ajax({
                            url: '{{route('admin.filter.filtercomments')}}',
                            type: "POST",
                            data: {
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                erledigt: erledigt,
                                type:type ,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (data) {
                                commoenttable.clear().destroy();
                                $('.filtered_data').html(data.options);
                                $('.filtered_table').DataTable({
                                    "paging": true
                                });

                            },
                            error: function (jqXHR, status, err) {
                            },
                        });

                    }
                    if (start_due_date != '' && end_due_date != ''&& erledigt == 1 && seen == undefined ){

                        $.ajax({
                            url: '{{route('admin.filter.filtercomments')}}',
                            type: "POST",
                            data: {
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                erledigt: erledigt,
                                type:type ,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (data) {

                                commoenttable.clear().destroy();
                                $('.filtered_data').html(data.options);
                                $('.filtered_table').DataTable({
                                    "paging": true
                                });

                            },
                            error: function (jqXHR, status, err) {
                            },
                        });

                    }
                    //Show All  Seen Comments with dates
                    if(start_due_date != '' && end_due_date != '' && seen == 1 && erledigt == undefined )
                    {
                        $.ajax({
                            url: '{{route('admin.filter.filtercomments')}}',
                            type: "POST",
                            data: {
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                seen: seen,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (data) {

                                commoenttable.clear().destroy();
                                $('.filtered_data').html(data.options);
                                $('.filtered_table').DataTable({
                                    "paging": true
                                });

                            },
                            error: function (jqXHR, status, err) {
                            },
                        });
                    }
                    if (start_due_date != '' && end_due_date != ''&&  seen == 1 && erledigt == 1  ){

                        $.ajax({
                            url: '{{route('admin.filter.filtercomments')}}',
                            type: "POST",
                            data: {
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                erledigt: erledigt,
                                seen:seen ,
                                type:type ,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (data) {

                                commoenttable.clear().destroy();
                                $('.filtered_data').html(data.options);
                                $('.filtered_table').DataTable({
                                    "paging": true
                                });

                            },
                            error: function (jqXHR, status, err) {
                            },
                        });

                    }
                    if (start_due_date == '' && end_due_date == ''&& erledigt == 1  &&  seen == undefined ) {

                        $.ajax({
                            url: '{{route('admin.filter.filtercomments')}}',
                            type: "POST",
                            data: {
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                erledigt: erledigt,
                                type:type ,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (data) {

                                commoenttable.clear().destroy();
                                $('.filtered_data').html(data.options);
                                $('.filtered_table').DataTable({
                                    "paging": true
                                });

                            },
                            error: function (jqXHR, status, err) {
                            },
                        });

                    }
                    //Show All  Seen Comments
                    if(start_due_date == '' && end_due_date == '' && seen == 1 && erledigt == undefined )
                    {
                        $.ajax({
                            url: '{{route('admin.filter.filtercomments')}}',
                            type: "POST",
                            data: {
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                seen: seen,
                                erledigt : erledigt ,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (data) {

                                commoenttable.clear().destroy();
                                $('.filtered_data').html(data.options);
                                $('.filtered_table').DataTable({
                                    "paging": true
                                });

                            },
                            error: function (jqXHR, status, err) {
                            },
                        });
                    }
             }
             else if(Kommentar == undefined  && Antwort ==   1 )
             {
                //Two Dates
                if (start_due_date != '' && end_due_date != '' &&  seen == undefined) {

                    $.ajax({
                        url: '{{route('admin.filter.filterReplays')}}',
                        type: "POST",
                        data: {
                            start_due_date: start_due_date,
                            end_due_date: end_due_date,
                            type:type ,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            commoenttable.clear().destroy();
                            $('.filtered_data').html(data.options);
                            $('.filtered_table').DataTable({
                                "paging": true
                            });

                        },
                        error: function (jqXHR, status, err) {
                        },
                    });

            }

//Show All  Seen Comments with dates
            if(start_due_date != '' && end_due_date != '' && seen == 1 )
            {
                $.ajax({
                    url: '{{route('admin.filter.filterReplays')}}',
                    type: "POST",
                    data: {
                        start_due_date: start_due_date,
                        end_due_date: end_due_date,
                        seen: seen,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {

                        commoenttable.clear().destroy();
                        $('.filtered_data').html(data.options);
                        $('.filtered_table').DataTable({
                            "paging": true
                        });

                    },
                    error: function (jqXHR, status, err) {
                    },
                });
            }

            //Show All  Seen replays
            if(start_due_date == '' && end_due_date == '' && seen == 1  )
            {
            $.ajax({
                url: '{{route('admin.filter.filterReplays')}}',
                type: "POST",
                data: {
                    start_due_date: start_due_date,
                    end_due_date: end_due_date,
                    seen: seen,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {

                    commoenttable.clear().destroy();
                    $('.filtered_data').html(data.options);
                    $('.filtered_table').DataTable({
                        "paging": true
                    });

                },
                error: function (jqXHR, status, err) {
                },
            });
            }

             }
             else if(Kommentar == 1  && Antwort ==   1 )
             {
                alert('2 have values ') ;
             }

        });





      /*End Fillter*/
    });
</script>
@endsection
