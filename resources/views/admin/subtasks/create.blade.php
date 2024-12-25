@extends('layouts.admin')
@section('content')
<!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
      <div class="container">
          <div class="container">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @include('admin.includes.alerts.success')
            @include('admin.includes.alerts.errors')
           <div class="row layout-top-spacing">
             <div id="basic" class="col-lg-12 layout-spacing">
              <div class="statbox widget box box-shadow">
                  <div class="widget-header">
                      <div class="row">
                          <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                              <h4> Add New SubTask </h4>
                          </div>
                      </div>
                  </div>
              <div class="widget-content widget-content-area">
                <form id="create-subtask" action="{{route('admin.subtasks.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                   <div class="form-group">
                     <label>SubTask Title</label>
                      <input type="text" name="subtask_title" class="form-control">
                   </div>

                   <div class="form-group">
                     <label> Task</label>
                     <select class="selectpicker form-control" id="task_id" name="task_id" data-size="5" >

                          <option value="">Select Task</option>

                           @foreach ($tasks as $key => $task)
                             <option value="{{$task->id}}"> {{$task->task_title }} </option>
                           @endforeach

                      </select>
                   </div>

                   <div class="form-group">
                     <label>Responsible For SubTask</label>
                     <select class="selectpicker form-control" id="subtask_user_id" name="subtask_user_id" data-size="5" >

                          <option value="">Select User</option>

                           @foreach ($users as $key => $user)
                             <option value="{{$user->id}}"> {{$user->user_name }} </option>
                           @endforeach

                      </select>
                   </div>

                   <div class="form-group">
                     <label> Start Date </label>
                     <input type="date" class="form-control" name="subtask_start_date" value="">
                   </div>
                   <div class="form-group">
                     <label> Due Date </label>
                     <input type="date" class="form-control" name="subtask_due_date" value="">
                   </div>

                  <button type="submit" class="btn btn-primary"> Save</button>

              </form>
            <div class="code-section-container show-code">
             <div class="code-section text-left">
           </div>
              </div>
        </div>
        </div>
        </div>
        </div>
       </div>
      </div>
     </div>
@endsection
