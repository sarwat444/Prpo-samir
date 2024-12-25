@extends('layouts.dashboard')
@section('css')
<link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
<script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}" ></script>
<link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
<link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">
<style>
    .chose_comment
    {
        display: none;

        color: red;
        font-size: 13px;
        padding: 0;
    }
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
        border-radius: 7px;
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
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-11">
               <div class="mytasks">
                    <div class="fillter comments_filter">
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

                                          <div class="col-md-1">

                                              <div class="status erledigt">

                                                  <label class="control control--checkbox">Kommentar
                                                      <input type="checkbox"  id="Kommentar"  name="Kommentar" class="form-checkbox-field deletecomment" value="1" type="checkbox"  />
                                                      <div class="control__indicator"></div>
                                                  </label>

                                              </div>

                                          </div>

                                          <div class="col-md-1">
                                              <div class=" status abgahackt">

                                                  <label class="control control--checkbox"> Antwort
                                                      <input type="checkbox"   name="Antwort"  class="form-checkbox-field" value="1" type="checkbox"  />
                                                      <div class="control__indicator"></div>
                                                  </label>

                                              </div>
                                          </div>

                                          <div class="col-md-1">
                                              <div class="status erledigt">

                                                  <label class="control control--checkbox"> Erledigt
                                                      <input type="checkbox" id="erledigt"     name="erledigt"   class="form-checkbox-field" value="1" data-type="erledigt_filter"  type="checkbox"  />
                                                      <div class="control__indicator"></div>
                                                  </label>


                                              </div>
                                          </div>

                                          <div class="col-md-1">
                                              <div class=" status abgahackt">
                                                  <label class="control control--checkbox"> Abgahackt
                                                      <input type="checkbox" id="erledigt"     name="seen"   class="form-checkbox-field show_read_comments" value="1"  type="checkbox"/>
                                                      <div class="control__indicator"></div>
                                                  </label>


                                              </div>
                                          </div>

                                      <div class="col-md-1">
                                          <div class="search_filter">
                                              <button class="search-btn"><i class="fa fa-search"></i></button>
                                          </div>
                                      </div>
                                          <input type="hidden" name="usercomment" value="{{Auth::user()->id}}"  id="userid"/>
                                  </div>
                        <div class="row">
                            <p class="chose_comment">* You MusT Choose Comment  Or Replay First   </p>
                        </div>
                    </div>

