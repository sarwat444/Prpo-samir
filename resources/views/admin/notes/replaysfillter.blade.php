
<table id="filterd_table" class="table table-striped table-bordered filtered_table" cellspacing="0" width="100%"   data-orderable="3" data-orderable_type="desc">
    <thead>
    <tr>
        <th>{{__('messages.hide')}}</th>
        <th>{{__('messages.comments')}}</th>
        <th>{{__('messages.created_by')}}</th>
        <th>{{__('messages.created_at')}}</th>
        <th>{{__('messages.details')}} </th>
    </tr>
    </thead>
    <tbody class="tasks user_subtasks commentslist">

    @foreach($replays_arr as $replay)
        @if(!empty($replay->comment))
            @php
                $readed   = json_decode($replay->is_read) ;
            @endphp
            <tr>
                @if(empty($replay->is_read) ||!in_array(auth::user()->id , $readed))
                    <td>
                        <label class="form-checkbox-label">
                            <input name="completed" class="form-checkbox-field checkreplay" value="1"
                                   type="checkbox" data-id="{{$replay->id}}"/>
                            <i class="form-checkbox-button"></i>
                        </label>
                    </td>
                @else
                    <td>
                        <label class="form-checkbox-label">
                            <input name="completed" class="form-checkbox-field checkreplay" value="0"
                                   type="checkbox" data-id="{{$replay->id}}" checked/>
                            <i class="form-checkbox-button"></i>
                        </label>

                    </td>
                @endif
                <td class="replay_text">
                    @if($replay->comment->done == 1)
                        <span class="badge rounded-pill bg-primary">Erledigt</span>
                    @endif {!!$replay->replay!!}
                </td>
                <td>
                    <p class="addedby_id">{{$replay->id}}} </p>
                    @if(!empty($replay->added_by_id))
                        @if(file_exists(public_path().'/assets/images/users/'.$replay->user->image))
                            <img src="{{asset('public/assets/images/users/'.$replay->user->image)}}"
                                 style="height:25px;width:25px;border-radius:50%;" alt="member">
                            <p>{{$replay->user->first_name}}</p>
                        @else
                            <img src="https://source.unsplash.com/user/c_v_r"
                                 style="width:40px;height:40px;border-radius:50%;">
                        @endif
                    @endif
                </td>
                <td>
                    <p class="sortdate">{{$replay->created_at}}</p>
                    {{ date('d.m.Y', strtotime($replay->created_at->addhours(2)))}}

                </td>
                <td data-order="1000">
                    <i class="fa fa-list  btn-task-replaycomment" data-id="{{$replay->task_id}}"
                       data-comment="{{$replay->comment_id}}" data-replay="{{$replay->id}}"
                       data-done="{{$replay->comment->done}}"></i>
                </td>
            </tr>
        @endif
    @if(!empty($replay->comment))

    @php
     $readed   = json_decode($replay->is_read) ;

     $done_comments =   json_decode($replay->comment->readby) ;

   @endphp

   @if(empty($replay->is_read) ||!in_array(auth::user()->id , $readed))

                 <tr>
                                 @if(empty($done_comments) || !in_array(auth::user()->id  , $done_comments))

                                 <td>

                                   <label class="form-checkbox-label">
                                       <input name="completed" class="form-checkbox-field checkreplay" value="1" type="checkbox" data-id="{{$replay->id}}"  />
                                       <i class="form-checkbox-button"></i>
                                   </label>
                                </td>



                                 @else

                                 <td>


                                     <label class="form-checkbox-label">
                                         <input name="completed" class="form-checkbox-field checkreplay" value="0" type="checkbox" data-id="{{$replay->id}}"  checked />
                                         <i class="form-checkbox-button"></i>
                                     </label>

                                 </td>


                                 @endif
                     <td class="replay_text">
                         @if($replay->comment->done == 1)
                             <span class="badge rounded-pill bg-primary">Erledigt</span>
                         @endif {!!$replay->replay!!}
                     </td>
                     <td>
                         <p class="addedby_id">{{$replay->id}}} </p>
                         @if(!empty($replay->added_by_id))
                                             @if(file_exists(public_path().'/assets/images/users/'.$replay->user->image))
                                                 <img src="{{asset('public/assets/images/users/'.$replay->user->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member"> <p>{{$replay->user->first_name}}</p>
                                             @else
                                                 <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                                             @endif
                         @endif
                     </td>
                     <td>
                         <p class="sortdate" style="visibility:hidden;height:0 ;margin:0">{{$replay->created_at}}</p>
                         {{ date('d.m.Y', strtotime($replay->created_at->addhours(2)))}}

                     </td>
                     <td data-order="1000">
                     <i class="fa fa-list  btn-task-replaycomment"  data-id="{{$replay->task_id}}" data-comment="{{$replay->comment_id}}"  data-replay="{{$replay->id}}" data-done="{{$replay->comment->done}}"></i>
                     </td>
          </tr>


 @endif

@else

     <tr>



         @if(empty($done_comments) || !in_array(auth::user()->id  , $done_comments))

         <td>

           <label class="form-checkbox-label">
               <input name="completed" class="form-checkbox-field checkreplay" value="1" type="checkbox" data-id="{{$replay->id}}"  />
               <i class="form-checkbox-button"></i>
           </label>
        </td>



         @else

         <td>


             <label class="form-checkbox-label">
                 <input name="completed" class="form-checkbox-field checkreplay" value="0" type="checkbox" data-id="{{$replay->id}}"  checked />
                 <i class="form-checkbox-button"></i>
             </label>

         </td>


         @endif


         <td class="replay_text">

             @if(!empty($replay->comment) && $replay->comment->done == 1)
                 <span class="badge rounded-pill bg-primary">Erledigt</span>
             @endif
                 {!!$replay->replay!!}

         </td>
         <td>
           <p class="addedby_id">{{$replay->id}}} </p>
           @if(!empty($replay->added_by_id))
                                       @if(!empty($replay->user) &&file_exists(public_path().'/assets/images/users/'.$replay->user->image))
                                          <img src="{{asset('public/assets/images/users/'.$replay->user->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member"> <p>{{$replay->user->first_name}}</p>
                                       @else
                                            <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                                       @endif
                 @endif
         </td>
         <td>

              <p class="sortdate"  style="visibility:hidden;height:0 ;margin:0">{{$replay->created_at}}</p>
             {{ date('d.m.Y', strtotime($replay->created_at->addhours(2)))}}
         </td>
         <td data-order="1000">
         <i class="bi bi-card-list  btn-task-replaycomment"  data-id="{{$replay->task_id}}" data-comment="{{$replay->comment_id}}"  data-replay="{{$replay->id}}" data-done="@if(!empty($replay->comment)){{$replay->comment->done}} @endif"></i>
         </td>
     </tr>


@endif


>>>>>>> de7fae0441c693317e2898075fce9ef255a701ed
    @endforeach
    </tbody>
</table>



