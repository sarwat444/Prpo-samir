@extends('layouts.dashboard')
@section('css')
<link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
<script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}" ></script>
<link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
<link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">
<style>
.resposiple
{
  height: 30px ;
  width: 30px ;
  border-radius: 50% ;
  margin-left: 10px ;
  border: 1px solid #eee ;
}
.sub-tasks
{
    text-align: center;
}
.commentslist p{
    font-size: 13px ;
}
#example
{
    padding: 0 !important;
}
    .addedby_id
    {
        visibility: hidden !important;
    }
</style>
@endsection
@section('title')Meine Aufgaben @endsection
@section('content')
<!--Start  Users Tasks -->
<div class="container">
    <div class="mytasks">
                    <div class="fillter comments_filter">
                                  <div class="row justify-content-center">

                                          <div class="col-md-2">
                                              <div class="datepicker" data-type="date_filter" data-gender="list">
                                                 <input  type="text"  class="start_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target" data-name="task_due_date"  name="task_due_date"  placeholder="Von">
                                              </div>
                                          </div>
                                          <div class="col-md-2">
                                              <div class="datepicker">
                                                     <input  type="text"   data-type="date_filter" data-gender="list"   class="end_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target" data-name="task_due_date"  name="task_due_date"  placeholder="An">
                                                </div>
                                          </div>
                                          <input type="hidden" name="usercomment" value="{{Auth::user()->id}}"  id="userid"/>
                                      </div>
                    </div>

<!--Start  Data table-->
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Ausblenden</th>
			<th>Kommentar</th>
			<th>Hinzugefügt von</th>
			<th>Erstellt am</th>
			<th>Details </th>
		</tr>
	</thead>
	<tbody  class="tasks user_subtasks commentslist">

                @foreach($notes as $note)



                        @if(!empty($note->readby))
                         @php
                            $readed   = json_decode($note->readby) ;

                            @endphp


                     @if(!in_array(auth::user()->id , $readed ) && $note->status != 1 )

                        		<tr>
                        			<td>
                                                  <label class="form-checkbox-label">
                                                      <input name="completed" class="form-checkbox-field deletecomment" value="0" type="checkbox" data-id="{{$note->id}}"  />
                                                      <i class="form-checkbox-button"></i>
                                                  </label>


                        			</td>
                        			<td>
                        			     {!!$note->comment!!}

                        			</td>
                        			<td>
                        			          @if(!empty($note->comment_added_by))
                                                          @if(file_exists(public_path().'/assets/images/users/'.$note->added_by->image))
                                                             <img src="{{asset('public/assets/images/users/'.$note->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member"> <p class="addedby_id">{{$note->added_by->first_name}}</p>
                                                          @else
                                                               <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                                                          @endif
                                              @endif
                        			</td>
                        			<td>
                        			    {{ date('d.m.Y', strtotime($note->created_at->addhours(2)))}}
                        			</td>
                        			<td data-order="1000">
                        			    <i class="bi bi-card-list btn-task-popup"  data-id="{{$note->task_id}}"></i>
                        			</td>
                        		</tr>
		               @endif

                            @else

                            <tr>
                                <td>
                                    <label class="form-checkbox-label">
                                        <input name="completed" class="form-checkbox-field deletecomment" value="0" type="checkbox" data-id="{{$note->id}}"  />
                                        <i class="form-checkbox-button"></i>
                                    </label>


                                </td>
                                <td>
                                    {!!$note->comment!!}

                                </td>
                                <td>
                                    @if(!empty($note->comment_added_by))
                                        @if(file_exists(public_path().'/assets/images/users/'.$note->added_by->image))
                                            <img src="{{asset('public/assets/images/users/'.$note->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member">
                                        @else
                                            <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    {{ date('d.m.Y', strtotime($note->created_at->addhours(2)))}}
                                </td>
                                <td data-order="1000">
                                    <i class="bi bi-card-list btn-task-popup"  data-id="{{$note->task_id}}"></i>
                                </td>
                            </tr>

                      @endif


                @endforeach
	</tbody>
</table>
<!--End data Table -->


    </div>
</div>

<!--End Users Tasks -->
@endsection
@section('script')
<script src="{{asset('public/assets/admin/assets2/js/dd.min.js')}}"></script>
<!--Start Data Table -->
<script>
    $(document).ready(function() {
    	// DataTable initialisation
    	var  commoenttable  = $('#example').DataTable(
    		{
    			"dom": '<"dt-buttons"Bfli>rtp',
    			"paging": true,
    			"autoWidth": true,
    			"fixedHeader": true,
    		}
    	);
    });
</script>
<!--End Data Table -->
<script>

	$(document).ready(function(){
					 var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
					enableTime: true,
					dateFormat: "d.m.Y  H:i",
				 });

	});


	$(document).ready(function() {

        $(".end_due_date").on('change', function (event) {
            var type = $(this).data('type');
            var end_due_date = $(this).val();
            var start_due_date = $('.start_due_date').val();
            var commentuserid = $('#userid').val();
            if (start_due_date && end_due_date) {
                $.ajax({
                    url: '{{route('admin.filter.filtercomments')}}',
                    type: "POST",
                    data: {
                        type: type,
                        start_due_date: start_due_date,
                        end_due_date: end_due_date,
                        commentuserid: commentuserid,
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    success: function (data) {

                        $('.user_subtasks').html('');
                        $('.user_subtasks').html(data.options);

                    },
                    error: function (jqXHR, status, err) {

                    },
                });
            }
        });

        $(".start_due_date").on('change', function (event) {

            var type = $(this).data('type');
            var start_due_date = $(this).val()
            var end_due_date = $('.end_due_date').val()
            var commentuserid = $('#userid').val();


            if (start_due_date && end_due_date) {
                $.ajax({
                    url: '{{route('admin.filter.filtercomments')}}',
                    type: "POST",
                    // need to create this post route
                    data: {
                        type: type,
                        start_due_date: start_due_date,
                        end_due_date: end_due_date,
                        commentuserid: commentuserid,
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    success: function (data) {

                        $('.user_subtasks').html('');
                        $('.user_subtasks').html(data.options);

                    },
                    error: function (jqXHR, status, err) {


                    },
                });
            }
        });


        $(document).on('change','.deletecomment' ,  function (e) {
                    if ($(this).prop("checked")) {
                        $.ajax({
                            url: '{{route('admin.comments.deletecomment')}}',
                            type: "POST",
                            // need to create this post route
                            data: {
                                comment_id: $(this).data('id'),
                                readby: "{{auth::user()->id}}",
                                value: $(this).val(),
                                _token: '{{ csrf_token() }}'
                            },
                            cache: false,
                            success: function (data) {
                                /*
                                 $('.user_subtasks').html('');
                                 $('.user_subtasks').html(data.options);
                                 */

                            },
                            error: function (jqXHR, status, err) {


                            },
                        });
                    }
                });

    });
</script>
@endsection