<!--Start  Data table-->
        <div class="filtered_data">
                <table id="example" class="table table-bordered" cellspacing="0" width="100%" data-orderable="3" data-orderable_type="desc">
                    <thead class="table-light">
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
                                             @if(!in_array(auth()->user()->id , $readed) && $note->status != 1 )

                                                            <tr>
                                                                <td style="text-align: center">
                                                                              <label class="form-checkbox-label">
                                                                                  <input name="completed" class="form-checkbox-field deletecomment" value="1" type="checkbox" data-id="{{$note->id}}"  />
                                                                                  <i class="form-checkbox-button"></i>
                                                                              </label>
                                                                </td>
                                                                <td>
                                                                     {!!$note->comment!!}

                                                                </td>
                                                                <td>
                                                                    <p class="addedby_id" style="height: 0" >{{$note->id}}</p>
                                                                    @if(!empty($note->comment_added_by))
                                                                                          @if(!empty($note->added_by) && file_exists(public_path().'/assets/images/users/'.$note->added_by->image))
                                                                                             <img src="{{asset('public/assets/images/users/'.$note->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member" class="addedbyimg"> <p>{{$note->added_by->first_name}}</p>
                                                                                          @else
                                                                                               <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;" class="addedbyimg">
                                                                                          @endif
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                <p class="sortdate" style="visibility:hidden;height:0 ;margin:0">{{$note->created_at}}</p>
                                                                    {{ date('d.m.Y', strtotime($note->created_at->addhours(2)))}}
                                                                </td>
                                                                <td data-order="1000" style="text-align: center">
                                                                    <i class="fa fa-list  btn-task-comments2"  data-id="{{$note->task_id}}" data-comment="{{$note->id}}"  ></i>
                                                                </td>
                                                            </tr>
                                                      @endif

                                            @else



                                            <tr>
                                                <td style="text-align: center">
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
                                                  <p class="addedby_id" style="height: 0">{{$note->id}}</p>
                                                    @if(!empty($note->comment_added_by))
                                                        @if(!empty($note->added_by) &&  file_exists(public_path().'/assets/images/users/'.$note->added_by->image))
                                                            <img src="{{asset('public/assets/images/users/'.$note->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member" class="addedbyimg"> <p>{{$note->added_by->first_name}}</p>
                                                        @else
                                                            <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <p class="sortdate" style="visibility:hidden;height:0 ;margin:0">{{$note->created_at}}</p>
                                                    {{ date('d.m.Y', strtotime($note->created_at->addhours(2)))}}
                                                </td>
                                                <td data-order="1000" style="text-align: center">
                                                    <i class="fa fa-list  btn-task-comments2"  data-id="{{$note->task_id}}" data-comment="{{$note->id}}" data-ergite="@if($note->done == 1 ) 1 @else 0 @endif"></i>
                                                </td>
                                            </tr>

                                      @endif


                                @endforeach
                                <!--Start  Replays -->
                                @foreach($replays as $replay)
                                   @if(!empty($replay->comment))

                                           @php
                                            $replays_arr   = json_decode($replay->is_read) ;
                                            $done_comments =   json_decode($replay->comment->readby) ;

                                          @endphp

                                          @if(empty($replay->is_read) || !in_array(auth::user()->id , $replays_arr))

                                                        <tr>


                                                                                <td style="text-align: center">

                                                                                  <label class="form-checkbox-label">
                                                                                      <input name="completed" class="form-checkbox-field checkreplay" value="1" type="checkbox" data-id="{{$replay->id}}"  />
                                                                                      <i class="form-checkbox-button"></i>
                                                                                  </label>
                                                                               </td>


                                                            <td class="replay_text">
                                                                @if($replay->comment->done == 1)
                                                                    <span class="badge rounded-pill bg-primary">Erledigt</span>
                                                                @endif
                                                                {!!$replay->replay!!}
                                                            </td>
                                                            <td>
                                                                <p class="addedby_id" style="height: 0 ">{{$replay->id}} </p>
                                                                @if(!empty($replay->added_by_id))
                                                                                    @if(!empty($replay->user) &&  file_exists(public_path().'/assets/images/users/'.$replay->user->image))
                                                                                        <img src="{{asset('public/assets/images/users/'.$replay->user->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member" class="addedbyimg"> <p>{{$replay->user->first_name}}</p>
                                                                                    @else
                                                                                        <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <p class="sortdate" style="visibility:hidden;height:0 ;margin:0">{{$replay->created_at}}</p>
                                                                {{ date('d.m.Y', strtotime($replay->created_at->addhours(2)))}}

                                                            </td>
                                                            <td data-order="1000" style="text-align: center">
                                                            <i class="fa fa-list  btn-task-replaycomment"  data-id="{{$replay->task_id}}" data-comment="{{$replay->comment_id}}"  data-replay="{{$replay->id}}" data-done="{{$replay->comment->done}}"></i>
                                                            </td>
                                                 </tr>

                                          @endif
                                   @endif
                                @endforeach
                                <!--End Replyas -->
                    </tbody>
                </table>
        </div>
