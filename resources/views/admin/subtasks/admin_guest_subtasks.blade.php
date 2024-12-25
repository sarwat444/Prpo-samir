@if(!empty($user_subtasks))

@if($gender == 'list')

    <div class="todoslist" style="display:block;">
@else
      <div class="todoslist" style="display:none;">
@endif
          <th>{{__('messages.Unteraufgabe')}} </th>
          <th>{{__('messages.Post-it')}} </th>
          <th>{{__('messages.Kategorie')}}</th>
          <th> {{__('messages.Hinzugefügt_von')}}</th>
          <th> {{__('messages.Erstellt_am')}} </th>
          <th>{{__('messages.Erledigt_am')}} </th>
          <th> {{__('messages.Falligkeitsdatum')}}  </th>
<div class="row task">
   <div class="col-md-1">

        Status
   </div>
   <div class="col-md-3">
      <p> {{__('messages.Unteraufgabe')}}  </p>
  </div>
    <div class="col-md-2">
       <p> {{__('messages.Post-it')}} </p>
   </div>

   <div class="col-md-1">
      <p >{{__('messages.Kategorie')}} </p>
  </div>
  <div class="col-md-1">
        <p>
            {{__('messages.Hinzugefügt_von')}}
        </p>
  </div>
  <div class="col-md-1">
        <p>
            {{__('messages.Erstellt_am')}}
        </p>
    </div>
 <div class="col-md-1">
       <p>
           {{__('messages.Erledigt_am')}}
       </p>
   </div>

    <div class="col-md-1">
       <p>
            {{__('messages.Falligkeitsdatum')}}
         </p>
   </div>

   <div class="col-md-1">
      <p>
       Details
        </p>
  </div>
</div>


 @foreach($user_subtasks as $subtask)
   <div class="row task">
      <div class="col-md-1">

         @if($subtask->subtask_status == 1)
               <label class="form-checkbox-label">
                    <input name="completed" class="form-checkbox-field change_statusss" data-id="{{$subtask->id}}"  type="checkbox" value="1" checked  />
                    <i class="form-checkbox-button"></i>
              </label>


         @else

          <label class="form-checkbox-label">
                    <input name="completed" class="form-checkbox-field change_statusss" data-id="{{$subtask->id}}"  type="checkbox" value="0"  />
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
       @if(!empty($subtask->added_by))

       @if(file_exists(public_path().'/assets/images/users/'.$subtask->added_by->image))
          <img src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member">
       @else
            <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
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
         <p><i class="fa fa-eye btn-task-popup" data-id="{{$subtask->task->id}}"></i></p>
     </div>



   </div>
   @endforeach

 </div>

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
                             <img src="{{asset('public/assets/images/users/'.$subtask->responsible->image)}}" alt="member">
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
                     <img src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member">
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
@endforeach



</div>

</div>


</div>
 <!-- End Box Todos -->



 <script>



 	$(document).ready(function(){

   $('.change_statusss').each(function(){
 $(this).on('click',function(){
      var id = $(this).data('id');
       var dta = $(this).text();
      //alert(dta);
       var task_id = $("#task_id").val();
       //
       $.ajax({


            type: 'POST',
            url: '{{ route('admin.subtasks.update_status') }}',
            data: {id: id,task_id:task_id, _token: '{{ csrf_token() }}'},
            success: function (data) {
                           $('#task'+task_id).html('');
               $('#task'+task_id).html(data.options);
            }
        });
});
});
});
 </script>
