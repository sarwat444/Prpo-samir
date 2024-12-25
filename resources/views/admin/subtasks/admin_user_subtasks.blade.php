@if(!empty($user_subtasks))

@if($gender == 'list')
    <div class="todoslist" style="display:block;">
@else
      <div class="todoslist" style="display:none;">
@endif
<table class="tabele-striped filtered_table" >
   <thead>
       <tr>
           <th>Status</th>
           <th>{{__('messages.Unteraufgabe')}} </th>
           <th>{{__('messages.Post-it')}} </th>
           <th>{{__('messages.Kategorie')}}</th>
           <th> {{__('messages.Hinzugefügt_von')}}</th>
           <th> {{__('messages.Erstellt_am')}} </th>
           <th>{{__('messages.Erledigt_am')}} </th>
           <th> {{__('messages.Falligkeitsdatum')}}  </th>
           <th>Timer </th>
           <th>Details</th>
       </tr>
   </thead>
   <tbody id="bodycontent">
       @foreach($user_subtasks as $subtask)
         <tr class="row1" data-id="{{$subtask->id}}">
              <td>
                 @if($subtask->subtask_status == 1)
                       <label class="form-checkbox-label">
                            <input name="subtask_status" class="form-checkbox-field change_subtask_status" data-id="{{$subtask->id}}"  type="checkbox" value="1" checked  />
                            <i class="form-checkbox-button"></i>
                      </label>
                 @else

                  <label class="form-checkbox-label">
                            <input name="subtask_status" class="form-checkbox-field change_subtask_status" data-id="{{$subtask->id}}"  type="checkbox" value="0"  />
                            <i class="form-checkbox-button"></i>
                      </label>
                 @endif
              </td>
              <td>
                {!!$subtask->subtask_title!!}
              </td>
              <td>
                  <p data-id="{{$subtask->id}}">  @if(!empty($subtask->task->task_title))    {{$subtask->task->task_title }}     @else "No Task"  @endif </p>
              </td>
              <td>
                 <p>@if(!empty($subtask->task->category->category_name))    {{$subtask->task->category->category_name }}     @else "No Category"  @endif</p>
              </td>
              <td>
               @if(!empty($subtask->added_by))
                   @if(file_exists(public_path().'/assets/images/users/'.$subtask->added_by->image))
                      <img src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member">
                   @else
                    <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                   @endif
               @endif
            </td>
              <td>
                      <p class="sub-date">
                      {{ date('d.m.Y', strtotime($subtask->created_at->addhours(2)))}}
                      </p>
            </td>
              <td>
                  <p class="sub-date">
                    @if(!empty($subtask->subtask_completed_at)) {{ date('d.m.Y', strtotime($subtask->subtask_completed_at))}} @else -- @endif
                   </p>
           </td>
              <td>
            <p class="sub-date">
                   @if(!empty($subtask->subtask_due_date))
                      {{ date('d.m.Y', strtotime($subtask->subtask_due_date))}}
                   @endif
            </p>
      </td>
              <td>
         <!-- Start Timer  -->
                  <section id="stopWatch">
                      <p class="timer{{$subtask->id}}" style="    font-weight: 500;
                                                                    font-size: 13px;
                                                                    color: #fff;
                                                                    background-color:#eeeeee;
                                                                    padding: 4px;
                                                                    border-radius: 4px;
                                                                    width: 100%;
                                                                    margin: 0px auto 10px;
                                    }"> 00:00:00 </p>
                      <i class="start{{$subtask->id}} fa fa-play  start" data-id="{{$subtask->id}}" data-toggle="play"></i>
                      @if($subtask->timer == 1 )
                          <i class="stop{{$subtask->id}} fa fa-stop  stop stotime_con" data-id="{{$subtask->id}}" data-toggle="stop" ></i>
                          <i class="pause{{$subtask->id}} fa fa-pause  pause" data-id="{{$subtask->id}}" data-toggle="pause" ></i>
                          <i class="continue{{$subtask->id}} fa fa-continue bi bi-play-circle" hidden="" data-id="62"></i>
                      @endif

                      <p class="fulltime{{$subtask->id}} fulltime"></p>
                  </section>
         <!-- End Timer -->
         </td>
             <td>  <p><i class="fa fa-list btn-task-popup" data-id="{{$subtask->task_id}}"></i></p> </td>
        </tr>
     @endforeach
  </tbody>
</table>
 @endif
 <!-- BOx TOdos -->
@if($gender == 'box')
<div class="todosbox" style="display:block;">
@else
<div class="todosbox" style="display:none;">
@endif
<div class="cards" id="cards">
<div class="overlay"></div>

 <div class="row sortable-cards" id="shuffle">

@foreach($user_subtasks as $subtask)
    @if(!empty( $subtask->task->category))
    <div class="col-md-3 btn-task-popup sortable-divs mix ui-state-default {{$subtask->task->category->category_name}}" data-id="{{$subtask->task->id}}" >
     <div class="card sort" @if(!empty($subtask->task->category->category_color)) style="background-color:{{$subtask->task->category->category_color}}" @endif >
        <div class="card-contents">
            <div class="top-bar">
                <div class="row">
                <div class="col-md-3">
                  <p>{{!empty($subtask->task->category->category_name) ? $subtask->task->category->category_name :' ' }}</p>
                </div>

                <div class="col-md-5">

                          @if(!empty($subtask->responsible))

                              @if(file_exists(public_path().'/assets/images/users/'.$subtask->task->responsible->image))
                                 <img src="{{asset('public/assets/images/users/'.$subtask->responsible->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member">
                              @else
                                   <img src="https://source.unsplash.com/user/c_v_r">
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
                         <img src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}" alt="member" style="height:25px;width:25px;border-radius:50%;">
                      @else
                           <img src="https://source.unsplash.com/user/c_v_r">
                      @endif

                      @endif
                       <span>  Erstellt von </span></div>
                     <div class="col-md-6">
                          <p>DeadLine</p>
                         <p> {{ date('d.m.Y', strtotime($subtask->task->task_due_date))}} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @endif
 @endforeach
</div>
</div>
</div>
 <script>
 	$(document).ready(function(){
        $('.change_subtask_status').each(function(){
            $(this).unbind().on('click',function(){
                var id = $(this).data('id');
                var dta = $(this).text();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.subtasks.updatesubtask_status') }}',
                    data: {id: id, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                    }
                });
            });
        });
});
    </script>
