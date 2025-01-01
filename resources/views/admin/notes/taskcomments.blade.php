
<link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
<script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}" ></script>
<div class="TaskCommentspage">
        <div class="row">
            <div class="col-md-10">
                <h2 class="maincommenttask">{!!  $subtask->task->task_title !!}</h2>
            </div>
        </div>
        <div class="row taskcomments" >
            <div class="col-md-1 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                    <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1z"/>
                </svg>
            </div>
            <div class="col-md-8">
                <h6>{!!   \Illuminate\Support\Str::limit( $subtask->subtask_title, 150, $end='...')  !!}</h6>
            </div>
        </div>
        <div class="taskcomments uncompleted_comments">
            @foreach($subtask_comments as $comment)
                @if($comment->done == 0)
                    <div class="comments-container">
                        <ul id="comments-list" class="comments-list{{$comment->id}} comments-list" data-author="{{$comment->comment_added_by}}">
                            <li>
                                <div class="comment-main-level">
                                    <div class="comment-avatar">
                                        @if(!empty($comment->user->image))
                                            <img src="{{asset('public/assets/images/users/'.$comment->user->image)}}" alt="test" />
                                        @else
                                            <img src="{{asset('public/assets/images/default.png')}}" alt="test" />
                                        @endif
                                    </div>
                                    <div class="comment-box">
                                        <div class="comment-head">
                                            <h6 class="comment-name by-author"><a href="{{asset('public/assets/images/users/'.$comment->user->image)}}">{{ $comment->user->user_name }}</a></h6>
                                            <span> {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans()}} </span>
                                            <div class="comment_header_control">
                                                @if(auth()->user()->role != 1 && auth()->user()->id  == $comment->comment_added_by )
                                                    <i class="fa fa-edit edit_comment" data-id="{{$comment->id}}"></i>
                                                    <i class="fa fa-trash del_comment" data-id="{{$comment->id}}"></i>
                                                @endif
                                                @if(auth()->user()->role == 1 )
                                                    <i class="fa fa-edit edit_comment" data-id="{{$comment->id}}"></i>
                                                    <i class="fa fa-trash del_comment" data-id="{{$comment->id}}"></i>
                                                @endif

                                                <!--Model Of Reason-->

                                                <label class="form-checkbox-label view_comment"  data-toggle="modal" data-target="#exampleModal{{$comment->id}}" >
                                                    {{__('messages.Erledigt')}}
                                                    <input name="completed" class="form-checkbox-field donecomment" value="1" type="checkbox"  data-id="{{$comment->id}}"  />
                                                    <i class="form-checkbox-button"></i>
                                                    <i class="bi bi-check2-circle"></i>
                                                </label>
                                                <div class="modal fade ergmodal" style="z-index: 99999" id="exampleModal{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <alert class="alert alert-danger alert{{$comment->id}}" style="display: none"> Bitte min 50 Buchstaben eingeben </alert>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h1 class="ergtext">Was ist der letzter stand des Kommentar?</h1>
                                                                <textarea class="form-control ergatecomment"  data-id="{{$comment->id}}"  placeholder="Was ist der letzter stand des Kommentar?" id="erigate{{$comment->id}}" minlength="50" ></textarea>
                                                                <p><span id="charchtercount{{$comment->id}}">0</span> Buschstaben </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary doneerledigt ergbutton" data-id="{{$comment->id}}">{{__('messages.Erledigt')}}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="comment-content">
                                            @if(!empty($comment->comment))
                                                <p contenteditable="false" id="comment_name{{$comment->id}}" data-id="{{$comment->id}}" class="comment-content{{$comment->id}}">
                                                    {!!$comment->comment!!}
                                                </p>

                                                <p class="commenttext{{$comment->id}}" style="display: none;"></p>
                                                <a  class="update_btn{{$comment->id}} btn  btn-sm update_comment_btn" data-id="{{$comment->id}}"> Update Comment </a>
                                                <p class="comment_updated comment_updated{{$comment->id}}"> Comment Updated Successfuly </p>
                                                @php
                                                    if(!empty($comment->tags)) {
                                                       $readusers =  json_decode($comment->readby) ;
                                                       $tags = explode(',', $comment->tags);

                                                        foreach($tags as  $user)
                                                        {
                                                                 $tagusers = \App\Models\User::where(['id'=>$user])->where('status' , 0)->first() ;
                                                                 if(!empty($tagusers)){
                                                                    echo "<span class='tagname'>@".$tagusers->first_name." " ;
                                                                      if(!empty($readusers)){
                                                                                 if(in_array( $tagusers->id , $readusers)) {
                                                                                 echo "<i class=' fa-solid  fa-thumbs-up'></i>" ;
                                                                                 }
                                                                       }
                                                                       echo "</span>";
                                                                  }
                                                         }
                                                    }
                                                @endphp
                                            @endif
                                            <div>
                                                @if(!empty($comment->comment_image))
                                                    @php
                                                        $images = json_decode($comment->comment_image, true); // Decode JSON into an array
                                                    @endphp

                                                    @if(is_array($images))
                                                        @foreach($images as $image)
                                                                <a href="{{ asset('public/assets/images/comments/' . $image) }}" target="_blank">
                                                                    <img src="{{ asset('assets/images/comments/' . $image) }}" style="width:50px;height:50px;">
                                                                </a>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </div>

                                            @if(!empty($comment->comment_pdf))
                                                <p>
                                                    <a href="{{asset('assets/images/comments/'.$comment->comment_pdf)}}"
                                                       target="_blank"> Open a PDF file. </a></p>
                                            @endif


                                        </div>
                                    </div>
                                </div>

                                <div class="replayes_count{{$comment->id}} replayes_count aadd_replay" data-list="{{$comment->comment_added_by}}" data-id="{{$comment->id}}"><p><span>{{$comment->replays->count()}}</span> </p> </div>
                                <div class="aadd_replay" data-id="{{$comment->id}}">  Antworten <i class="bi bi-plus"></i>
                                </div>

                                <ul class="comments-list reply-list{{$comment->id}} reply-list commentautor" id="rreplyalist{{$comment->id}}" >
                                </ul>

                            </li>
                        </ul>
                        <div class="add_new_replay  add_new_replay{{$comment->id}} selectedtt">
                            @php
                                $all_replays = \App\Models\Replay::where('comment_id' , $comment->id )->pluck('added_by_id');

                                $replay_users = json_decode($all_replays);
                            @endphp
                            <div class="row">
                                <div class="col-md-7">
                                    <textarea rows="2" data-id="{{$comment->id}}"  class="replay_commentt{{$comment->id}} form-control replaystylee" placeholder="{{__('messages.hat_dein_Kommentar_beantwortet')}}" style="border:1px solid #777 !important ; "></textarea>
                                    <div id="commentoutput{{$comment->id}}"></div>
                                    <!--Replay Tags -->
                                    <script type="text/javascript">
                                        $(function () {
                                            var $activate_selectator{{$comment->id}} = $('#activate_selectator{{$comment->id}}');

                                            $activate_selectator{{$comment->id}}.click(function () {
                                                var $select{{$comment->id}} = $('#selectt{{$comment->id}}');

                                                if ($select{{$comment->id}}.data('selectator') === undefined) {
                                                    $select{{$comment->id}}.selectator({
                                                        showAllOptionsOnFocus: true,
                                                        useDimmer: true,
                                                        searchFields: 'value text subtitle right'
                                                    });
                                                    $activate_selectator{{$comment->id}}.val('destroy');
                                                } else {
                                                    $select{{$comment->id}}.selectator('destroy');
                                                    $activate_selectator{{$comment->id}}.val('activate{{$comment->id}}');

                                                }

                                            });
                                            $activate_selectator{{$comment->id}}.trigger('click');

                                        });
                                    </script>
                                </div>
                                <div class="col-md-3">
                                    <select id="selectt{{$comment->id}}" name="tags[]" class="target replay_tags" multiple data-name="tags[]" style="width: 100%; height: 50px !important;  border:1px solid #777 !important ;" data-id="{{$comment->id}}" >
                                        @php
                                            $users_gests = \App\Models\User::where('deleted' , 0)->where('status' , 0)->get();
                                         /*
                                            $users_replays = \App\Models\Replay::where('comment_id',$comment->id)->get() ;
                                            print_r($users_replays);
                                        */
                                        @endphp
                                        @foreach($users_gests as $user)
                                            <option id="{{$user->id}}" value="{{$user->id}}"
                                                    @if(!empty($user->image))
                                                        data-left="{{asset('public/assets/images/users/'.$user->image)}}"
                                                    @else
                                                        data-left="{{asset('public/assets/images/default.png')}}"
                                                    @endif
                                                    @if(in_array($user->id , $replay_users)  && auth()->user()->id != $user->id ) selected @endif
                                                    @if($comment->comment_added_by  == $user->id  && auth()->user()->id !=  $comment->comment_added_by ) selected @endif

                                            > {{$user->first_name}}</option>

                                        @endforeach
                                    </select>

                                    <input value="activate{{$comment->id}}" id="activate_selectator{{$comment->id}}" type="hidden">
                                </div>
                                <div class="col-md-2">
                                    <!--End Replay Tags -->
                                    <button type="button"  class="btn btn-primary send_replayy btn_1" data-id="{{$comment->id}}" id="send_replayy{{$comment->id}}" disabled >
                                        <div class="svg-wrapper">
                                            <i class="fas fa-paper-plane"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="taskcomments completed_comments">
            @foreach($subtask_comments as $comment)
                @if($comment->done == 1)
                    <div class="comments-container">
                        <ul id="comments-list" class="comments-list{{$comment->id}} comments-list" data-author="{{$comment->comment_added_by}}">
                            <li>
                                <div class="comment-main-level">
                                    <!-- Avatar -->
                                    <div class="comment-avatar">

                                        @if(!empty($comment->user->image))
                                            <img src="{{asset('public/assets/images/users/'.$comment->user->image)}}" alt="test" />
                                        @else
                                            <img src="{{asset('public/assets/images/default.png')}}" alt="test" />
                                        @endif

                                    </div>
                                    <!-- Contenedor del Comentario -->
                                    <div class="comment-box">
                                        <div class="comment-head">

                                            <h6 class="comment-name by-author"><a href="{{asset('public/assets/images/users/'.$comment->user->image)}}">{{ $comment->user->user_name }}</a></h6>
                                            <span> {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans()}} </span>
                                            <div class="comment_header_control">
                                                @if(auth()->user()->role != 1 && auth()->user()->id  == $comment->comment_added_by )
                                                    <i class="fa fa-edit edit_comment" data-id="{{$comment->id}}"></i>
                                                    <i class="fa fa-trash del_comment" data-id="{{$comment->id}}"></i>

                                                @endif
                                                @if(auth()->user()->role == 1 )
                                                    <i class="fa fa-edit edit_comment" data-id="{{$comment->id}}"></i>
                                                    <i class="fa fa-trash del_comment" data-id="{{$comment->id}}"></i>
                                                @endif

                                            </div>


                                        </div>
                                        <div class="comment-content">
                                            @if(!empty($comment->comment))
                                                <p contenteditable="false" id="comment_name{{$comment->id}}"
                                                   data-id="{{$comment->id}}"
                                                   class="comment-content"> {!!$comment->comment!!}</p>
                                                @php
                                                    if(!empty($comment->tags)) {

                                                       $readusers =  json_decode($comment->readby) ;
                                                       $tags = explode(',', $comment->tags);

                                                        foreach($tags as  $user)
                                                        {
                                                                 $tagusers = \App\Models\User::where(['id'=>$user])->where('status' , 0)->first() ;
                                                                 if(!empty($tagusers)){
                                                                    echo "<span class='tagname'>@".$tagusers->first_name." " ;
                                                                      if(!empty($readusers)){
                                                                                 if(in_array( $tagusers->id , $readusers)) {
                                                                                 echo "<i class=' fa-solid  fa-thumbs-up'></i>" ;
                                                                                 }
                                                                       }
                                                                       echo "</span>";
                                                                  }
                                                         }
                                                    }

                                                @endphp
                                            @endif
                                            @if(!empty($comment->comment_image))
                                                <p>
                                                    <a href="{{asset('assets/images/comments/'.$comment->comment_image)}}"
                                                       target="_blank"><img
                                                            src="{{asset('assets/images/comments/'.$comment->comment_image)}}"
                                                            style"width:30px;height:30px;"></a></p>
                                            @endif
                                            @if(!empty($comment->comment_pdf))

                                                <p>
                                                    <a href="{{asset('assets/images/comments/'.$comment->comment_pdf)}}"
                                                       target="_blank"> Open a PDF file. </a></p>
                                            @endif



                                        </div>
                                    </div>
                                </div>

                                <div class="replayes_count{{$comment->id}} replayes_count aadd_replay" data-id="{{$comment->id}}" data-list="{{$comment->comment_added_by}}"><p><span>{{$comment->replays->count()}}</span> </p> </div>
                                <div class="aadd_replay" data-id="{{$comment->id}}">  Antworten <i class="bi bi-plus"></i>
                                </div>

                                <ul class="comments-list reply-list{{$comment->id}} reply-list commentautor" id="rreplyalist{{$comment->id}}">

                                </ul>

                            </li>
                        </ul>
                        <div class="add_new_replay add_new_replay{{$comment->id}} selectedtt">

                            @php
                                $all_replays = \App\Models\Replay::where('comment_id' , $comment->id )->pluck('added_by_id');

                                $replay_users = json_decode($all_replays);
                            @endphp



                            <div class="row">
                                <div class="col-md-7">
                                    <textarea rows="2" class="replay_commentt{{$comment->id}} form-control replaystylee" placeholder="hat dein Kommentar beantwortet ... "></textarea>
                                    <div id="commentoutput{{$comment->id}}"></div>
                                    <!--Replay Tags -->
                                    <script type="text/javascript">
                                        $(function () {
                                            var $activate_selectator{{$comment->id}} = $('#activate_selectator{{$comment->id}}');

                                            $activate_selectator{{$comment->id}}.click(function () {
                                                var $select{{$comment->id}} = $('#selectt{{$comment->id}}');

                                                if ($select{{$comment->id}}.data('selectator') === undefined) {
                                                    $select{{$comment->id}}.selectator({
                                                        showAllOptionsOnFocus: true,
                                                        useDimmer: true,
                                                        searchFields: 'value text subtitle right'
                                                    });
                                                    $activate_selectator{{$comment->id}}.val('destroy');
                                                } else {
                                                    $select{{$comment->id}}.selectator('destroy');
                                                    $activate_selectator{{$comment->id}}.val('activate{{$comment->id}}');

                                                }

                                            });
                                            $activate_selectator{{$comment->id}}.trigger('click');

                                        });
                                    </script>
                                </div>
                                <div class="col-md-3">
                                    <select id="selectt{{$comment->id}}" name="tags[]" class="target replay_tags" multiple data-name="tags[]" style="width: 100%; height: 50px !important;  " data-id="{{$comment->id}}">
                                        @php
                                            $users_gests = \App\Models\User::where('deleted' , 0 )->where('status' , 0)->get();
                                        @endphp
                                        @foreach($users_gests as $user)
                                            <option id="{{$user->id}}" value="{{$user->id}}"
                                                    @if(!empty($user->image))
                                                        data-left="{{asset('public/assets/images/users/'.$user->image)}}"
                                                    @else
                                                        data-left="{{asset('public/assets/images/default.png')}}"
                                                    @endif

                                                    @if(in_array($user->id , $replay_users)  && auth()->user()->id != $user->id ) selected @endif
                                                    @if($comment->comment_added_by  == $user->id  && auth()->user()->id !=  $comment->comment_added_by ) selected @endif


                                            > {{$user->first_name}}</option>
                                        @endforeach
                                    </select>

                                    <input value="activate{{$comment->id}}" id="activate_selectator{{$comment->id}}" type="hidden">
                                </div>
                                <div class="col-md-2">
                                    <!--End Replay Tags -->
                                    <button type="button"  class="btn btn-primary send_replay" data-id="{{$comment->id}}" >
                                        <div class="svg-wrapper">
                                            <i class="fas fa-paper-plane"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif
            @endforeach
        </div>
