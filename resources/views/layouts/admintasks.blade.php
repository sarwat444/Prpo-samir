@extends('layouts.dashboard')
@section('css')
    <link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
    <script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}" ></script>
    <link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
    <link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">
<style>
#stopWatch {
  height: auto;
  text-align: center;
  display: block;
  padding: 5px;
}
#timer,
#fulltime {
      height: auto;
      font-size: 13px;
      font-family: ubuntu;
      display: block;
      text-align: center;
      color: #013c60;
}
#fulltime {
  display: none;
  font-size: 16px;
  font-weight: bold;
}
.mytasks .tasks .task {
    background-color: #fff;
    width: 100%;
    margin: 0 auto;
    padding-top: 10px;
    border-bottom: 1px solid #ccc;
    margin-bottom: 2px;
    font-size: 12px;
    text-align: center;
    /* font-weight: bold; */
}
.start ,
#stop ,
#pause
{
  font-size: 14px;
  margin-right: 4px;
}
.start ,
#continue
{
color: #0576eb;
}
#start:hover ,
#continue:hover
{
  color: #0261c3 ;
  cursor: pointer;
}

#stop ,
.stop
{
color: #f00;
}
#stop:hover ,
.stop:hover
{
  color: #b30404d6 ;
  cursor: pointer;
}
#pause ,
.pause
{
color: #ccc;
}
#pause:hover ,
#pause:hover
{
  color: #777 ;
  cursor: pointer;
}
.hidden
{
  display: none;
}
.recodtime
{
  position: fixed;
  right: 49px;
  bottom: 2px;
  border-radius: 0;
  background-color: #107a28;
  color: #fff;
  width: 25%;
  text-align: center;
  padding-top: 12px;
  border-radius: 4px;
  border: 0;
  padding-bottom: 0;
  display: none;
  font-size: 13px ;
}
.recodtime i{
  margin-right: 5px ;
}
.timerecorder
{
      border: 1px solid #ccc; */
      /* padding: 10px; */
      text-align: center;
      font-size: 13px;
      margin-top: 16px;
      padding: 0px;
      color: #198754;
}
.todos ,
.list_todos{
    border-radius: 0 !important;
    font-size: 13px ;

}
.todoslist .heading
{
    color: #009eff;
    font-weight: 500;
    font-size: 13px ;
}
    #stopWatch i{
        font-size: 25px ;
    }

</style>
@endsection
@section('title')Meine Aufgaben @endsection
@section('content')
<!--Start  Users Tasks -->
<div class="container">

  <!--Start Final Timer Alert -->
<alert class="alert alert-success recodtime">
     <p> <i class="fa fa-check-circle"></i> Time Entery wurde erfolgreich erstellt </p>
