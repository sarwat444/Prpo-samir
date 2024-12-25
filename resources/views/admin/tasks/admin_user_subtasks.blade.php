@if(!empty($user_subtasks))

@if($gender == 'list')

    <div class="todoslist" style="display:block;">
@else
      <div class="todoslist" style="display:none;">
@endif

<table class="table-striped table-bordered filtered_table" >
   <thead>
       <tr>
           <th>Status</th>
           <th>{{__('messages.subtask')}}</th>
           <th>{{__('messages.post')}}</th>
           <th>{{__('messages.category')}}</th>
           <th>{{__('messages.created_by')}}</th>
           <th>{{__('messages.created_at')}}</th>
           <th>{{__('messages.done_at')}}</th>
           <th>{{__('messages.due_date')}}</th>
           <th>{{__('messages.timer')}}</th>
           <th> Details </th>
       </tr>
   </thead>
   <tbody>
       @foreach($user_subtasks as $subtask)
         <tr>
              <td>
                 @if($subtask->subtask_status == 1)
                       <label class="form-checkbox-label">
                            <input name="completed" class="form-checkbox-field change_statusss" data-id="{{$subtask->id}}"  type="checkbox" value="1" checked  />
                            <i class="form-checkbox-button"></i>
                      </label>
                 @else

                  <label class="form-checkbox-label">
                            <input name="completed" class="form-checkbox-field change_statusss" data-id="{{$subtask->id}}"  type="checkbox" value="0"  />
                            <i class="form-checkbox-button"></i>
                      </label>
                 @endif
              </td>
              <td>
                {!!$subtask->subtask_title!!}
              </td>
              <td>
                  <p data-id="{{$subtask->id}}">  @if(!empty($subtask->task->task_title))    {{$subtask->task->task_title }}     @else "No Task"  @endif </p>
              </td>
              <td>
                 <p>@if(!empty($subtask->task->category->category_name))    {{$subtask->task->category->category_name }}     @else "No Category"  @endif</p>
              </td>
              <td>
               @if(!empty($subtask->added_by))
                   @if(file_exists(public_path().'/assets/images/users/'.$subtask->added_by->image))
                      <img src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member">
                   @else
                    <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                   @endif
               @endif
            </td>
              <td>
                      <p class="sub-date">
                      {{ date('d.m.Y', strtotime($subtask->created_at->addhours(2)))}}
                      </p>
            </td>
              <td>
                  <p class="sub-date">
                    @if(!empty($subtask->subtask_completed_at)) {{ date('d.m.Y', strtotime($subtask->subtask_completed_at))}} @else -- @endif
                   </p>
           </td>
              <td>
            <p class="sub-date">
                   @if(!empty($subtask->subtask_due_date))
                      {{ date('d.m.Y', strtotime($subtask->subtask_due_date))}}
                   @endif
            </p>
      </td>
              <td>
         <!-- Start Timer  -->
                  <section id="stopWatch">
                      <p class="timer{{$subtask->id}}" style="font-weight: 500;  font-size: 13px;color: #141834;background-color: #eee;padding: 4px;border-radius: 20px;    width: 100%;margin: 0 auto;margin-bottom: 10px;
                                    }"> 00:00:00 </p>
                      <i class="start{{$subtask->id}} bi bi-play-circle  start" data-id="{{$subtask->id}}" data-toggle="play"></i>
                      <i class="stop{{$subtask->id}} bi bi-stop-circle stop" data-id="{{$subtask->id}}" data-toggle="stop" style="display: none"></i>
                      <i class="pause{{$subtask->id}} bi bi-pause-circle pause" data-id="{{$subtask->id}}" data-toggle="pause" style="display: none"></i>
                      <i class="continue{{$subtask->id}} continue bi bi-play-circle" hidden="" data-id="62"></i>
                      <p class="fulltime{{$subtask->id}} fulltime"></p>
                  </section>
         <!-- End Timer -->
         </td>
             <td>  <p><i class="bi bi-card-list btn-task-popup" data-id="{{$subtask->id}}"></i></p> </td>
        </tr>
     @endforeach
  </tbody>
</table>
 @endif



 <!-- BOx TOdos -->
@if($gender == 'box')
<div class="todosbox" style="display:block;">
@else
<div class="todosbox" style="display:none;">
@endif


<div class="cards" id="cards">
<div class="overlay"></div>

 <div class="row sortable-cards" id="shuffle">



