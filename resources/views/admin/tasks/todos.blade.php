@if(!empty($subtasks))

   @foreach ($subtasks as $key => $subtask)
        <div class="item" data-id="{{$subtask->id}}">
         <p> {{$subtask->subtask_title}} </p>
          <ul>

            <li> {{$subtask->subtask_due_date}} </li>
            <li>{{!empty($subtask->responsible->user_name) ? $subtask->responsible->user_name : ' '}}</li>
         </ul>

          <input type="checkbox" class="change_status" @if($subtask->subtask_status == 1) checked @endif>
         <i class="bi bi-trash trash"></i>
      </div>
   @endforeach

@endif



<script>
$(document).ready(function(){
    "use strict";
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


    });

</script>
