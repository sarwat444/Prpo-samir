@extends('layouts.admin')
@section('css')
<!--  BEGIN CUSTOM STYLE FILE  -->
<link href="{{asset('assets/admin/assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/assets/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
  <div class="layout-px-spacing">
    <div class="row layout-top-spacing" id="cancel-row">
      <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
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
        <div class="alert alert-danger error" style="display:none;">

        </div>
        <div class="alert alert-success success" style="display:none;">

        </div>
       <div class="table-responsive mb-4 mt-4 images_view">
            <table id="tasks" class="table table-hover" style="width:100%">
              <thead>
                  <tr>
                       <th>Task Title</th>
                       <th>Task Desc</th>
                       <th>Task Category</th>
                       <th>Task Responsible</th>
                       <th>Task Added By</th>
                       <th>Task Status</th>
                       <th>Task Priority</th>
                       <th>Task Start Date</th>
                       <th>Task Due Date</th>
                       <th>Actions</th>
                  </tr>
              </thead>
              <tbody>
              @if(!empty($datas))
                <?php foreach ($datas as $key => $data): ?>
                  <tr>
                    <td>{{$data->task_title}}</td>
                    <td>{{$data->task_desc}}</td>
                    <td>{{!empty($data->category->category_name) ? $data->category->category_name :' ' }}</td>
                    <td>{{!empty($data->responsible->user_name) ? $data->responsible->user_name : ' '}}</td>
                    <td>{{!empty($data->added_by->user_name) ? $data->added_by->user_name :' ' }}</td>
                    <td>{{$data->task_status}}</td>
                    <td>{{$data->task_priority}}</td>
                    <td>{{$data->task_start_date}}</td>
                    <td>{{$data->task_due_date}}</td>
                    <td>
                      <button class="btn btn-success btn-edit-task"  data-id=" {{ $data -> id }} " >   Edit  </button>
                      <a href="javascript:;" class="btn btn-danger" data-id="{{ $data->id }}" style="color:#fff;">delete</a>
                    </td>
                  </tr>
              <?php endforeach; ?>
                @endif
              </tbody>

            </table>
        </div>
    </div>
</div>

  </div>

  </div>
<!--  END CONTENT AREA  -->

<!-- Modal -->
<div class="modal fade" id="EditTaskModal" tabindex="-1" role="dialog" aria-labelledby="EditTaskModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content edit_task_modal">

     </div>
 </div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function () {
  $(document).on('click', '.btn-edit-task', function (event) {
    //  alert('hello');
    event.preventDefault();
                var id = $(this).data('id');

                  $.ajax({

                      type: "post",
                      url: "{{route('admin.tasks.edit')}}", // need to create this post route
                      data: {id : id , _token : '{{ csrf_token() }}'},
                      cache: false,
                      success: function (data) {


                           $('#EditTaskModal').modal('show');
                            $(".edit_task_modal").html(data);
                      },
                      error: function (jqXHR, status, err) {


                      },

                 });
  });

    // Delete Category

   $(document).on('click','.btn-danger' ,  function (e) {
           if (!confirm("Are You Sure You Will Delete This Record")) {
               e.preventDefault();
               return false;
           }

            var selector = $(this);
           var id = $(this).data('id');



           $.ajax({
               type: 'POST',
               url: '{{ route('admin.tasks.delete') }}',
               data: {id: id, _token: '{{ csrf_token() }}'},
               success: function (data) {
                 if(data.status == true) {
                 selector.closest('tr').hide('slow');
                 $('.error').css('display','none');
                 $('.success').css('display','block');
                 $('.success').html(data.msg);
               }else {
                 $('.error').css('display','block');
                 $('.success').css('display','none');
                 $('.error').html(data.msg);
               }
               }
           });
       });
     });
</script>
@stop
