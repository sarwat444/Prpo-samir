@foreach($task->un_completed_subtasks as $subtask)
  <div id="sub{{$subtask->id}}">
  <li @if($subtask->subtask_status != 0) class="task  ui-state-default completed"   @else class="task  ui-state-default"  @endif  data-id="{{$subtask->id}}" id="subtask{{$subtask->id}}">

         <i class="material-icons btn-remove unselectable" data-id="{{$subtask->id}}">remove_circle</i>
         <i class="material-icons unselectable btn-drag">drag_indicator</i>

          <input class="taskched change_status check{{$subtask->id}}" data-id="{{$subtask->id}}" type="checkbox" @if($subtask->subtask_status != 0) checked  @else  ' '  @endif >
        <span class="description desc" data-id="{{$subtask->id}}" contenteditable="true">{!!$subtask->subtask_title!!}</span>
        <!-- <input type="date" class="date dte" data-id="{{$subtask->id}}" value="{{$subtask->subtask_due_date}}"> -->




        <div class="test">
        <div class="calender" >
               <label>@if(  !empty($subtask->subtask_due_date) &&  date('d.m.Y', strtotime($subtask->subtask_due_date)) !='01.01.1970' )

                            <script>
                              $("#subtask{{$subtask->id}} .ui-datepicker-trigger").css('visibility','hidden');
                            </script>
                            <p class="date_text">  {{date('d.m.Y', strtotime($subtask->subtask_due_date))}}</p>

                               @else
                               <script>
                                 $("#subtask{{$subtask->id}} .ui-datepicker-trigger").css('visibility','visible');
                               </script>
                   @endif

                 </label>
               <input type="hidden" class="hiddenInput date dte"  data-id="{{$subtask->id}}" value="{{$subtask->subtask_due_date}}"/>
        </label>
        </div>
      </div>


        <select class="slick{{$subtask->id}}"  data-id="{{$subtask->id}}" name="TaskResponsiple" >
                           <option  data-imagesrc="{{asset('public/assets/images/person.png')}}"> </option>
                           @foreach($users as $user)
                             <option value="{{$user->id}}" data-description="{{$subtask->id}}"  data-imagesrc="{{asset('public/assets/images/users/'.$user->image)}}" @if($subtask->subtask_user_id == $user->id ) selected="selected" @endif></option>
                           @endforeach
        </select>

        <input type="hidden" value="{{$subtask->id}}" class="testinput" data-id="{{$subtask->id}}" />
        <script>

                          $( ".testinput" ).each(function( index, elem ) {

                             $z = $(this).val();
                            $('.slick'+$z).ddslick({
                            onSelected: function(selectedData)
                            {

                                     var resp_val =   selectedData.selectedData.value  ;
                                     var  subtask_id  =  selectedData.selectedData.description;


                                     $.ajax({
                                     type: "POST",
                                     url: '{{route('admin.subtasks.updatefielddd')}}', // need to create this post route
                                     data: {subtask_id : subtask_id  ,  resp_val : resp_val , _token : '{{ csrf_token() }}'},
                                     cache: false,
                                     success: function (data) {
                                        // console.log('done');

                                     },
                                     error: function (jqXHR, status, err) {
                                     },
                                   });


                            }

                       });

});

        </script>




      </li>
      </div>
    @endforeach
