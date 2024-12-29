@extends('layouts.dashboard')
@section('css')
<link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
<script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}" ></script>
<link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
@endsection
@section('title')Meine Aufgaben @endsection
@section('content')
<!--Start  Users Tasks -->
<div class="container">
    <div class="mytasks">
           <div class="fillter">
                <form>
                    <div class="row">
                            <div class="col-md-2">
                                 <div class="form-control all">
                                     <label class="form-checkbox-label">
                                            <input name="all" class="form-checkbox-field" type="checkbox" id="all" data-type="all" value="all" /> <label>Alle</label>
                                            <i class="form-checkbox-button"></i>
                                      </label>

                                </div>
                            </div>

                           <div class="col-md-3">
                             <div class="form-control">
                                 <div class="datepicker" data-type="date_filter">
                                     <input  type="text"  class="start_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target" data-name="task_due_date"  name="task_due_date"  placeholder="Von">
								  </div>
							 </div>
							</div>
						   <div class="col-md-3">
                            <div class="form-control">
                                 <div class="datepicker">
                                     <input  type="text"   data-type="date_filter"  class="end_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target" data-name="task_due_date"  name="task_due_date"  placeholder="An">
								  </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                 <div class="form-control status">
                                        <input type="radio" name="subtask_status" value='1'  data-type="status_filter"/> <label>Abgeschlossen</label>
                                        <input type="radio" name="subtask_status" value='0'  data-type="status_filter" class="subtask_status" /> <label>unvollendet</label>
                                </div>
                            </div>
                    </div>
               </form>
           </div>
           <div class="sub-tasks">
               <div class="tasks user_subtasks">

                @if(!empty($user_subtasks))

                <div class="row task">
                   <div class="col-md-1">

                        Status

                   </div>
                   <div class="col-md-3">
                      <p> Unteraufgabe </p>
                  </div>
                    <div class="col-md-2">
                       <p> Post-it</p>
                   </div>

                   <div class="col-md-1">
                      <p data-id="">Kategorie</p>
                  </div>
                  <div class="col-md-1">
                        <p class="sub-date">
                         <span class="last-updates" > Gestell am </span>
                        </p>
                    </div>
                 <div class="col-md-1">
                       <p class="sub-date">
                        <span class="last-updates" >Abgeschlossen </span>
                       </p>
                   </div>

                    <div class="col-md-2">
                       <p class="sub-date">
                      <span >Falligkeitsdatum</span>
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
                                    <input name="completed" class="form-checkbox-field" value="1" type="checkbox" checked  />
                                    <i class="form-checkbox-button"></i>
                              </label>
                         @else
                              <label class="form-checkbox-label">
                                    <input name="completed" class="form-checkbox-field" type="checkbox"  />
                                    <i class="form-checkbox-button"></i>
                              </label>

                         @endif

                      </div>
                       <div class="col-md-2">
                          <p >{!!$subtask->subtask_title!!}</p>
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
                             <span class="last-updates" >Abgeschlossen </span>
                               {{ date('d.m.Y', strtotime($subtask->updated_at->addhours(2)))}}  </p>
                        </div>

                         <div class="col-md-2">
                            <p class="sub-date">
                           <span >DeadLine</span>
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

               </div>

           </div>
    </div>
</div>
<!--End Users Tasks -->
@endsection
@section('script')
<script>
	$(document).ready(function(){
					 var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
        					enableTime: true,
        					dateFormat: "d.m.Y",
				 });

	});



	    $("#all").on('click',function (event) {

	         // alert('hello');

              var type = $(this).data('type');

            // alert(type);


              $.ajax({

                      type: "POST",
                      url:   '{{route('admin.filter.usertasks')}}',   // need to create this post route
                      data: {type:type , _token: '{{ csrf_token() }}'},
                     cache: false,
                      success: function (data) {

                         $('.user_subtasks').html('');
                          $('.user_subtasks').html(data.options);

                      },
                      error: function (jqXHR, status, err) {


                      },
                });

        });

        $(".end_due_date").on('change',function (event) {

	         //alert('hello');
            console.log('dsadsasadsad')
              var type = $(this).data('type');
              var end_due_date = $(this).val()
               var start_due_date = $('.start_due_date').val()

           //  alert(type);

             if( start_due_date &&  end_due_date ) {
              $.ajax({

                      type: "POST",
                      url:   '{{route('admin.filter.usertasks')}}',   // need to create this post route
                      data: {type : type , start_due_date:start_due_date , end_due_date: end_due_date, _token: '{{ csrf_token() }}'},
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

        $(".start_due_date").on('change',function (event) {

	         //alert('hello');

              var type = $(this).data('type');
              var start_due_date  = $(this).val()
               var end_due_date = $('.end_due_date').val()

           //  alert(type);

           if(start_due_date && end_due_date) {
              $.ajax({

                      type: "POST",
                      url:   '{{route('admin.filter.usertasks')}}',   // need to create this post route
                      data: {type : type , start_due_date:start_due_date , end_due_date: end_due_date, _token: '{{ csrf_token() }}'},
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


/*
        $('input[type=radio][name=subtask_status]').change(function() {

                 var type = $(this).data('type');
                 var subtask_status  = this.value;
                     $.ajax({

                      type: "POST",
                      url:   '{{route('admin.filter.usertasks')}}',   // need to create this post route
                      data: {type : type , subtask_status:subtask_status, _token: '{{ csrf_token() }}'},
                     cache: false,
                      success: function (data) {

                         $('.user_subtasks').html('');
                          $('.user_subtasks').html(data.options);

                      },
                      error: function (jqXHR, status, err) {


                      },
                });


        });*/

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
@endsection