@foreach($user_subtasks as $subtask)

<div class="col-md-3 btn-task-popup sortable-divs mix ui-state-default {{$subtask->task->category->category_name}}" data-id="{{$subtask->task->id}}" >
 <div class="card sort" @if(!empty($subtask->task->category->category_color)) style="background-color:{{$subtask->task->category->category_color}}" @endif >
    <div class="card-contents">
        <div class="top-bar">
            <div class="row">
            <div class="col-md-3">
              <p>{{!empty($subtask->task->category->category_name) ? $subtask->task->category->category_name :' ' }}</p>
            </div>

            <div class="col-md-5">

                      @if(!empty($subtask->responsible))

                          @if(file_exists(public_path().'/assets/images/users/'.$subtask->task->responsible->image))
                             <img src="{{asset('public/assets/images/users/'.$subtask->responsible->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member">
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
                   <span>  Erstellt von </span></div>
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

 <script>

 	$(document).ready(function(){

   $('.change_statusss').each(function(){
         $(this).on('click',function(){
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
});
});
 </script>
        <script>
            /*Start Timer */
            /* initialization of different variables
            to be used in Count-Up App*/
            var clearTime;
            var seconds = 0,
                minutes = 0,
                hours = 0;
            var secs, mins, gethours;
            var  yy = '' ;
            function setheadertimer(x)
            {
                var  timer_control  = document.getElementById('timer_control') ;
                timer_control.innerHTML =
                    "<i data-id='"+x+"' class='bi bi-stop-circle stotime_con'></i>" /* +
               /* "<i class='continue"+x+" continue bi bi-play-circle ' hidden='' data-id='"+x+"'></i>" +*/
                /*  "<p class='fulltime"+x+" fulltime'></p>" + */
                /*   "<p class='recodtime'></p>" ;*/
            }
            function startWatch(rr){
                yy = rr ;
                //  console.log('Before : sec:'+seconds+'min:'+minutes+ 'hours:'+hours ) ;
                /* check if seconds is equal to 60 and add a +1
                  to minutes, and set seconds to 0 */

                if (seconds === 60) {
                    seconds = 0;
                    minutes = Number(minutes)+ 1;

                }

                /* i used the javascript tenary operator to format
                  how the minutes should look and add 0 to minutes if
                  less than 10 */
                mins = minutes < 10 ? "0" + Number(minutes) + ": " : minutes + ": ";
                /* check if minutes is equal to 60 and add a +1
                  to hours set minutes to 0 */
                if (minutes === 60) {
                    minutes = 0;
                    hours = Number(hours) + 1;
                }
                /* i used the javascript tenary operator to format
                  how the hours should look and add 0 to hours if less than 10 */
                gethours = hours < 10 ? "0" + hours + ": " : hours + ": ";
                secs = seconds < 10 ? "0" + seconds : seconds;


                var xv = document.getElementsByClassName("timer"+yy);

                for(var xd =0 ; xd < xv.length ; xd ++  )
                {
                    if(xv[xd]) {
                        xv[xd].innerHTML = gethours + mins + secs;
                    }
                }
                setTimeout(()=>{

                    setheadertimer(yy);
                    var stopicon =  document.getElementsByClassName("stotime_con");
                    for(var h = 0 ; h < stopicon.length ; h++ )
                    {
                        stopicon[h].addEventListener("click", stopTime) ;
                    }


                } , 1000) ;






                var  toptimer  = document.getElementsByClassName('tasktimer2') ;
                for(var z=0 ; z < toptimer.length  ; z++ )
                {
                    if(toptimer[z]) {
                        toptimer[z].innerHTML = "<i class='bi bi-alarm '></i> "+ gethours + mins + secs  ;

                    }
                }

                var timer_text = gethours + mins + secs   ;

                //Diffrence  Between To  Dates And Time


                seconds++;

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.subtasks.store_timer') }}',
                    data: {task_id: yy ,userid:'{{Auth::user()->id}}',timer_value :timer_text,_token: '{{ csrf_token() }}'},
                    success: function (data) {
                    }
                });

                /* call the setTimeout( ) to keep the Count-Up alive ! */
                clearTime = setTimeout("startWatch("+yy+")", 1000);
                /* call the seconds counter after displaying the Count-Up*/
                // console.log('After  store  seconds : ' + secs) ;
                // console.log('After  store  minutes : ' + mins) ;

            }

            //create a function to start the Count-Up
            function startTime() {
                var  zz  =  this.getAttribute('data-id');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.subtasks.starttime') }}',
                    data: {task_id: zz , _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        // Diffrence
                        console.log(data) ;
                    }
                });


                /* check if seconds, minutes, and hours are equal to zero
                  and start the Count-Up */
                if (seconds === 0 && minutes === 0 && hours === 0) {
                    /* hide the fulltime when the Count-Up is running */

                    var fulltime = document.getElementsByClassName("fulltime"+zz);
                    for(var i=0 ; i< fulltime.length ; i ++ ) {
                        fulltime[i].style.display = "none";
                    }
                    var showStart = document.getElementsByClassName("start"+zz);
                    for(var b=0 ; b< fulltime.length ; b ++ ) {
                        showStart[b].style.display = "none";
                    }

                    var stopshow = document.getElementsByClassName("stop"+zz);
                    for(var y=0 ; y< fulltime.length ; y ++ ) {
                        stopshow[y].style.display = "inline-block";
                    }
                    var pause = document.getElementsByClassName("pause"+zz);
                    for(var yc=0 ; yc< pause.length ; yc ++ ) {
                        pause[yc].style.display = "inline-block";
                    }



                    /* call the startWatch( ) function to execute the Count-Up
                        whenever the startTime( ) is triggered */

                    startWatch(zz);
                    //starttimer

                    //end start watch


                }
            }



            var userSelection =  document.getElementsByClassName("start");
            for(let i = 0; i < userSelection.length; i++) {
                userSelection[i].addEventListener("click", startTime)
            }


            /*create a function to stop the time */
            function stopTime() {


                sz  =  this.getAttribute('data-id');
                /* check if seconds, minutes and hours are not equal to 0 */
                if (seconds !== 0 || minutes !== 0 || hours !== 0) {
                    var continueButton = document.getElementsByClassName("continue"+sz);
                    for(var i = 0 ;  i < continueButton.length ; i++) {
                        continueButton[i].setAttribute("hidden", "true");
                    }

                    var time = gethours + mins + secs;
                    var fulltime = document.getElementsByClassName("fulltime"+sz);
                    for(var v = 0 ;  v < fulltime.length ; v++) {
                        fulltime[v].style.display = "block";
                        fulltime[v].style.color = "#ff4500";

                        fulltime[v].innerHTML = "<p class ='timerecorder'>" + time + "</p>";
                    }
                }
                // reset the Count-Up
                seconds = 0;
                minutes = 0;
                hours = 0;
                secs = "0" + seconds;
                mins = "0" + minutes + ": ";
                gethours = "0" + hours + ": ";

                /* display the Count-Up Timer after it's been stopped */
                var x = document.getElementsByClassName("timer"+sz);
                var stopTime = gethours + mins + secs;

                for(var r = 0 ;  r < x.length ; r++) {
                    x[r].innerHTML = stopTime;
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.subtasks.store_time') }}',
                    data: {id: sz,time:time, _token: '{{ csrf_token() }}'},
                    success: function (data) {

                    }
                });
                var xv = document.getElementsByClassName("recodtime");
                for(var u = 0 ;  u < xv.length ; u++)
                {
                    xv[u].style.display = "block";
                    xv[u].innerHTML = "<p> <i class='fa fa-check-circle'></i>Time Entery wurde erfolgreich erstellt - " + time + "</p>";
                    /*setTimeout(() => {
                        xv[u].style.display = "none";
                    }, 3000);*/
                }

                /* display all Count-Up control buttons */
                var showStart = document.getElementsByClassName("start"+sz);
                for(var it = 0 ;  it < showStart.length ; it++) {
                    showStart[it].style.display = "inline-block";
                }


                var showStop = document.getElementsByClassName("stop"+sz);
                for(var iq = 0 ;  iq < showStop.length ; iq++) {
                    showStop[iq].style = 'display:inline-block !important';
                }
                var showPause = document.getElementsByClassName("pause"+sz);
                for(var ih = 0 ;  ih < showPause.length ; ih++) {
                    showPause[ih].style.display = "inline-block";
                }
                /* clear the Count-Up using the setTimeout( )
                    return value 'clearTime' as ID */
                clearTimeout(clearTime);
            }

            window.addEventListener("load", function() {
                var stopsection =  document.getElementsByClassName("stop");
                for(let i = 0; i < stopsection.length; i++) {
                    stopsection[i].addEventListener("click", stopTime)
                }
            });








            /*********** End of Stop Button Operations *********/

            /*********** Pause Button Operations *********/
            function pauseTime() {

                var  sm  =  this.getAttribute('data-id');
                if (seconds !== 0 || minutes !== 0 || hours !== 0) {
                    /* display the Count-Up Timer after clicking on pause button */

                    var continueButton = document.getElementsByClassName("continue"+sm);

                    for(var ie = 0 ;  ie < continueButton.length ; ie++) {
                        continueButton[ie].removeAttribute("hidden");
                    }



                    var stopTime = gethours + mins + secs;


                    var xu = document.getElementsByClassName("timer" + sm);
                    for(var ie = 0 ;  ie < continueButton.length ; ie++) {
                        xu[ie].innerHTML = stopTime;
                    }

                    var continuebutton  = document.getElementsByClassName("continue" + yu);
                    for (let xx = 0; xx < continuebutton.length; xx++) {
                        continuebutton[xx].style.display = "inline-block";
                    }


                    /* display all Count-Up control buttons */
                    var showStop = document.getElementsByClassName("stop" + sm);
                    for(var iew = 0 ;  iew < showStop.length ; iew++) {

                        showStop[iew].style.display = "inline-block";

                    }


                    /* clear the Count-Up using the setTimeout( )
                        return value 'clearTime' as ID */
                    clearTimeout(clearTime);
                }
            }


            var pausesection = document.getElementsByClassName("pause");
            for (let i = 0; i < pausesection.length; i++) {
                pausesection[i].addEventListener("click", pauseTime)
            }

            /*********** End of Pause Button Operations *********/

            /*********** Continue Button Operations *********/
            function continueTime(taskid) {
                var yu = this.getAttribute('data-id');
                if (seconds !== 0 || minutes !== 0 || hours !== 0) {
                    /* display the Count-Up Timer after it's been paused */
                    var continueTime = gethours + mins + secs;
                    var x = document.getElementsByClassName("timer" + yu);
                    for (let i = 0; i < pausesection.length; i++) {
                        x[i].innerHTML = continueTime;
                    }

                    /* display all Count-Up control buttons */
                    var showStop = document.getElementsByClassName("stop" + yu);
                    for (let x = 0; x < showStop.length; x++) {
                        showStop[x].style.display = "inline-block";
                    }

                    var continuebutton  = document.getElementsByClassName("continue" + yu);
                    for (let xx = 0; xx < continuebutton.length; xx++) {
                        continuebutton[xx].style.display = "none";
                    }

                    /* clear the Count-Up using the setTimeout( )
                        return value 'clearTime' as ID.
                        call the setTimeout( ) to keep the Count-Up alive ! */
                    startWatch(yu) ;

                }
            }

            window.addEventListener("load", function () {
                var continuetimesection = document.getElementsByClassName("continue");
                for (let i = 0; i < continuetimesection.length; i++) {
                    continuetimesection[i].addEventListener("click", continueTime)
                }
            });
            /*********** End of Continue Button Operations *********/
        </script>


        <script>
            // Dashboard Timer
            $(document).ready(function () {

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.subtasks.get_timer') }}',
                    data: {userid: '{{Auth::user()->id}}', _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        var sethours = data.hours;
                        var setminutes = data.minutes;
                        var setseconds = data.seconds;
                        data = data.taskdata;

                        if (data['timer'] == 1) {
                            //styling  timer
                            $('#timer' + data['id']).css({'background-color': '#198754', 'color': '#fff'});
                            $('.start'+ data['id']).css({'display' : 'none'}) ;
                            $('.stop'+ data['id']).css({'display' : 'block'}) ;
                            $('.pause'+ data['id']).css({'display' : 'block'}) ;
                            $('#toptimer').attr('data-bs-original-title', data['subtask_title']);
                            seconds = setseconds;
                            minutes = setminutes;
                            hours = sethours;


                            clearTimeout(clearTime);
                            clearTime = setTimeout("startWatch(" + data['id'] + ")", 1000);
                            setTimeout(() => {

                                setheadertimer(data['id']);
                                var stopicon = document.getElementsByClassName("stotime_con");
                                for (var h = 0; h < stopicon.length; h++) {
                                    stopicon[h].addEventListener("click", stopTime);
                                }


                            }, 1000);


                        }

                    }
                });


            });
        </script>