</alert>


  <!--End Timer Alert -->
    <div class="mytasks">

       <input type="hidden" id="gender" name="gender" value="list">
           <div class="sub-tasks">

              <div class="fillter">

                            <div class="row">

                             @if(Auth::user()->role == 1 )
                                <div class="col-md-2">
                                <div class="form-control">
                                       <select  name="users" id="subtasks_users" is="ms-dropdown" data-type="user_filter" data-gender="list"  required>
                                           <option value="all"> Alle Mitarbeiter </option>

                                            @foreach($users as $user)
                                              <option value="{{$user->id}}" data-image="{{asset('public/assets/images/users/'.$user->image)}}">{{$user->user_name}}</option>
                                            @endforeach
                                        </select>
                                  </div>
                              </div>
                              @endif


                            <div class="col-md-2">
                                <div class="row">
                                     <div class="col-md-6">
                                          <div class="datepicker" data-type="date_filter" data-gender="list">
                                          <input  type="text"  class="start_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target" data-name="task_due_date"  name="task_due_date"  placeholder="Von">
                                           </div>
                                     </div>
                                    <div class="col-md-6">
                                         <div class="datepicker">
                                             <input  type="text"   data-type="date_filter" data-gender="list"   class="end_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target" data-name="task_due_date"  name="task_due_date"  placeholder="An">
                                        </div>
                                    </div>
                                   </div>
                            </div>


                 <div class="col-md-2">
                                    <div class="form-control status">
                                           <input type="radio" name="subtask_status" value='1'  data-type="status_filter" data-gender="list"/> <label>Erledigt</label>
                                           <input type="radio" name="subtask_status" value='2'  data-type="status_filter" data-gender="list"/> <label>Offen</label>
                                   </div>
                </div>

                <div class="col-md-4">
                                    <div class="form-control status">
                                           <input type="radio" name="subtask_status2" value='3'  data-type="status2_filter" data-gender="list"/> <label>Erstellt am</label>
                                           <input type="radio" name="subtask_status2" value='4'  data-type="status2_filter" data-gender="list"/> <label>  Falligkeitsdatum  </label>
                                           <input type="radio" name="subtask_status2" value='5'  data-type="status2_filter" data-gender="list"/> <label> Erledigt am  </label>
                                   </div>
                  </div>
                  <div class="col-md-2">
                                     <div class="form-control">
                                       <button class="todos btn btn-success">Boxes</button>
                                       <button class="list_todos btn btn-info">List</button>
                                    </div>
                 </div>
                       </div>

              </div>


              <div class="tasks user_subtasks">

                @if(!empty($user_subtasks))


               <!-- LIST TODOS  -->
               <div class="todoslist" style="display:block;">


                <div class="row task heading">
                   <div class="col-md-1">

                        Status

                   </div>
                   <div class="col-md-2">
                      <p> Unteraufgabe </p>
                  </div>
                    <div class="col-md-1">
                       <p> Post-it</p>
                   </div>

                   <div class="col-md-1">
                      <p >Kategorie</p>
                  </div>

                  <div class="col-md-1">
                        <p>
                        Erstellt von
                        </p>
                    </div>

                  <div class="col-md-1">
                        <p>
                         Erstellt am
                        </p>
                    </div>
                 <div class="col-md-1">
                       <p>
                       Erledigt am
                       </p>
                   </div>

                    <div class="col-md-1">
                       <p>
                                 Falligkeitsdatum
                         </p>
                   </div>
                    <div class="col-md-2">
                        <p>
                            Timer
                        </p>
                    </div>
                   <div class="col-md-1">
                      <p>
                       Details
                        </p>
                  </div>
                </div>


                 @foreach($user_subtasks as $subtask)
                   <div class="row task">
                      <div class="col-md-1 col-md-1 d-flex align-items-center justify-content-center">

                         @if($subtask->subtask_status == 1)
                               <label class="form-checkbox-label">
                                    <input name="completed" class="form-checkbox-field  change_statusss" data-id="{{$subtask->id}}"  type="checkbox" value="1" checked  />
                                    <i class="form-checkbox-button"></i>
                              </label>


                         @else

                          <label class="form-checkbox-label">
                                    <input name="completed" class="form-checkbox-field change_statusss" data-id="{{$subtask->id}}"  type="checkbox" value="0"  />
                                    <i class="form-checkbox-button"></i>
                              </label>


                         @endif

                      </div>
                      <div class="col-md-2 d-flex align-items-center justify-content-center">
                         <p> {!!$subtask->subtask_title!!} </p>
                     </div>
                       <div class="col-md-1 d-flex align-items-center justify-content-center">
                          <p data-id="{{$subtask->id}}">  @if(!empty($subtask->task->task_title))    {{$subtask->task->task_title }}     @else "No Task"  @endif </p>
                      </div>

                      <div class="col-md-1 d-flex align-items-center justify-content-center">
                         <p>{{!empty($subtask->task->category->category_name) ? $subtask->task->category->category_name :' ' }} {{!empty($subtask->task->second_category->category_name) ? '/'.$subtask->task->second_category->category_name :' ' }}</p>
                     </div>

                     <div class="col-md-1 d-flex align-items-center justify-content-center">
                       @if(!empty($subtask->added_by))

                       @if(file_exists(public_path().'/assets/images/users/'.$subtask->added_by->image))
                          <img src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}" style="width:40px;height:40px;border-radius:50%;" alt="member">
                       @else
                            <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                       @endif
                       @endif
                    </div>


                     <div class="col-md-1 d-flex align-items-center justify-content-center">
                           <p class="sub-date">

                              {{ date('d.m.Y', strtotime($subtask->created_at->addhours(2)))}}  </p>
                    </div>
                    <div class="col-md-1 d-flex align-items-center justify-content-center">
                          <p class="sub-date">

                            @if(!empty($subtask->subtask_completed_at)) {{ date('d.m.Y', strtotime($subtask->subtask_completed_at))}} @else -- @endif  </p>
                      </div>

                       <div class="col-md-1 d-flex align-items-center justify-content-center">
                          <p class="sub-date">
                         @if(!empty($subtask->subtask_due_date))
                          {{ date('d.m.Y', strtotime($subtask->subtask_due_date))}}
                           @endif
                            </p>
                      </div>
                       <div class="col-md-2 d-flex align-items-center justify-content-center">
                           <!-- Start Timer  -->
                           <section id="stopWatch">
                               <p class="timer{{$subtask->id}}" style="font-weight: 500;  font-size: 13px;color: #141834;background-color: #eee;padding: 4px;border-radius: 20px;    width: 100%;margin: 0 auto;margin-bottom: 10px;
                                    }"> {{!empty($subtask->subtask_time) ?  $subtask->subtask_time  : '00:00:00' }} </p>
                               <i class="start{{$subtask->id}} bi bi-play-circle  start"  data-id="{{$subtask->id}}" data-toggle="play"></i>
                               <i class="stop{{$subtask->id}} bi bi-stop-circle stop"  data-id="{{$subtask->id}}" data-toggle="stop" style="display: none"></i>
                               <i class="pause{{$subtask->id}} bi bi-pause-circle pause"  data-id="{{$subtask->id}}" data-toggle="pause" style="display: none"></i>
                               <i class="continue{{$subtask->id}} continue bi bi-play-circle" hidden  data-id="{{$subtask->id}}" ></i>
                               <p class="fulltime{{$subtask->id}} fulltime"></p>
                           </section>
                           <!-- End Timer -->
                       </div>
                      <div class="col-md-1 d-flex align-items-center justify-content-center">
                         <p><i class="bi bi-card-list btn-task-popup" data-id="{{$subtask->task->id}}"></i></p>
                      </div>
                   </div>
                   @endforeach

             </div>

          <!-- End LIst TOdos  -->


            <!-- BOx TOdos -->
        <div class="todosbox" style="display:none;">



      <div class="cards" id="cards">
         <div class="overlay"></div>

            <div class="row sortable-cards" id="shuffle">



        @foreach($user_subtasks as $subtask)

           <div class="col-md-3 btn-task-popup  sortable-divs mix ui-state-default {{$subtask->task->category->category_name}}" data-id="{{$subtask->task->id}}" >
            <div class="card sort" @if(!empty($subtask->task->category->category_color)) style="background-color:{{$subtask->task->category->category_color}}" @endif >
               <div class="card-contents">
                   <div class="top-bar">
                       <div class="row">
                       <div class="col-md-3">
                         <p>{{!empty($subtask->task->category->category_name) ? $subtask->task->category->category_name :' ' }}</p>
                       </div>

                       <div class="col-md-5">

                                 @if(!empty($subtask->responsible))

                                     @if(file_exists(public_path().'/assets/images/users/'.$subtask->responsible->image))
                                        <img src="{{asset('public/assets/images/users/'.$subtask->responsible->image)}}" alt="member" style="height:25px;width:25px;border-radius:50%;">
                                     @else
                                          <img src="https://source.unsplash.com/user/c_v_r">
                                     @endif
                                        <p>Verantwortlich</p>
                                   @endif

                         </div>
                       </div>
                   </div>
                   <div class="middle-content">

                      <h3>{!!substr($subtask->subtask_title,0,70)!!}</h3>
                      <br>

                   </div>
                   <div class="button-bar">
                       <div class="row">

                            <div class="col-md-6">
                             @if(!empty($subtask->added_by))

                             @if(file_exists(public_path().'/assets/images/users/'.$subtask->added_by->image))
                                <img src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}" alt="member" style="height:25px;width:25px;border-radius:50%;">
                             @else
                                  <img src="https://source.unsplash.com/user/c_v_r">
                             @endif

                             @endif
                              <span>  Erstellt von </span>
                            </div>
                            <div class="col-md-6">
                                 <p>DeadLine</p>
                                <p> {{ date('d.m.Y', strtotime($subtask->task->task_due_date))}} </p>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           </div>
        @endforeach



     </div>

