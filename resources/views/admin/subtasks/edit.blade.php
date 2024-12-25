<form id="create-category" action="{{route('admin.subtasks.update',$data->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
   <div class="form-group">
     <label>Task Title</label>
      <input type="text" name="subtask_title" value="{{$data->subtask_title}}" class="form-control">
   </div>

   <div class="form-group">
     <label> Task</label>
     <select class="selectpicker form-control" id="task_id" name="task_id" data-size="5" >

          <option value="">Select Task</option>

           @foreach ($tasks as $key => $task)
             <option value="{{$task->id}}"  @if($data->task_id == $task->id ) selected @endif> {{$task->task_title }} </option>
           @endforeach

      </select>
   </div>

   <div class="form-group">
     <label>Responsible For Task</label>
     <select class="selectpicker form-control" id="subtask_user_id" name="subtask_user_id" data-size="5" >

          <option value="">Select User</option>

           @foreach ($users as $key => $user)
             <option value="{{$user->id}}" @if($data->subtask_user_id == $user->id ) selected @endif > {{$user->user_name }} </option>
           @endforeach

      </select>
   </div>

   <div class="form-group">
     <label> Start Date </label>
     <input type="date" class="form-control" value="{{$data->subtask_start_date}}" name="subtask_start_date" >
   </div>
   <div class="form-group">
     <label> Due Date </label>
     <input type="date" class="form-control" value="{{$data->subtask_due_date}}"  name="subtask_due_date" >
   </div>

   <button type="submit" class="btn btn-primary"> Update</button>

</form>
