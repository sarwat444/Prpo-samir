

        <div class="row task">
           <div class="col-md-1 t-head">
                Status
           </div>
           <div class="col-md-3 t-head">
              <p> Unteraufgabe </p>
          </div>
          <div class="col-md-3  t-head">
                <p>
                    Kategorie
                </p>
            </div>
         <div class="col-md-2 t-head">
               <p>
                   Hinzugefügt von
               </p>
           </div>
            <div class="col-md-1 t-head">
               <p>
                   Zeit
                 </p>
           </div>

           <div class="col-md-1 t-head">
              <p>
               Details
              </p>
          </div>
        </div>

 @foreach($user_subtasks as $subtask)
           @if($subtask->history->count() != 0)

               <div class="row task">
                  <div class="col-md-1">

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

                  </div>
                  <div class="col-md-3">
                     <p> {!!$subtask->subtask_title!!} </p>
                 </div>


                  <div class="col-md-3">
                     <p>@if(!empty($subtask->task->category->category_name))    {{$subtask->task->category->category_name }}     @else "No Category"  @endif</p>
                 </div>

                 <div class="col-md-2">
                   @if(!empty($subtask->added_by))

                   @if(file_exists(public_path().'/assets/images/users/'.$subtask->added_by->image))
                      <img src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member">
                   @else
                        <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                   @endif
                   @endif
                </div>



                   <div class="col-md-1">

                        <?php
                           $timeonsecondes = 0 ;
                         ?>

                           @foreach($subtask->history as $history)
                                  <?php $timeonsecondes += $history->Time ;  ?>
                            @endforeach
                            <?php
                            $hours = floor($timeonsecondes / 3600);
                            $mins = floor($timeonsecondes / 60 % 60);
                            $secs = floor($timeonsecondes % 60);
                            $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);

                            if($hours=='00'  && $mins =='00'  && $secs== '00')
                            {
                            echo "<p class='totaltimedanger'>". 'kein Zeitrekord' ."</p>" ;
                            }
                            else
                            {
                               echo "<p class='totaltime'>".  $timeFormat ."</p>" ;
                            }
                             ?>


                  </div>
                   <div class="col-md-1 text-center">
                       <i class="bi bi-card-list  historydescription" data-id="{{$subtask->id}}"  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
                       <!-- Button trigger modal -->
                   </div>

               </div>

           @endif
 @endforeach

 </div>