</div>


          </div>
            <!-- End Box Todos -->



















                 @endif



               <!-- End User SubTask -->
               </div>


           </div>
    </div >
</div>
<!--End Users Tasks -->
@endsection
@section('script')
<script src="{{asset('public/assets/admin/assets2/js/dd.min.js')}}"></script>
<script>

	$(document).ready(function(){
					 var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
					enableTime: true,
					dateFormat: "d.m.Y  H:i",
				 });

	});


	$(document).ready(function(){

     $("#all").on('click',function (event) {
	         //alert('hello');

              var type = $(this).data('type');
              var gender = $("#gender").val();
              var start_due_date = $('.start_due_date').val();
              var end_due_date = $('.end_due_date').val();
              var subtask_user_id = $('#subtasks_users').val();
               var subtask_status  =  $('input[name=subtask_status]:checked', '.status').val();
            // alert(type);
              $.ajax({

                      type: "POST",
                      url:   '{{route('admin.filter.usertasks')}}',   // need to create this post route
                      data: {type:type , gender : gender ,start_due_date : start_due_date , end_due_date:end_due_date , subtask_user_id : subtask_user_id , subtask_status : subtask_status  , _token: '{{ csrf_token() }}'},
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

              var type = $(this).data('type');
              var gender = $("#gender").val();
              var end_due_date = $(this).val()
               var start_due_date = $('.start_due_date').val()
               var subtask_user_id = $('#subtasks_users').val();
               var subtask_status  =  $('input[name=subtask_status]:checked', '.status').val();
              var subtask_status2  =  $('input[name=subtask_status2]:checked', '.status').val();



           //  alert(type);

             if( start_due_date &&  end_due_date ) {
              $.ajax({

                      type: "POST",
                      url:   '{{route('admin.filter.usertasks')}}',   // need to create this post route
                      data: {type : type , gender : gender , start_due_date:start_due_date , end_due_date: end_due_date , subtask_user_id : subtask_user_id , subtask_status:subtask_status , subtask_status2 : subtask_status2 , _token: '{{ csrf_token() }}'},
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
              var gender = $("#gender").val();
              var start_due_date  = $(this).val()
               var end_due_date = $('.end_due_date').val()
               var subtask_user_id = $('#subtasks_users').val();
                var subtask_status  =  $('input[name=subtask_status]:checked', '.status').val();
                var subtask_status2  =  $('input[name=subtask_status2]:checked', '.status').val();
           //  alert(type);

           if(start_due_date && end_due_date) {
              $.ajax({

                      type: "POST",
                      url:   '{{route('admin.filter.usertasks')}}',   // need to create this post route
                      data: {type : type ,gender : gender , start_due_date:start_due_date , end_due_date: end_due_date,subtask_user_id:subtask_user_id , subtask_status: subtask_status , subtask_status2 : subtask_status2, _token: '{{ csrf_token() }}'},
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


                $('#subtasks_users').on('change' , function(){
                //  alert('hello');
                     var type = $(this).data('type');
                    var gender = $("#gender").val();
                    var subtask_user_id = $(this).val();
                    var start_due_date = $('.start_due_date').val();
                    var end_due_date = $('.end_due_date').val();

                     var subtask_status  =  $('input[name=subtask_status]:checked', '.status').val();
                    var subtask_status2  =  $('input[name=subtask_status2]:checked', '.status').val();
                        //   alert(subtask_user_id);
                     $.ajax({

                      type: "POST",
                      url:   '{{route('admin.filter.usertasks')}}',   // need to create this post route
                      data: {type : type , gender : gender , subtask_user_id:subtask_user_id,start_due_date:start_due_date ,end_due_date:end_due_date,subtask_status:subtask_status , subtask_status2 : subtask_status2, _token: '{{ csrf_token() }}'},
                     cache: false,
                      success: function (data) {

                         $('.user_subtasks').html('');
                          $('.user_subtasks').html(data.options);

                      },
                      error: function (jqXHR, status, err) {


                      },
                });

                });

                $('input[type=radio][name=subtask_status]').change(function() {

                        var type = $(this).data('type');
                        var gender = $("#gender").val();
                        var subtask_status  = this.value;
                        var start_due_date = $('.start_due_date').val();
                        var end_due_date = $('.end_due_date').val();
                        var subtask_user_id = $('#subtasks_users').val();
                        var subtask_status2  =  $('input[name=subtask_status2]:checked', '.status').val();


                            $.ajax({
                             type: "POST",
                             url:   '{{route('admin.filter.usertasks')}}',   // need to create this post route
                             data: {type : type ,gender : gender , subtask_status:subtask_status,subtask_status2:subtask_status2 ,start_due_date:start_due_date,end_due_date:end_due_date,subtask_user_id:subtask_user_id, _token: '{{ csrf_token() }}'},
                            cache: false,
                             success: function (data) {

                                $('.user_subtasks').html('');
                                 $('.user_subtasks').html(data.options);

                             },
                             error: function (jqXHR, status, err) {


                             },
                       });






               });


               $('input[type=radio][name=subtask_status2]').change(function() {

                       var type = $(this).data('type');
                      //  alert(type);
                       var gender = $("#gender").val();
                       var subtask_status2  = this.value;
                       var start_due_date = $('.start_due_date').val();
                       var end_due_date = $('.end_due_date').val();
                       var subtask_user_id = $('#subtasks_users').val();
                       var subtask_status  =  $('input[name=subtask_status]:checked', '.status').val();
                          if(start_due_date && end_due_date) {
                           $.ajax({
                            type: "POST",
                            url:   '{{route('admin.filter.usertasks')}}',   // need to create this post route
                            data: {type : type ,gender : gender , subtask_status:subtask_status,subtask_status2:subtask_status2 ,start_due_date:start_due_date,end_due_date:end_due_date,subtask_user_id:subtask_user_id, _token: '{{ csrf_token() }}'},
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


                 $('.change_statusss').each(function(){
                	$(this).on('click',function(){
                    	     var id = $(this).data('id');
                    		 var dta = $(this).text();
                    	     var task_id = $("#task_id").val();

                    		$.ajax({
                    				 type: 'POST',
                    				 url: '{{ route('admin.subtasks.updatesubtask_status') }}',
                    				 data: {id: id,task_id:task_id, _token: '{{ csrf_token() }}'},
                    				 success: function (data) {
                                    alert('changed') ;
                    				 }
                    		 });
                });
                });


                $('.todos').on('click' , function(){

                     $('.todoslist').css('display','none');
                     $('.todosbox').css('display','block');
                      $('#gender').val("box");
               });

               $('.list_todos').on('click' , function(){

                     $('.todoslist').css('display','block');
                     $('.todosbox').css('display','none');
                     $('#gender').val("list");


              });


           });

</script>


@endsection
