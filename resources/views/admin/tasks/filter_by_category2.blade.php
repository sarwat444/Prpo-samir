@if(!empty($tasks))

             @foreach ($tasks as $key => $task)


                <div class="col-md-3  sortable-divs mix ui-state-default {{$task->category->category_name}}" data-id="{{$task->id}}" id="task{{$task->id}}">
                 <div class="card sort" @if(!empty($task->category->category_color) && !empty($task->second_category->category_color)) style="background:linear-gradient(0deg, {{$task->category->category_color }} 50%,  {{$task->second_category->category_color}} 50%);" @elseif(!empty($task->category->category_color)) style="background-color:{{$task->category->category_color}}"  @endif >
                    <div class="card-contents">
                        <div class="top-bar">
                            <div class="row">
                            <div class="col-md-5">
                              <p>{{!empty($task->category->category_name) ? $task->category->category_name :' ' }} {{!empty($task->second_category->category_name) ? '/'.$task->second_category->category_name :' ' }}</p>
                            </div>
                            <div class="col-md-4">
                             <p> {{$task->completed_subtasks->count()}} /{{$task->subtasks->count()}}</p>
                            </div>
                            <div class="col-md-3">

                                      @if(!empty($task->responsible))
                                      @if(file_exists(public_path().'/assets/images/users/'.$task->responsible->image))
                                         <img src="{{asset('public/assets/images/users/'.$task->responsible->image)}}" alt="member">
                                      @else
                                           <img src="https://source.unsplash.com/user/c_v_r">
                                      @endif

                                        @endif

                              </div>
                            </div>
                        </div>
                        <div class="middle-content">
                             <h3>{!!substr($task->task_title,0,70)!!}</h3>
                              <br>
                            <div class="members">
                                 <ul>

                                     @php
                                          $teamids = \App\Models\TaskTeam::where('task_id' , $task->id)->pluck('user_id');
                                          $teams   =  \App\Models\User::whereIn('id',$teamids)->get();
                                     @endphp

                                      @if(!empty($teams))
                                          @foreach ($teams->take(4) as $key => $team)
                                            <li>
                                              @if(file_exists(public_path().'/assets/images/users/'.$team->image))
                                                 <img src="{{asset('public/assets/images/users/'.$team->image)}}" alt="member">
                                              @else
                                                   <img src="https://source.unsplash.com/user/c_v_r">
                                              @endif

                                            </li>
                                          @endforeach
                                       @endif

                                         @if(count($teams) > 4)
                                         ....
                                       @endif

                                    <button class="btn btn-default btn-task-popup" data-id="{{$task->id}}" ><i class="bi bi-plus-circle"></i></button>
                                 </ul>

                            </div>
                        </div>
                        <div class="button-bar">
                            <div class="row">

                                 <div class="col-md-6">
                                  @if(!empty($task->added_by))
                                  @if(file_exists(public_path().'/assets/images/users/'.$task->added_by->image))
                                     <img src="{{asset('public/assets/images/users/'.$task->added_by->image)}}" alt="member">
                                  @else
                                       <img src="https://source.unsplash.com/user/c_v_r">
                                  @endif
                                  @endif
                                   <span> {{--!empty($task->added_by->user_name) ? $task->added_by->user_name :' ' --}}</span></div>
                                 <div class="col-md-6">

                                     <p> {{ date('d.m.Y', strtotime($task->task_due_date))}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>


                @endforeach
@endif
                <script>
                   $(document).ready(function () {


                           var mixer = mixitup('#shuffle');
                    });

                </script>




                <script>

$(document).ready(function(){



"use strict";

/* Start  ToDo Addition */
let wrapper = document.querySelector('.wrapper') ;
let newtodo = document.querySelector('.todo_name') ;
let todo_date = document.querySelector('.todo_date') ;
let todo_responsible = document.querySelector('.todo_responsible') ;
let addtodo = document.querySelector('.add_todo') ;
let todo = []  ;

// addtodo.addEventListener('click'  , ()=>{
//  if( newtodo.value !=''){
//   //   console.log('not empty');
//
//  //alert(todo_date.value);
//      todo.push([newtodo.value , todo_date.value  , todo_responsible.value ] ) ;
//
//  //Append Values
//
//  let newtodolist = document.createElement('div')  ;
//   newtodolist.className = 'item' ;
//         for(let i=0; i<todo.length;i++)
//         {
//              newtodolist.innerHTML = '<p>'+newtodo.value +'</p>'+ '<ul>'+'<li>'+todo_date.value + '</li><li>'  +  todo_responsible.value +'</li></ul>';
//              wrapper.appendChild(newtodolist) ;
//
//         }
//
//       if(todo.length > 0 )
//       {
//
//                  let item =  document.querySelectorAll('.item') ;
//                  let checkicone = document.createElement('i');
//                   checkicone.className = 'bi bi-check-circle' ;
//
//
//                  let trush = document.createElement('i');
//                   trush.className = 'bi bi-trash  trash' ;
//
//
//              for(let  j=0 ; j<item.length ; j++ )
//               {
//
//                    item[j].appendChild(checkicone) ;
//                    item[j].appendChild(trush) ;
//
//
//                   trush.addEventListener('click',  ()=>{
//
//                       trush.parentNode.remove();
//
//                   })
//               }
//       }
//
//
//       }
//
// });



// $('.trash').on('click',function(){
//     // alert($(this).closest('.item').data('id'));
//     // $(this).closest('.item').remove();
//
//
// });

$('.trash').on('click',function(){

       if (!confirm("Are You Sure You Will Delete This Record")) {
         e.preventDefault();
         return false;
     }

    var id = $(this).closest('.item').data('id');
    $.ajax({
         type: 'POST',
         url: '{{ route('admin.subtasks.delete') }}',
         data: {id: id, _token: '{{ csrf_token() }}'},
         success: function (data) {
              $(this).closest('.item').remove();
         }
     });
       $(this).closest('.item').remove();
 });

 $('.change_status').on('click',function(){
    var id = $(this).closest('.item').data('id');
     $.ajax({
          type: 'POST',
          url: '{{ route('admin.subtasks.update_status') }}',
          data: {id: id, _token: '{{ csrf_token() }}'},
          success: function (data) {

          }
      });

  });
// add subtask
$('#add_subtask').on('click',function(){
     //  alert('hello');
      event.preventDefault();
      var subtask_title = $("#subtask_title").val();
      var subtask_user_id = $("#subtask_user_id").find(':selected').attr('data-id');
      var subtask_start_date = $("#subtask_start_date").val();
      var subtask_due_date = $("#subtask_due_date").val();
      var task_id = $("#task_id").val();
    //  alert(subtask_title  + '  '+subtask_user_id  + '  '+subtask_start_date  + '  '+subtask_due_date  + '  '+ task_id  + '  ');
        $.ajax({

            type: "post",
            url: "{{route('admin.subtasks.store')}}", // need to create this post route
            data: {subtask_title : subtask_title , subtask_user_id : subtask_user_id , subtask_start_date:subtask_start_date , subtask_due_date:subtask_due_date , task_id:task_id, _token : '{{ csrf_token() }}'},
            cache: false,
            success: function (data) {
                //console.log('done');
                $('.wrapper').html(data.options);
            },
            error: function (jqXHR, status, err) {
            },
       });

});



 $('#edit_subtask .target').on('change',function() {

            // alert('changed!');
            var task_id = $('#task_id').val();
            var field_name  = $(this).data('name');
            var field_val = $(this).val();
            $.ajax({
            type: "post",
            url: "{{route('admin.tasks.update_field')}}", // need to create this post route
            data: {task_id : task_id  , field_name : field_name , field_val : field_val , _token : '{{ csrf_token() }}'},
            cache: false,
            success: function (data) {
              //  console.log('done');
              //  $('.wrapper').html(data.options);
                 if(data.options == 'no') {
                       $('#task'+task_id).css('display','none');
                 }else {
                   $('#task'+task_id).html('');
                   $('#task'+task_id).html(data.options);
                 }

            },
            error: function (jqXHR, status, err) {
            },
 });

 });


});




</script>
 <script>

          var show = true;

           function showCheckboxes() {
               var checkboxes =
                   document.getElementById("checkBoxes");

               if (show) {
                   checkboxes.style.display = "block";
                   show = false;
               } else {
                   checkboxes.style.display = "none";
                   show = true;
               }
           }
    </script>
            <script type="text/javascript">
      $(function () {
        var $activate_selectator = $('#activate_selectator4');
        $activate_selectator.click(function () {
          var $select = $('#select3');
          if ($select.data('selectator') === undefined) {
            $select.selectator({
              showAllOptionsOnFocus: true,
              useDimmer: true,
              searchFields: 'value text subtitle right'
            });
            $activate_selectator.val('destroy');
          } else {
            $select.selectator('destroy');
            $activate_selectator.val('activate');
          }
        });
        $activate_selectator.trigger('click');
      });
    </script>

         <script>
         /*
                     var counter = 1; //limits amount of transactions
                            function addElements() {
                                if (counter < 5) //only allows 4 additional transactions
                                {

                                    let todo_wrap =  document.getElementById('todo_wrap') ;

                                    let row = document.createElement('div');
                                    row.id = 'row';
                                    row.className = 'row';
                                    todo_wrap.appendChild(row);


                                    let cols = document.createElement('div');
                                    cols.className= 'col-md-5 subtaskform';
                                    row.appendChild(cols);


                                    let label = document.createElement('label');
                                    label.className ='new-control new-checkbox new-checkbox-rounded checkbox-success' ;
                                    cols.appendChild(label);



                                    let checkbox = document.createElement('input');
                                    checkbox.id='subtask_title'+counter;
                                    checkbox.type = 'checkbox ';
                                    checkbox.className ='new-control-input' ;
                                    label.appendChild(checkbox);


                                    let span = document.createElement('span');
                                    span.className ='new-control-indicatort' ;
                                    label.appendChild(span);


                                    let input = document.createElement('input');
                                    input.id='subtask_title'+counter;
                                    input.type = 'text ';
                                    input.name= 'subtask_title';
                                    input.className ='subtask_title' ;
                                    cols.appendChild(input);





                                   let cols2 = document.createElement('div');
                                    cols2.className= 'col-md-3 subtaskform';
                                    row.appendChild(cols2);

                                    let date = document.createElement('input');
                                    date.type = 'text';
                                    date.name= 'subtask_due_date';

                                    date.className ='dateTimeFlatpickr form-control flatpickr flatpickr-input' ;
                                    cols2.appendChild(date);


                                }

                                counter++
                                if (counter >= 6) {
                                    alert("You have reached the maximum transactions.")
                                }
                            }
                     */
                    
                     //$('.loading').fadeOut(500);
                 </script>
