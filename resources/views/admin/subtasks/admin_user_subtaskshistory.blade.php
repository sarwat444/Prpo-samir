<table  class="filtered_table table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Status</th>
        <th>{{__('messages.subtask')}}</th>
        <th>{{__('messages.category')}}</th>
        <th>{{__('messages.created_by')}} </th>
        <th> {{__('messages.time')}} </th>
        <th>{{__('messages.details')}}</th>
    </tr>
    </thead>
    <tbody  class="tasks  user_subtasks" id="bodycontent">
     @foreach($user_subtasks as $subtask)
               @if($subtask->history->count() != 0)
                   <tr>
                      <td>

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

                      </td>

                      <td class="col-md-3">
                         <p> {!!$subtask->subtask_title!!} </p>
                     </td>


                      <td class="col-md-3">
                         <p>@if(!empty($subtask->task->category->category_name))    {{$subtask->task->category->category_name }}     @else "No Category"  @endif</p>
                     </td>

                     <td class="col-md-2">
                       @if(!empty($subtask->added_by))

                       @if(file_exists(public_path().'/assets/images/users/'.$subtask->added_by->image))
                          <img src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member">
                       @else
                            <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                       @endif
                       @endif
                    </td>
                       <td>
                            <?php
                               $timeonsecondes = 0 ;
                             ?>

                               @foreach($subtask->history as $history)
                                      <?php $timeonsecondes += $history->Time ;  ?>
                                @endforeach
                                <?php
                                $hours = floor($timeonsecondes / 3600);
                                $mins = floor($timeonsecondes / 60 % 60);
                                $secs = floor($timeonsecondes % 60);
                                $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

                                if($hours=='00'  && $mins =='00'  && $secs== '00')
                                {
                                echo "<p class='totaltimedanger'>". 'kein Zeitrekord' ."</p>" ;
                                }
                                else
                                {
                                   echo "<p class='totaltime'>".  $timeFormat ."</p>" ;
                                }
                                 ?>
                      </td>
                       <td class="col-md-1 text-center">
                           <i class="fa fa-list  historydescription" data-id="{{$subtask->id}}"  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
                       </td>
                   </tr>
               @endif
         @endforeach
    </tbody>
</table>

<script>
    $('.historydescription').each(function(){
        $(this).on('click' , function(){
            $('.modal-dialog .historybody .tablecontent').html('');
            var subtask =  $(this).data('id') ;
            var end_due_date = $('.end_due_date').val()
            var start_due_date = $('.start_due_date').val() ;
            $.ajax({
                type: "POST",
                url:   '{{route('admin.subtasks.historydescription')}}',   // need to create this post route
                data: {task_id:subtask , start_due_date:start_due_date , end_due_date: end_due_date , _token: '{{ csrf_token() }}'},
                cache: false,
                success: function (data) {
                    //  $('.modal-dialog .historybody').html('');
                    $('.modal-dialog .historybody .tablecontent').html(data);
                },
                error: function (jqXHR, status, err) {

                },
            });

        })
    });
</script>
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