<!--End data Table -->


    </div>
        </div>
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
                    data: {id: id, type: type , comment_id: comment_id , _token: '{{ csrf_token() }}'},
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
                    "order" : [[3, "desc"]],
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

        $('.search-btn').unbind().on('click', function () {
            var type = 'date_filter' ;
            var erledigt = $('input[name=erledigt]:checked').val();
            var Kommentar = $('input[name=Kommentar]:checked').val();
            var Antwort = $('input[name=Antwort]:checked').val();
            var end_due_date = $('.end_due_date').val() ;
            var start_due_date = $('.start_due_date').val();
            var seen = $('input[name=seen]:checked').val();

            /*Comments*/
            if(Kommentar ==undefined && Antwort ==  undefined ) {
                $('.chose_comment').css('display','initial') ;
            }else
            {
                $('.chose_comment').css('display','none') ;
                if (Kommentar == 1 && Antwort == undefined) {

                    if (start_due_date == '' && end_due_date == '' && seen == undefined && erledigt == undefined) {

                        $.ajax({
                            url: '{{route('admin.filter.filtercomments')}}',
                            type: "POST",
                            data: {
                                comment : 1 ,
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


                    if (start_due_date != '' && end_due_date != '' && erledigt == undefined && seen == undefined) {

                        $.ajax({
                            url: '{{route('admin.filter.filtercomments')}}',
                            type: "POST",
                            data: {
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                erledigt: erledigt,
                                type: type,
                                comment : 1 ,
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
                    if (start_due_date != '' && end_due_date != '' && erledigt == 1 && seen == undefined) {

                        $.ajax({
                            url: '{{route('admin.filter.filtercomments')}}',
                            type: "POST",
                            data: {
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                erledigt: erledigt,
                                comment : 1 ,
                                type: type,
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
                    if (start_due_date != '' && end_due_date != '' && seen == 1 && erledigt == undefined) {
                        $.ajax({
                            url: '{{route('admin.filter.filtercomments')}}',
                            type: "POST",
                            data: {
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                seen: seen,
                                comment : 1 ,
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
                    if (start_due_date != '' && end_due_date != '' && seen == 1 && erledigt == 1) {

                        $.ajax({
                            url: '{{route('admin.filter.filtercomments')}}',
                            type: "POST",
                            data: {
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                erledigt: erledigt,
                                seen: seen,
                                comment : 1 ,
                                type: type,
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
                    if (start_due_date == '' && end_due_date == '' && erledigt == 1 && seen == undefined) {

                        $.ajax({
                            url: '{{route('admin.filter.filtercomments')}}',
                            type: "POST",
                            data: {
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                erledigt: erledigt,
                                type: type,
                                comment : 1 ,
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
                    if (start_due_date == '' && end_due_date == '' && seen == 1 && erledigt == undefined) {
                        $.ajax({
                            url: '{{route('admin.filter.filtercomments')}}',
                            type: "POST",
                            data: {
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                seen: seen,
                                erledigt: erledigt,
                                comment : 1 ,
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
                    if (start_due_date == '' && end_due_date == '' && seen == 1 && erledigt == 1) {
                        $.ajax({
                            url: '{{route('admin.filter.filtercomments')}}',
                            type: "POST",
                            data: {
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                seen: seen,
                                erledigt: erledigt,
                                comment : 1 ,
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
                else if (Kommentar == undefined && Antwort == 1) {
                    //Two Dates
                    if (start_due_date == '' && end_due_date == '' && seen == undefined && erledigt == undefined) {
                        $.ajax({
                            url: '{{route('admin.filter.filterReplays')}}',
                            type: "POST",
                            data: {
                                replay: 1 ,
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
                    if (start_due_date != '' && end_due_date != '' && seen == undefined) {

                        $.ajax({
                            url: '{{route('admin.filter.filterReplays')}}',
                            type: "POST",
                            data: {
                                replay: 1 ,
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                type: type,
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
                    if (start_due_date != '' && end_due_date != '' && seen == 1) {
                        $.ajax({
                            url: '{{route('admin.filter.filterReplays')}}',
                            type: "POST",
                            data: {
                                replay: 1 ,
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
                    if (start_due_date == '' && end_due_date == '' && seen == 1) {
                        $.ajax({
                            url: '{{route('admin.filter.filterReplays')}}',
                            type: "POST",
                            data: {
                                replay: 1 ,
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

                } else if (Kommentar == 1 && Antwort == 1) {

                    if (start_due_date == '' && end_due_date == '' && seen == undefined && erledigt == undefined) {

                        $.ajax({
                            url: '{{route('admin.filter.filltercommentsandreplays')}}',
                            type: "POST",
                            data: {
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

                    if (start_due_date != '' && end_due_date != '' && seen == undefined && erledigt == undefined) {

                        $.ajax({
                            url: '{{route('admin.filter.filltercommentsandreplays')}}',
                            type: "POST",
                            data: {
                                start_due_date: start_due_date,
                                end_due_date: end_due_date,
                                type: type,
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
                    if (start_due_date != '' && end_due_date != '' && seen == 1 && erledigt == undefined) {
                        $.ajax({
                            url: '{{route('admin.filter.filltercommentsandreplays')}}',
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
                    if (start_due_date == '' && end_due_date == '' && seen == 1 && erledigt == undefined) {
                        $.ajax({
                            url: '{{route('admin.filter.filltercommentsandreplays')}}',
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
            }

        });





      /*End Fillter*/
    });
</script>
@endsection