</div>


<script>
    $(document).ready(function () {
        $('.aadd_replay').each(function () {

            $(this).unbind().on('click',function() {

                var comment_id = $(this).data('id');
                $.ajax({
                    url: '{{route('admin.comments.viewreplays')}}',
                    type: 'post',
                    data: {comment_id: comment_id, _token: '{{ csrf_token() }}'},
                    cache: false,
                    success: function (data) {
                        $('#rreplyalist' + comment_id).html(data.options);
                        $('#rreplyalist' + comment_id).toggle();

                        // Edit Replays
                        $('.edit-replay').each(function () {
                            $(this).on("click", function () {
                                console.log('test edit');
                                var cmid = $(this).data('id');
                                $(".replaytext" + cmid).attr("contenteditable", "true");
                                $(".replaytext" + cmid).css({"border": "1px solid #ccc", "padding": '3px'});
                                $(".edit_replay_button" + cmid).css('display', 'block');
                            });
                        });
                        /* Edit Replay Button */
                        $('.edit_replay_button').each(function () {
                            $(this).on('click', function () {
                                var replay_id = $(this).data('id');
                                var replay_text = $('.replaytext' + replay_id).text();
                                $.ajax({
                                    type: "POST",
                                    url: '{{route('admin.comments.editreplay')}}', // need to create this post route
                                    data: {id: replay_id, replay_text: replay_text, _token: '{{ csrf_token() }}'},
                                    cache: false,
                                    success: function (data) {
                                        $('.replayalert' + replay_id).text('Replay Updated Successfuly');
                                    },
                                    error: function (jqXHR, status, err) {
                                    },
                                });

                            });
                        });
                        //For Deleting Replay
                        $('.delete-replay').each(function () {
                            $(this).on("click", function () {
                                var id = $(this).data('id');
                                swal({
                                    title: "Sind Sie sicher, dass Sie Replay löschen möchten ?",
                                    icon: "warning",
                                    buttons: true,
                                    dangerMode: true,
                                })
                                    .then((willDelete) => {
                                        if (willDelete) {
                                            $.ajax({
                                                url: '{{route('admin.comments.delete_replay')}}',
                                                method: "POST",
                                                data: {_token: '{{ csrf_token() }}', id: id},
                                                success: function (response) {
                                                    $(".comment-box" + id).parent('li').css('display', 'none');
                                                }
                                            });
                                            swal("Deleted!", {
                                                icon: "success",
                                            });

                                        }

                                    });

                            });
                        });

                    },
                    error: function () {

                    }
                });
                $('.TaskCommentspage .add_new_replay' + $(this).data('id')).css("display", "block");
            });
        });

        /* Replay  Tags */
        $('.replay_tags').each(function () {
            $(this).on('change', function () {
                var replay_id = $(this).data('id');
                var tagsc = $(this).val();
                var tagstring = tagsc.toString();
                $.ajax({
                    url: '{{route('admin.comments.savetags')}}',
                    type: 'post',
                    data: {replay_id: replay_id, tags: tagstring, _token: '{{ csrf_token() }}'},
                    cache: false,
                    success: function (data) {

                    },
                    error: function () {

                    }
                })
            });

        });

        /* Delete Replay */
        $('.delete-replay').each(function () {
            $(this).on("click", function () {
                var id = $(this).data('id');
                swal({
                    title: "Sind Sie sicher, dass Sie Replay löschen möchten ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: '{{route('admin.comments.delete_replay')}}',
                                method: "POST",
                                data: {_token: '{{ csrf_token() }}', id: id},
                                success: function (response) {
                                    $(".comment-box"+id).parent('li').css('display', 'none');
                                }
                            });
                            swal("Deleted!", {
                                icon: "success",
                            });

                        }

                    });

            });
        });

        // Edit Replays
        $('.edit-replay').each(function () {
            $(this).on("click", function () {
                console.log('test edit') ;
                var cmid = $(this).data('id');
                $(".replaytext" + cmid).attr("contenteditable", "true");
                $(".replaytext" + cmid).css({"border":"1px solid #ccc" , "padding":'3px'});
                $(".edit_replay_button" + cmid).css('display', 'block');
            });
        });

        /* Edit Replay Button */
        $('.edit_replay_button').each(function(){
            $(this).on('click' , function(){
                var replay_id  = $(this).data('id') ;
                var  replay_text =  $('.replaytext'+ replay_id).text() ;
                $.ajax({
                    type: "POST",
                    url: '{{route('admin.comments.editreplay')}}', // need to create this post route
                    data: {id: replay_id , replay_text: replay_text, _token: '{{ csrf_token() }}'},
                    cache: false,
                    success: function (data) {
                        $('.replayalert'+ replay_id).text('Replay Updated Successfuly') ;
                    },
                    error: function (jqXHR, status, err) {
                    },
                });

            });
        });

        //For Deleting Replay
        $('.delete-replay').each(function () {
            $(this).on("click", function () {
                var id = $(this).data('id');
                swal({
                    title: "Sind Sie sicher, dass Sie Replay löschen möchten ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: '{{route('admin.comments.delete_replay')}}',
                                method: "POST",
                                data: {_token: '{{ csrf_token() }}', id: id},
                                success: function (response) {
                                    $(".comment-box"+id).parent('li').css('display', 'none');
                                }
                            });
                            swal("Deleted!", {
                                icon: "success",
                            });

                        }

                    });

            });
        });

        $('.replaystylee').each(function(){
            $(this).on('keyup' ,function (){
                if($(this).val().length > 0) {
                    $('#send_replayy'+$(this).data('id')).prop('disabled', false);
                }else
                {
                    $('#send_replayy'+$(this).data('id')).prop('disabled', true);
                }
            })
        });

        $('.send_replayy').each(function() {
            $(this).on('click' , function (){
                $(this).prop('disabled', true);
                var addedby = "{{Auth::user()->first_name}}" ;
                var comment_id =$(this).data('id') ;
                var  replay_comment = $('.replay_commentt'+comment_id).val() ;
                var comment_author =  $('.comments-list'+comment_id).data('author') ;
                var task_id = $("#task_id").val();
                var tagsc =  $('#selectt'+comment_id).val() ;
                var tagstring = tagsc.toString();


                /*create  replay box */
                var li_elem = document.createElement('li') ;
                var image  =  document.createElement('div') ;
                image.className = "comment-avatar" ;

                var innerimage = document.createElement('img') ;
                innerimage.setAttribute('src' ,"{{asset('public/assets/images/users/'.auth::user()->image)}}") ;
                image.appendChild(innerimage) ;



                var comment_box  =  document.createElement('div') ;
                comment_box.className = "comment-box" ;

                var comment_head =  document.createElement('div') ;
                comment_head.className = "comment-head" ;
                comment_box.appendChild(comment_head) ;

                var controles   =  document.createElement('div') ;
                controles.className = "controls" ;

                var del_replay   =  document.createElement('span') ;
                del_replay.className = "delete-replay";


                var delicon   =  document.createElement('i') ;
                delicon.className = "fa fa-trash";

                del_replay.appendChild(delicon) ;
                controles.appendChild(del_replay) ;

                var edit_replay   =  document.createElement('span') ;
                edit_replay.className = "edit-replay";

                var editicon   =  document.createElement('i') ;
                editicon.className = "fa fa-edit";

                edit_replay.appendChild(editicon) ;
                controles.appendChild(edit_replay) ;



                comment_head.appendChild(controles) ;




                var comment_name =  document.createElement('h6') ;
                comment_name.className = "comment-name" ;
                comment_head.appendChild(comment_name) ;

                var spantime  =  document.createElement('span') ;
                spantime.innerText = 'Now';
                comment_head.appendChild(spantime) ;

                var hyperlink  =  document.createElement('a') ;
                hyperlink.innerText = "{{auth::user()->first_name}}" ;
                comment_name.appendChild(hyperlink) ;





                var content  =  document.createElement('div') ;
                content.className = "comment-content" ;
                content.innerText = replay_comment;

                var  tags_footer =  document.createElement('div') ;
                tags_footer.className="tags_footer" ;


                $('#selectator_selectt'+comment_id+' .selectator_selected_items').children('.selectator_selected_item').each(function (){
                    var tag_name = document.createElement('span');
                    tag_name.className = "tagname";
                    tag_name.innerText = '@' + $(this).find('.selectator_selected_item_title').text();
                    tags_footer.appendChild(tag_name);
                });


                content.appendChild(tags_footer);
                comment_box.appendChild(content) ;


                li_elem.appendChild(image) ;
                li_elem.appendChild(comment_box) ;

                $('.reply-list'+comment_id).append(li_elem);

                $('.reply-list'+comment_id).css({'display': 'block'});

                $('.replay_commentt'+comment_id).val(' ') ;

                /*End Replay box*/


                $.ajax({
                    url: '{{route('admin.subtasks.store_replay')}}',
                    method: "POST",
                    data: {tags:tagstring , addedby : addedby ,comment_id : comment_id ,replay_comment : replay_comment , task_id:task_id , comment_author :comment_author ,   _token: '{{ csrf_token() }}'},
                    success: function (data) {

                        $(".replayes_count"+comment_id+" p span").text(data['count']);
                        del_replay.setAttribute('data-id', data['id']) ;
                        del_replay.classList.add('delete-replay'+data['id']) ;
                        comment_box.classList.add('comment-box'+data['id']) ;
                        /* Delete Added Replay   */
                        $('.delete-replay').each(function () {
                            $(this).on("click", function () {
                                var id = $(this).data('id');
                                swal({
                                    title: "Sind Sie sicher, dass Sie Replay löschen möchten ?",
                                    icon: "warning",
                                    buttons: true,
                                    dangerMode: true,
                                })
                                    .then((willDelete) => {
                                        if (willDelete) {
                                            $.ajax({
                                                url: '{{route('admin.comments.delete_replay')}}',
                                                method: "POST",
                                                data: {_token: '{{ csrf_token() }}', id: id},
                                                success: function (response) {

                                                    $(".comment-box"+id).parent('li').css('display', 'none');
                                                }
                                            });
                                            swal("Deleted!", {
                                                icon: "success",
                                            });

                                        }

                                    });

                            });
                        });

                    },
                    error:function ()
                    {
                        /*$('.reply-list'+comment_id).append('test comment')*/
                    }

                });


            });
        });
        /* Back Button */
        $('.taskcomments svg').click(function () {
            $('.main-tasks').css('display' , 'block') ;
            $('#tabcomments').css('display' , 'none') ;
        });

        /* Erledigte */
        $('.doneerledigt').unbind().click(function () {
            var comment_id =  $(this).data('id') ;
            var addedby = "{{Auth::user()->first_name}}" ;
            var task_id = $("#task_id").val();
            var comment_author =  $('.comments-list'+comment_id).data('author') ;
            var replay =  $('#erigate'+comment_id).val() ;
            if(replay == '' || replay.length < 50 ){
                $('.alert'+comment_id).css('display' , 'block') ;
            }else {
                $.ajax({
                    url: '{{route('admin.comments.donecomment')}}',
                    type: "POST",
                    data: {
                        comment_id: $(this).data('id'),
                        doneby: "{{auth::user()->id}}",
                        value: 1,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        /* send As Replay */
                        $.ajax({
                            url: '{{route('admin.subtasks.store_replay')}}',
                            method: "POST",
                            data: {
                                tags: null,
                                addedby: addedby,
                                comment_id: comment_id,
                                replay_comment: replay,
                                task_id: task_id,
                                comment_author: comment_author,
                                _token: '{{ csrf_token() }}'
                            },

                            success: function (response) {
                                var li_elem = document.createElement('li');

                                var image = document.createElement('div');
                                image.className = "comment-avatar";

                                var innerimage = document.createElement('img');
                                innerimage.setAttribute('src', "{{asset('public/assets/images/users/'.auth::user()->image)}}");
                                image.appendChild(innerimage);


                                var comment_box = document.createElement('div');
                                comment_box.className = "comment-box";

                                var comment_head = document.createElement('div');
                                comment_head.className = "comment-head";
                                comment_box.appendChild(comment_head);

                                var comment_name = document.createElement('h6');
                                comment_name.className = "comment-name";
                                comment_head.appendChild(comment_name);

                                var spantime = document.createElement('span');
                                spantime.innerText = 'Now';
                                comment_head.appendChild(spantime);

                                var hyperlink = document.createElement('a');
                                hyperlink.innerText = "{{auth::user()->first_name}}";
                                comment_name.appendChild(hyperlink);


                                var content = document.createElement('div');
                                content.className = "comment-content";
                                content.innerText = replay;

                                comment_box.appendChild(content);
                                li_elem.appendChild(image);


                                li_elem.appendChild(comment_box);
                                $('#exampleModal' + comment_id).modal('toggle');
                                $('.reply-list' + comment_id).append(li_elem);
                                $('.reply-list' + comment_id).css({'display': 'block'});

                                $('.comments-list' + comment_id).css('display', 'none');

                            },
                            error: function () {

                            }

                        });


                    },
                    error: function (jqXHR, status, err) {
                    },
                });
            }

        });

        /*Eager Change on input  */
        $('.ergatecomment').each(function() {
            var data_id = $(this).data('id');
            $(this).on('keyup',function (){
                $('#charchtercount'+data_id).html($(this).val().length) ;
            });

        });


        /* edit Comment */
        $('.edit_comment').each(function () {
            $(this).on("click", function () {
                var cmid = $(this).data('id');
                $("#comment_name" + cmid).attr("contenteditable", "true");
                $("#comment_name" + cmid).css("border", "1px solid #ccc");
                $(".update_btn"+cmid).css("display", "initial");


            });
        });
        /* Update Comment */
        $('.update_comment_btn').on('click' , function () {
            var id = $(this).data('id');

            $('.commenttext'+id).html($('.comment-content'+id).text().replace(/\n/g, "<br>"));
            var comment_text = $('.commenttext'+id).html() ;

            $.ajax({
                type: "POST",
                url: '{{route('admin.comments.update')}}', // need to create this post route
                data: {id: id, comment_name: comment_text , _token: '{{ csrf_token() }}'},
                cache: false,
                success: function (data) {
                    $('.comment_updated'+id).css("display", "initial");
                    setTimeout(()=>{
                        $('.comment_updated'+id).css("display", "none");
                    },1500);
                },
                error: function (jqXHR, status, err) {
                },
            });
        });

        /* delete Comment */
        $('.del_comment').each(function () {
            $(this).on("click", function () {
                var id = $(this).data('id');

                swal({
                    title: "{{__('messages.delete comment')}}",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {

                            $.ajax({
                                url: '{{route('admin.comments.delete')}}',
                                method: "POST",
                                data: {_token: '{{ csrf_token() }}', id: id},
                                success: function (response) {
                                    $('comments-list'+id).css('display' , 'none');
                                }
                            });
                            swal("Es wurde bereits gelöscht!", {
                                icon: "success",
                            });
                            //window.location.reload();
                            $(".comments-list"+id).css('display', 'none');
                            $(".add_new_replay"+id).css('display', 'none');
                        } else {

                        }
                    });

            });
        });

    });
    /*End Replays Tags*/
</script>

