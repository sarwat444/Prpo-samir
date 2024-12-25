@if(!empty($user_subtasks))

<div class="row task">
   <div class="col-md-1">
        Status
   </div>
   <div class="col-md-3">
      <p> {{__('messages.Unteraufgabe')}} </p>
  </div>
    <div class="col-md-2">
       <p> {{__('messages.Post-it')}} </p>
   </div>

   <div class="col-md-1">
      <p data-id=""> {{__('messages.Kategorie')}} </p>
  </div>
  <div class="col-md-1">
        <p class="sub-date">
         <span class="last-updates" >  {{__('messages.Erstellt_am')}}  </span>
        </p>
    </div>
 <div class="col-md-1">
       <p class="sub-date">
        <span class="last-updates" >  {{__('messages.Erledigt_am')}} </span>
       </p>
   </div>

    <div class="col-md-2">
       <p class="sub-date">
      <span >{{__('messages.Falligkeitsdatum')}}  </span>
         </p>
   </div>

   <div class="col-md-1">
      <p class="sub-date">
     <span >Details</span>
        </p>
  </div>
</div>


 @foreach($user_subtasks as $subtask)
   <div class="row task">
      <div class="col-md-1">

         @if($subtask->subtask_status == 1)
               <label class="form-checkbox-label">
                    <input name="completed" class="form-checkbox-field change_status" data-id="{{$subtask->id}}"  type="checkbox" value="1" checked  />
                    <i class="form-checkbox-button"></i>
              </label>


         @else

          <label class="form-checkbox-label">
                    <input name="completed" class="form-checkbox-field change_status" data-id="{{$subtask->id}}"  type="checkbox" value="0"  />
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
           <p class="sub-date">

              {{ date('d.m.Y', strtotime($subtask->created_at->addhours(2)))}}  </p>
    </div>
    <div class="col-md-1">
          <p class="sub-date">

           @if(!empty($subtask->subtask_completed_at)) {{ date('d.m.Y', strtotime($subtask->subtask_completed_at))}} @else -- @endif  </p>
      </div>

       <div class="col-md-2">
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
 @endif

<script>
 $('.change_status').on('click',function(){
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

</script>
