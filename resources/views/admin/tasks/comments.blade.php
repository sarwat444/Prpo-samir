
<div class="comments2 uncompleted_comments">
    @foreach($comments  as $comment)
        @if($comment->done == 0)
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


                                    <!--Model Of Reason-->

                                        <label class="form-checkbox-label view_comment"  data-toggle="modal" data-target="#exampleModal{{$comment->id}}" >
                                            Erledigt
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
                                                        <button type="button" class="btn btn-primary doneerledigt ergbutton" data-id="{{$comment->id}}">erledigt</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


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
                                                         $tagusers = \App\Models\User::where(['id'=>$user])->first() ;
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
                                            @php
                                                $path  = explode(".",  $comment->comment_image) ;
                                                if(strtolower($path[1]) == 'png' ||strtolower($path[1]) == 'jpg' || strtolower($path[1]) == 'jpeg' )
                                                {
                                            @endphp
                                            <img src="{{asset('assets/images/comments/'.$comment->comment_image)}}" style"width:30px;height:30px;">
                                            @php
                                                }else
                                                {
                                            @endphp
                                            <img  class="defaultfile" src="{{asset('public/public/assets/images/file.png')}}" >
                                            @php
                                                }
                                            @endphp
                                    @endif
                                    @if(!empty($comment->comment_pdf))

                                        <p>
                                            <a href="{{asset('assets/images/comments/'.$comment->comment_pdf)}}"
                                               target="_blank"> Open a PDF file. </a></p>
                                    @endif



                                </div>
                            </div>
                        </div>

                        <div class="replayes_count{{$comment->id}} replayes_count add_replay" data-list="{{$comment->comment_added_by}}" data-id="{{$comment->id}}"><p><span>{{$comment->replays->count()}}</span> </p> </div>
                        <div class="add_replay" data-id="{{$comment->id}}">  Antworten <i class="bi bi-plus"></i>
                        </div>

                        <ul class="comments-list reply-list{{$comment->id}} reply-list commentautor" id="replyalist{{$comment->id}}" >
                        </ul>

                    </li>
                </ul>
                <div class="add_new_replay  add_new_replay{{$comment->id}}">
                    @php
                        $all_replays = \App\Models\Replay::where('comment_id' , $comment->id )->pluck('added_by_id');

                        $replay_users = json_decode($all_replays);
                    @endphp
                    <div class="row">
                        <div class="col-md-7">
                            <textarea rows="2" data-id="{{$comment->id}}"  class="replay_comment{{$comment->id}} form-control replaystyle" placeholder="hat dein Kommentar beantwortet ... "></textarea>
                            <div id="commentoutput{{$comment->id}}"></div>
                            <!--Replay Tags -->
                            <script type="text/javascript">
                                $(function () {
                                    var $activate_selectator{{$comment->id}} = $('#activate_selectator{{$comment->id}}');

                                    $activate_selectator{{$comment->id}}.click(function () {
                                        var $select{{$comment->id}} = $('#select{{$comment->id}}');

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
                            <select id="select{{$comment->id}}" name="tags[]" class="target replay_tags" multiple data-name="tags[]" style="width: 100%; height: 50px !important;  " data-id="{{$comment->id}}">
                                @php
                                    $users_gests = \App\Models\User::get();
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
                            <button type="button"  class="btn btn-primary send_replay btn_1" data-id="{{$comment->id}}" id="send_replay{{$comment->id}}" disabled >
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
























<script>
 $('.edit_comment').each(function(){
         $(this).on("click", function(){
                  var cmid = $(this).data('id');
                  $("#comment_name"+cmid).attr("contenteditable","true");
                  $("#comment_name"+cmid).css("border","1px solid #ccc");
         });
 });

 $('.commentt_name').each(function(){
         $(this).on("keyup", function(){
           var id = $(this).data('id');
           var comment_name = $(this).text();

           $.ajax({
           type: "POST",
           url: '{{route('admin.comments.update')}}', // need to create this post route
           data: {id : id,comment_name : comment_name , _token : '{{ csrf_token() }}'},
           cache: false,
           success: function (data) {
              // console.log('done');
           },
           error: function (jqXHR, status, err) {
           },
        });
         });
 });

 $('.del_comment').each(function(){
         $(this).on("click", function(){
           var id = $(this).data('id');

               swal({
                       title: "Are you sure sweet?",
                       text: "Once deleted, you will not be able to recover this imaginary file!",
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

                             }

                         });
                         swal("Poof! Your imaginary file has been deleted!", {
                           icon: "success",

                         });
                         //window.location.reload();
                             $("#com_dta"+id).css('display','none');
                       } else {
                         //swal("Your imaginary file is safe!");
                       }
                     });

         });
 });

 </script>