</div>



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
 function startWatch(rr){
   yy = rr ;
   /* check if seconds is equal to 60 and add a +1
     to minutes, and set seconds to 0 */
   if (seconds === 60) {
     seconds = 0;
     minutes = minutes + 1;
   }

   /* i used the javascript tenary operator to format
     how the minutes should look and add 0 to minutes if
     less than 10 */
   mins = minutes < 10 ? "0" + minutes + ": " : minutes + ": ";
   /* check if minutes is equal to 60 and add a +1
     to hours set minutes to 0 */
   if (minutes === 60) {
     minutes = 0;
     hours = hours + 1;
   }
   /* i used the javascript tenary operator to format
     how the hours should look and add 0 to hours if less than 10 */
   gethours = hours < 10 ? "0" + hours + ": " : hours + ": ";
   secs = seconds < 10 ? "0" + seconds : seconds;



  var xv = document.getElementById("timer"+yy);
   xv.innerHTML = gethours + mins + secs;

   /* call the seconds counter after displaying the Count-Up
     and increment seconds by +1 to keep it counting */
   seconds++;

   /* call the setTimeout( ) to keep the Count-Up alive ! */
   clearTime = setTimeout("startWatch("+yy+")", 1000);

 }

 //create a function to start the Count-Up
 function startTime() {
   var  zz  =  this.getAttribute('data-id');

   /* check if seconds, minutes, and hours are equal to zero
     and start the Count-Up */
   if (seconds === 0 && minutes === 0 && hours === 0) {
     /* hide the fulltime when the Count-Up is running */

     var fulltime = document.getElementById("fulltime"+zz);
     fulltime.style.display = "none";

     var showStart = document.getElementById("start"+zz);
     showStart.style.display = "none";


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
   var  sz  =  this.getAttribute('data-id');

 /* check if seconds, minutes and hours are not equal to 0 */
 if (seconds !== 0 || minutes !== 0 || hours !== 0) {
   var continueButton = document.getElementById("continue"+sz);
   continueButton.setAttribute("hidden", "true");
   var fulltime = document.getElementById("fulltime"+sz);
   fulltime.style.display = "block";
   fulltime.style.color = "#ff4500";
   var time = gethours + mins + secs;
   fulltime.innerHTML = "<p class ='timerecorder'>" + time + "</p>";
   // reset the Count-Up
   seconds = 0;
   minutes = 0;
   hours = 0;
   secs = "0" + seconds;
   mins = "0" + minutes + ": ";
   gethours = "0" + hours + ": ";

   /* display the Count-Up Timer after it's been stopped */
   var x = document.getElementById("timer"+sz);
   var stopTime = gethours + mins + secs;
   x.innerHTML = stopTime;
   $.ajax({


        type: 'POST',
        url: '{{ route('admin.subtasks.store_time') }}',
        data: {id: sz,time:time, _token: '{{ csrf_token() }}'},
        success: function (data) {

        }
    });
   var xv = document.getElementById("recodtime");
   xv.style.display = "block" ;
   xv.innerHTML = "<p> <i class='fa fa-check-circle'></i>Time Entery wurde erfolgreich erstellt - " + time +"</p>" ;
   setTimeout(()=>{
     xv.style.display = "none" ;
   } ,3000);

   /* display all Count-Up control buttons */
   var showStart = document.getElementById("start"+sz);
   showStart.style.display = "inline-block";
   var showStop = document.getElementById("stop"+sz);
   showStop.style.display = "inline-block";
   var showPause = document.getElementById("pause"+sz);
   showPause.style.display = "inline-block";

   /* clear the Count-Up using the setTimeout( )
       return value 'clearTime' as ID */
   clearTimeout(clearTime);
 }
 }


     var stopsection =  document.getElementsByClassName("stop");
     for(let i = 0; i < stopsection.length; i++) {
       stopsection[i].addEventListener("click", stopTime)
     }





 /*********** End of Stop Button Operations *********/

 /*********** Pause Button Operations *********/
 function pauseTime() {
       var  sm  =  this.getAttribute('data-id');

   if (seconds !== 0 || minutes !== 0 || hours !== 0) {
     /* display the Count-Up Timer after clicking on pause button */

     var continueButton = document.getElementById("continue"+sm);
     continueButton.removeAttribute("hidden");


     var xu = document.getElementById("timer"+sm);
     var stopTime = gethours + mins + secs;
     xu.innerHTML = stopTime;





     /* display all Count-Up control buttons */
     var showStop = document.getElementById("stop"+sm);
     showStop.style.display = "inline-block";
     /* clear the Count-Up using the setTimeout( )
         return value 'clearTime' as ID */
     clearTimeout(clearTime);
   }
 }


 var pausesection =  document.getElementsByClassName("pause");
 for(let i = 0; i < pausesection.length; i++) {
   pausesection[i].addEventListener("click", pauseTime)
 }

 /*********** End of Pause Button Operations *********/

 /*********** Continue Button Operations *********/
 function continueTime() {
   var  yu  =  this.getAttribute('data-id');

   if (seconds !== 0 || minutes !== 0 || hours !== 0) {
     /* display the Count-Up Timer after it's been paused */
     var x = document.getElementById("timer"+yu);
     var continueTime = gethours + mins + secs;
     x.innerHTML = continueTime;

     /* display all Count-Up control buttons */
     var showStop = document.getElementById("stop"+yu);
     showStop.style.display = "inline-block";
     /* clear the Count-Up using the setTimeout( )
         return value 'clearTime' as ID.
         call the setTimeout( ) to keep the Count-Up alive ! */
     clearTimeout(clearTime);
     clearTime = setTimeout("startWatch("+yu+")", 1000);
   }
 }

 window.addEventListener("load", function() {
     var continuetimesection =  document.getElementsByClassName("continue");
     for(let i = 0; i < continuetimesection.length; i++) {
       continuetimesection[i].addEventListener("click", continueTime)
     }
 });

 /*********** End of Continue Button Operations *********/

 </script>
