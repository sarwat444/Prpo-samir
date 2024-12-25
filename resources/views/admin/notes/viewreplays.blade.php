@foreach($replays as $replay)
    <li>
        <!-- Avatar -->
        <div class="comment-avatar">
            @if(!empty($replay->user->image))
                <img src="{{asset('public/assets/images/users/'.$replay->user->image)}}" alt="">
            @endif
        </div>
        <!-- Contenedor del Comentario -->
        <div class="comment-box comment-box{{$replay->id}}" >
            <div class="comment-head">
                <h6 class="comment-name"><a href="{{asset('public/assets/images/users/'.$replay->user->image)}}">{{$replay->user->user_name}}</a></h6>
                <span> <?php echo $replay->created_at->format('d.m.Y H:i:s') ?> </span>
                <div class="controls">
                    <span class="delete-replay delete-replay{{$replay->id}}" data-id="{{$replay->id}}"><i class="fa fa-trash"></i></span>
                    <span class="edit-replay edit-replay{{$replay->id}}" data-id="{{$replay->id}}"><i class="fa fa-edit"></i></span>
                </div>
            </div>
            <div class="comment-content">
                <p class="replaytext{{$replay->id}}"> {!! $replay->replay !!}</p>
                <p class="replayalert{{$replay->id}} replayalert"></p>
                <a href="javascript:void(0)" class="btn btn-success btn-sm edit_replay_button{{$replay->id}} edit_replay_button" data-id="{{$replay->id}}" style="float: right ; display: none ; font-size: 11px ; background-color: #1a6c9f; margin-top: -5px; ">Save</a>
                <div class="tags_footer">
                    @php
                        if(!empty($replay->tags)) {

                           $readusers =  json_decode($replay->is_read) ;

                               $tags = explode(',', $replay->tags);

                                foreach($tags as  $user)
                                {
                                         $tagusers = \App\Models\User::where('deleted' , 0 )->where(['id'=>$user])->where('status' , 0)->first() ;
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

                </div>
            </div>

        </div>

    </li>

    @endforeach
    </ul>
