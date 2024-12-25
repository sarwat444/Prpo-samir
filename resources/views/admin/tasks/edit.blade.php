<form id="create-category" action="{{route('admin.tasks.update',$data->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
   <div class="form-group">
     <label>Task Title</label>
      <input type="text" name="task_title" value="{{$data->task_title}}" class="form-control">
   </div>
   <div class="form-group">
     <label>Task Description</label>
      <textarea type="text" name="task_desc"  class="form-control"> {{$data->task_desc}}</textarea>
   </div>
   <div class="form-group">
     <label>Task Category</label>
     <select class="selectpicker form-control" id="task_category_id" name="task_category_id" data-size="5" >

             <option value="">Select Category</option>

           @foreach ($categories as $key => $category)


                  <option value="{{$category->id}}" @if($data->task_category_id == $category->id ) selected @endif  > {{$category->category_name }} </option>

            @endforeach

      </select>
   </div>

   <div class="form-group">
     <label>Responsible For Task</label>
     <select class="selectpicker form-control" id="task_responsible" name="task_responsible" data-size="5" >

          <option value="">Select User</option>

           @foreach ($users as $key => $user)
             <option value="{{$user->id}}" @if($data->task_responsible == $user->id ) selected @endif > {{$user->user_name }} </option>
           @endforeach

      </select>
   </div>
   <div class="form-group">
     <label>Team Members</label>
     <select class="selectpicker form-control" id="teams_id" name="teams_id[]" data-size="5" multiple>

        @php
            $team_ids = \App\Models\TaskTeam::where('task_id' , $data->id)->pluck('user_id');
            $team_ids2 = json_decode($team_ids);
        @endphp

          <option value="">Select Team Members</option>

           @foreach ($users as $key => $user)
             <option value="{{$user->id}}" @if(in_array($user->id , $team_ids2)) selected @endif> {{$user->user_name }} </option>
           @endforeach

      </select>
   </div>

   <div class="form-group">
     <label> Start Date </label>
     <input type="date" class="form-control" value="{{$data->task_start_date}}" name="task_start_date" >
   </div>
   <div class="form-group">
     <label> Due Date </label>
     <input type="date" class="form-control" value="{{$data->task_due_date}}"  name="task_due_date" >
   </div>

   <button type="submit" class="btn btn-primary"> Update</button>

</form>
