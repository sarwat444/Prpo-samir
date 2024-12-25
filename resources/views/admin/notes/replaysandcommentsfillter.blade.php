
<table id="filterd_table" class="table table-striped table-bordered filtered_table" cellspacing="0" width="100%">
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
                <tr>
                        @php
                            $readed   = json_decode($note->readby) ;
                        @endphp

                        @if(!empty($note->readby) && in_array(auth::user()->id , $readed ) && $note->status != 1 )

                                    <td>
                                        <label class="form-checkbox-label">
                                            <input name="completed" class="form-checkbox-field deletecomment" value="0" type="checkbox" checked data-id="{{$note->id}}"  />
                                            <i class="form-checkbox-button"></i>
                                        </label>


                                    </td>
                            @else
                            <td>

                                <label class="form-checkbox-label">
                                    <input name="completed" class="form-checkbox-field deletecomment" value="1" type="checkbox" data-id="{{$note->id}}"  />
                                    <i class="form-checkbox-button"></i>
                                </label>

                            </td>

                     @endif



                    <td>
                        @if($note->done == 1)
                            <span class="badge rounded-pill bg-primary">Erledigt</span>
                        @endif
                        {!!$note->comment!!}

                    </td>
                    <td>

                        <p class="addedby_id">{{$note->id}} </p>
                        @if(!empty($note->added_by))
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
                        <i class="fa fa-list  btn-task-popup btn-task-comments2"   data-id="{{$note->task_id}}" data-comment="{{$note->id}}" data-ergite="@if($note->done == 1 ) 1 @else 0 @endif"></i>
                    </td>
                </tr>


    @endforeach


    @foreach($replays_arr as $note)
                <tr>
                        @php
                            $readed   = json_decode($note->is_read) ;
                        @endphp
                            @if(!empty($note->is_read) && in_array(auth::user()->id , $readed ) )
                                    <td>
                                        <label class="form-checkbox-label">
                                            <input name="completed" class="form-checkbox-field checkreplay" value="0" type="checkbox" checked data-id="{{$note->id}}"  />
                                            <i class="form-checkbox-button"></i>
                                        </label>
                                    </td>
                            @else
                            <td>
                                <label class="form-checkbox-label">
                                    <input name="completed" class="form-checkbox-field checkreplay" value="1" type="checkbox" data-id="{{$note->id}}"  />
                                    <i class="form-checkbox-button"></i>
                                </label>
                            </td>

                           @endif

                    <td>
                        <div class="replay_text">
                            @if($note->comment->done == 1)
                                <span class="badge rounded-pill bg-primary">Erledigt</span>
                            @endif
                                {!!$note->replay!!}
                        </div>
                    </td>
                    <td>

                        <p class="addedby_id">{{$note->id}}</p>
                        @if(!empty($note->added_by_id))
                            @if(file_exists(public_path().'/assets/images/users/'.$note->user->image))
                                <img src="{{asset('public/assets/images/users/'.$note->user->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member"> <p>{{$note->user->first_name}}</p>
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
                        <i class="fa fa-list  btn-task-replaycomment"  data-id="{{$note->task_id}}" data-comment="{{$note->comment_id}}"     data-done="@if(!empty($note->comment)){{$note->comment->done}}@endif"    data-replay="{{$note->id}}"></i>
                    </td>
                </tr>


    @endforeach
    </tbody>
</table>



