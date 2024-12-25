<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Pripo</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="" name="description">
  <meta content="" name="keywords">
 <!-- Favicons -->
  <link href="{{asset('public/assets/images/Pri-Po_logo_long3.png')}}" rel="icon">
  <link href="{{asset('public/assets/admin/assets2/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
 <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->

   <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <script src="{{asset('public/assets/admin/assets2/js/jquery-3.6.0.js')}}"></script>
  <link href="{{asset('public/assets/admin/assets2/vendor/animate.css/animate.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/admin/assets2/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/admin/assets2/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/admin/assets2/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/admin/assets2/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/admin/assets2/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/admin/assets2/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/admin/assets/css/forms/theme-checkbox-radio.css')}}">
     <link href="{{asset('public/assets/admin/plugins/loaders/custom-loader.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
     <script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>

    <link href="{{asset('public/assets/admin/assets2/css/style.css')}}" rel="stylesheet">
    <link rel="shortcut icon" href="'public/assets/images/shortcutimage.png"/>
    <link  rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link  rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">
    <script src="{{asset('public/assets/admin/assets2/js/dd.min.js')}}"></script>

    
    <style>
        .loading-page{
            background-color: #ffffff;
            z-index: 99999;
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .loader {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 160px;
            height: 160px;
            margin: -80px 0px 0px -80px;
            background-color: transparent;
            border-radius: 50%;
            border: 2px solid #E3E4DC;
        }
        .loader:before {
            content: "";
            width: 164px;
            height: 164px;
            display: block;
            position: absolute;
            border: 2px solid #898a86;
            border-radius: 50%;
            top: -2px;
            left: -2px;
            box-sizing: border-box;
            clip: rect(0px, 35px, 35px, 0px);
            z-index: 10;
            animation: rotate infinite;
            animation-duration: 3s;
            animation-timing-function: linear;
        }
        .loader:after {
            content: "";
            width: 164px;
            height: 164px;
            display: block;
            position: absolute;
            border: 2px solid #c1bebb;
            border-radius: 50%;
            top: -2px;
            left: -2px;
            box-sizing: border-box;
            clip: rect(0px, 164px, 150px, 0px);
            z-index: 9;
            animation: rotate2 3s linear infinite;
        }

        .hexagon-container {
            position: relative;
            top: 33px;
            left: 41px;
            border-radius: 50%;
        }

        .hexagon {
            position: absolute;
            width: 40px;
            height: 23px;
            background-color: #556C82;
        }
        .hexagon:before {
            content: "";
            position: absolute;
            top: -11px;
            left: 0;
            width: 0;
            height: 0;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-bottom: 11.5px solid #556C82;
        }
        .hexagon:after {
            content: "";
            position: absolute;
            top: 23px;
            left: 0;
            width: 0;
            height: 0;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-top: 11.5px solid #556C82;
        }

        .hexagon.hex_1 {
            top: 0px;
            left: 0px;
            animation: Animasearch 3s ease-in-out infinite;
            animation-delay: 0.2142857143s;
        }

        .hexagon.hex_2 {
            top: 0px;
            left: 42px;
            animation: Animasearch 3s ease-in-out infinite;
            animation-delay: 0.4285714286s;
        }

        .hexagon.hex_3 {
            top: 36px;
            left: 63px;
            animation: Animasearch 3s ease-in-out infinite;
            animation-delay: 0.6428571429s;
        }

        .hexagon.hex_4 {
            top: 72px;
            left: 42px;
            animation: Animasearch 3s ease-in-out infinite;
            animation-delay: 0.8571428571s;
        }

        .hexagon.hex_5 {
            top: 72px;
            left: 0px;
            animation: Animasearch 3s ease-in-out infinite;
            animation-delay: 1.0714285714s;
        }

        .hexagon.hex_6 {
            top: 36px;
            left: -21px;
            animation: Animasearch 3s ease-in-out infinite;
            animation-delay: 1.2857142857s;
        }

        .hexagon.hex_7 {
            top: 36px;
            left: 21px;
            animation: Animasearch 3s ease-in-out infinite;
            animation-delay: 1.5s;
        }

        @keyframes Animasearch {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            15%, 50% {
                transform: scale(0.5);
                opacity: 0;
            }
            65% {
                transform: scale(1);
                opacity: 1;
            }
        }
        @keyframes rotate {
            0% {
                transform: rotate(0);
                clip: rect(0px, 35px, 35px, 0px);
            }
            50% {
                clip: rect(0px, 40px, 40px, 0px);
            }
            100% {
                transform: rotate(360deg);
                clip: rect(0px, 35px, 35px, 0px);
            }
        }
        @keyframes rotate2 {
            0% {
                transform: rotate(0deg);
                clip: rect(0px, 164px, 150px, 0px);
            }
            50% {
                clip: rect(0px, 164px, 0px, 0px);
                transform: rotate(360deg);
            }
            100% {
                transform: rotate(720deg);
                clip: rect(0px, 164px, 150px, 0px);
            }
        }
        @keyframes rotate3 {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        .copy
        {
            background-color: #b4e1ed;
            padding: 3px;
            color: #fff;
            border-radius: 51%;
            height: 26px;
            width: 26px;
            font-size: 13px;
            margin-left: 7px;
        }

        .copy:hover {
            background-color: #001d57;
            color: #fff;
        }
            #timer_control{

        margin: 0;
        margin-top: -29px;
        padding: 0;
        height: 0;
        width: 0;
        margin-left: 6px;
        font-size: 20px;
                margin-right: 50px;

    }
       #timer_control i{

    color: #f00;
    margin-left: 10px;
    margin-top: 5 ;

    }
       .success-image1 ,
       .success-image2 ,
       .success-image3
       {
           position: absolute;
           left: 0;
           display: none;
           top: 50%;
           z-index: 2;
       }

    </style>
    @yield('css')
</head>
<body>

<div class="container">
    <div class="success-image1">
        <img src="{{asset('public/assets/images/users/success.gif')}}">
    </div>
    <div class="success-image2">
        <img src="{{asset('public/assets/images/users/success2.gif')}}">
    </div>
    <div class="success-image3">
        <img src="{{asset('public/assets/images/users/success3.gif')}}">
    </div>
    <div class="sidebar-model">
        <p>Loading</p>
    </div>



    <div class="modal fade" style="z-index: 150000" id="copy_subtask_modal" tabindex="1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tasks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body" id="copy_subtask_modal_body">
                </div>
            </div>
        </div>
    </div>

    <!-- fixed-top-->
@if(auth()->user()->role == 3)
    @include('admin.includes.guest_header')
@else
    @include('admin.includes.header')
@endif
<!-- ////////////////////////////////////////////////////////////////////////////-->
    @include('admin.includes.sidebar')
    <div class="loading-page">
        <div class="loader">
            <ul class="hexagon-container">
                <li class="hexagon hex_1"></li>
                <li class="hexagon hex_2"></li>
                <li class="hexagon hex_3"></li>
                <li class="hexagon hex_4"></li>
                <li class="hexagon hex_5"></li>
                <li class="hexagon hex_6"></li>
                <li class="hexagon hex_7"></li>
            </ul>
        </div>
    </div>
    @yield('content')

<!-- <div class="loading">

               <div class="spinner-border text-primary align-self-center">Loading...</div>

         </div> -->

    @include('admin.includes.footer')
</div>
</div>
<!-- Vendor JS Files -->

    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="{{asset('public/assets/admin/assets2/vendor/aos/aos.js')}}"></script>
    <script src="{{asset('public/assets/admin/assets2/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/assets/admin/assets2/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{asset('public/assets/admin/assets2/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('public/assets/admin/assets2/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{asset('public/assets/admin/assets2/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touch/1.1.0/jquery.touch.min.js"></script>
    <script src="{{asset('public/assets/admin/assets2/js/Sortable.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/gh/prashantchaudhary/ddslick@master/jquery.ddslick.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="{{ asset('public/assets/js/pusher.js') }}"></script>
    <script src="{{asset('public/assets/admin/assets2/js/main.js')}}"></script>
    <!--
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    -->
    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
        });
    </script>
<script>
$(document).ready(function () {



    var select = $('#categories_select').change(function (e) {

    });

        // make a a copy
        $('.copy').on('click', function () {
            var copy = $(this).data('id');
            Swal.fire({
                title: 'Soll eine Kopie erstellt werden? ',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonColor: '#013c60',
                confirmButtonText: 'Ja',
                denyButtonText: `Nein`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: '{{route('admin.tasks.copy')}}',   // need to create this post route
                        data: {copy: copy, _token: '{{ csrf_token() }}'},
                        cache: false,
                        success: function (data) {
                            Swal.fire('kopiert!', '', 'success')
                        },
                        error: function (jqXHR, status, err) {
                        }
                    });

                } else if (result.isDenied) {
                    Swal.fire('Änderungen werden nicht gespeichert', '', 'info')
                }
            });
        })


        // ajax setup form csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Enable pusher logging - don't include this in production


        Pusher.logToConsole = true;

        // var pusher = new Pusher("{{env("PUSHER_KEY")}}", { encrypted: true })
        var pusher = new Pusher('9ebfe213ba01f2ba5e4b', {

            //  cluster: 'mt1',
            encrypted: false
        });


        var channel = pusher.subscribe('my-channel');

        // alert(channel);
        var notificationsWrapper = $('.notfi');
        //var notificationsCountElem = notificationsToggle.find('span[data-count]');
//var notificationsCount = parseInt(notificationsCountElem.data('count'));
        var notifications = notificationsWrapper.find('#notifayitems');

// Bind a function to a Event (the full Laravel class)
        channel.bind('App\\Events\\NewNotification', function (data) {
            var existingNotifications = notifications.html();


            if (data.catid == null) {
                var imgg = "{!! asset('public/assets/images/users') !!}";
                var newNotificationHtml = '<div class="notfi-notifications-item">' + '<a href="" class="btn-task-popup" data-id="' + data.taskid + '">'

                    + '<div class="display-flex">'
                    + '<img src="' + imgg + "/" + data.userimage + '"  alt="img">'
                    + '<h2>' + data.username + '</h2>'
                    + '</div>'
                    + '<div class="text">'
                    + '<p>' + data.desc + '</p>'
                    + '</div>'
                    + '</a></div>';
            } else {
                var newNotificationHtml = '<div class="notfi-notifications-item">' + '<a href="{{route('admin.categories')}}">'


                    + '<img src="' + imgg + "/" + data.userimage + '"  alt="img">' +

                    '<div class="text">' +
                    '<h4>' + data.username + '</h4>' +
                    '<p>' + data.desc + '</p>' +
                    '</div>' +
                    '</a></div>';
            }
            notifications.html(newNotificationHtml + existingNotifications);
            // notificationsCount += 1;
            // notificationsCountElem.attr('data-count', notificationsCount);
            // notificationsWrapper.find('.notif-count').text(notificationsCount);
            // notificationsWrapper.show();


        });



});

</script>
<script src="{{ asset('public/assets/js/replayNotifications.js') }}"></script>
<script src="{{ asset('public/assets/js/commentsnotificaction.js') }}"></script>
        <script>
            $(function () {
                $('[data-toggle="popover"]').popover()
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
                "<i data-id='"+x+"' class='bi bi-stop-circle stotime_con'></i>" ;

        }
        function startWatch(rr){
            yy = rr ;

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


        var xv = document.getElementsByClassName("timer" + yy);
        for (var xd = 0; xd < xv.length; xd++) {
            if (xv[xd]) {
                xv[xd].innerHTML = gethours + mins + secs;
                xv[xd].style.backgroundColor = '#198754FF';
            }
        }

            var re = document.getElementsByClassName("start");
            for (var r = 0; r < re.length; r++) {
                if (re[r]) {
                    re[r].style.display = 'none';
                }
            }


        var toptimer = document.getElementsByClassName('tasktimer2');
        for (var z = 0; z < toptimer.length; z++) {
            if (toptimer[z]) {
                toptimer[z].innerHTML = "<i class='bi bi-alarm '></i> " + gethours + mins + secs;

            }
        }

        var timer_text = gethours + mins + secs;
        //Diffrence  Between To  Dates And Time

        seconds++;

    }

    //create a function to start the Count-Up
    function startTime() {
            var zz = this.getAttribute('data-id')
        $.ajax({
            type: 'POST',
            url: '{{ route('admin.subtasks.starttime') }}',
            data: {task_id: zz, _token: '{{ csrf_token() }}'},
            success: function (data) {
                // Diffrence

            }
        });


        /* check if seconds, minutes, and hours are equal to zero
          and start the Count-Up */
        if (seconds === 0 && minutes === 0 && hours === 0) {
            /* hide the fulltime when the Count-Up is running */

            var fulltime = document.getElementsByClassName("fulltime" + zz);
            for (var i = 0; i < fulltime.length; i++) {
                fulltime[i].style.display = "none";
            }
            var showStart = document.getElementsByClassName("start" + zz);
            for (var b = 0; b < fulltime.length; b++) {
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

             startWatch(zz);
             clearTime = setInterval("startWatch(" + zz + ")", 1000);
             setInterval(() => {
                setheadertimer(yy);
                var stopicon = document.getElementsByClassName("stotime_con");
                for (var h = 0; h < stopicon.length; h++) {
                stopicon[h].addEventListener("click", stopTime);
                }

           }, 1000);

            //end start watch


        }
    }

    var userSelection = document.getElementsByClassName("start");
    for (let i = 0; i < userSelection.length; i++) {
        userSelection[i].addEventListener("click", startTime)
    }


    /*create a function to stop the time */
    function stopTime() {

        sz = this.getAttribute('data-id');
        /* check if seconds, minutes and hours are not equal to 0 */
        if (seconds !== 0 || minutes !== 0 || hours !== 0) {
            var continueButton = document.getElementsByClassName("continue" + sz);
            for (var i = 0; i < continueButton.length; i++) {
                continueButton[i].setAttribute("hidden", "true");
            }

            var time = gethours + mins + secs;
            var fulltime = document.getElementsByClassName("fulltime" + sz);
            for (var v = 0; v < fulltime.length; v++) {
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
        var x = document.getElementsByClassName("timer" + sz);
        var stopTime = gethours + mins + secs;

        for (var r = 0; r < x.length; r++) {
            x[r].innerHTML = stopTime;
        }
        $.ajax({
            type: 'POST',
            url: '{{ route('admin.subtasks.store_time') }}',
            data: {id: sz, time: time, _token: '{{ csrf_token() }}'},
            success: function (data) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Time Entery wurde erfolgreich erstellt :'+ time ,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        });


        /* display all Count-Up control buttons */
        var showStart = document.getElementsByClassName("start" + sz);
        for (var it = 0; it < showStart.length; it++) {
            showStart[it].style.display = "inline-block";
        }


        var showStop = document.getElementsByClassName("stop" + sz);
        for (var iq = 0; iq < showStop.length; iq++) {
            showStop[iq].style.display = "inline-block";
        }
        var showPause = document.getElementsByClassName("pause" + sz);
        for (var ih = 0; ih < showPause.length; ih++) {
            showPause[ih].style.display = "inline-block";
        }

        /* clear the Count-Up using the setTimeout( )
            return value 'clearTime' as ID */
        clearInterval(clearTime);
        setTimeout(()=>{
            location.reload();
        }, 2000)
    }

    window.addEventListener("load", function () {
        var stopsection = document.getElementsByClassName("stop");
        for (let i = 0; i < stopsection.length; i++) {
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

                var ty = document.getElementsByClassName("continue" + sm);
                for(var ie = 0 ;  ie < ty.length ; ie++) {
                     ty[ie].style.display = "none";
                }


                var continuebutton  = document.getElementsByClassName("continue" + sm);
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

            var continueeime = gethours + mins + secs;
            var x = document.getElementsByClassName("timer"+yu);
            for (let i = 0; i < x.length; i++) {
                x[i].innerHTML = continueeime;
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
            startTime(yu) ;

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

    $(document).on('click', '.dismiss', function () {
        $('.sidebar').css({'width': '0'});
        $('.sidebar-model').css({'width': '0'});
        $('.sidebar-model').empty() ;
        $('.sidebar-model').html('<p>Loading</p>') ;
        $('.overlay').css('display', 'none');
    });

    $(document).on('click', '.overlay', function () {
        $('.sidebar').css({'width': '0'});
        $('.sidebar-model').css({'width': '0'});
        $('.sidebar-model').empty() ;
        $('.sidebar-model').html('<p>Loading</p>') ;
        $('.overlay').css('display', 'none');
    });


    $(document).ready(function () {
        $(document).on('click', '.btn-task-popup', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            $(".sidebar-model").css({'width': '50%'});
            var type = '1';
            $.ajax({
                type: "post",
                url: "{{route('admin.get.task_data')}}", // need to create this post route
                data: {id: id, type: type, _token: '{{ csrf_token() }}'},
                cache: false,
                success:  function (data) {
                    $('.overlay').css('display', 'block');
                    $(".sidebar-model").html( data);
                    $('#tasks').modal('show');
                },

                error: function (jqXHR, status, err) {
                },
            });

            var log = $(this).data('log');

            //alert(id);

            if (log) {
                $.ajax({
                    type: "post",
                    url: "{{route('admin.update_log_read')}}", // need to create this post route
                    data: {log: log, _token: '{{ csrf_token() }}'},
                    cache: false,
                    success: function (data) {

                    },
                    error: function (jqXHR, status, err) {
                    },
                });

            }


        });


        $(document).on('click', '.btn-task-popup2', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            var type = '2';
            $.ajax({
                type: "post",
                url: "{{route('admin.get.task_data')}}", // need to create this post route
                data: {id: id, type: type, _token: '{{ csrf_token() }}'},
                cache: false,
                success: function (data) {

                    $('#tasks').modal('show');
                    $(".sidebar-model").html(data);
                    $(".sidebar-model").css({'width': '50%'});
                },
                error: function (jqXHR, status, err) {
                },
            });


        });

    });
   //Display  Popup of  the  replayment and  coomment
    $(document).ready(function () {


        $(document).on('click', '.btn-task-replaycomment', function (event) {
                    event.preventDefault();
                    var id = $(this).data('id');
                    $(".sidebar-model").css({'width': '50%'});
                    var comment_id  = $(this).data('comment') ;
                    var replay_id  =  $(this).data('replay') ;
                    var done =    $(this).data('done') ; 
                    var type = '1';
                    $.ajax({
                        type: "post",
                        url: "{{route('admin.get.task_data')}}", // need to create this post route
                        data: {id: id, type: type, _token: '{{ csrf_token() }}'},
                        cache: false,
                        success:  function (data) {
                            $(".sidebar-model").css({'width': '50%'});
                            $('#tasks').modal('show');
                            $('.overlay').css('display', 'block');
                            $(".sidebar-model").html(data);
                            if(done == 1 )
                            {
                                $('.uncompleted_comments').css("display", "none");
                                $('.completed_comments').css("display", "block");
                                $('.add_new_replay'+$(this).data('replay')).css("display" , "block") ;
                            }
                            $('.reply-list'+comment_id).css("display", "block");
                            $('.comment-box'+replay_id+' .comment-name a').css('color' , '#ff5722');
                            $('.comment-box'+replay_id).css('background-color' , '#017ac717');
                            $('#sidebarMenu').animate({
                                scrollTop: $('.comment-box'+replay_id).offset().top
                            }, 1000);

                        },
                        error: function (jqXHR, status, err) {
                        },
                    });
            });
        //Make Replay Is Seen on Notifaction

        $(document).on('click', '.btn-task-replaycommentNotifaction', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            $(".sidebar-model").css({'width': '50%'});
            var done =    $(this).data('done') ; 
            var comment_id  = $(this).data('comment') ;
            var replay_id  =  $(this).data('replay') ;
            var type = '1';
            $.ajax({
                type: "post",
                url: "{{route('admin.get.task_data')}}", // need to create this post route
                data: {id: id, type: type, _token: '{{ csrf_token() }}'},
                cache: false,
                success:  function (data) {
                    $(".sidebar-model").css({'width': '50%'});
                    $('#tasks').modal('show');
                    $('.overlay').css('display', 'block');
                    $(".sidebar-model").html(data);
                    if(done == 1 )
                            {
                                $('.uncompleted_comments').css("display", "none");
                                $('.completed_comments').css("display", "block");
                                $('.add_new_replay'+$(this).data('replay')).css("display" , "block") ;
                            }
                    $('.reply-list'+comment_id).css("display", "block");
                    $('.comment-box'+replay_id+' .comment-name a').css('color' , '#ff5722');
                    $('.comment-box'+replay_id).css('background-color' , '#017ac717');
                    $('#sidebarMenu').animate({
                        scrollTop: $('.comment-box'+replay_id).offset().top
                    }, 1000);
                    /* Make Is Seen */
                        $.ajax({
                            type: "post",
                            url: "{{route('admin.update_replay_readnotify')}}", // need to create this post route
                            data: {replay_id: replay_id , _token: '{{ csrf_token() }}'},
                            cache: false,
                            success: function (data) {

                            },
                            error: function (jqXHR, status, err) {
                            }
                        });
                },
                error: function (jqXHR, status, err) {
                },
            });
        });

        //End Make Replay Is Seen on Notifaction
        $(document).on('click', '.btn-task-popup2', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            var type = '2';
            $.ajax({
                type: "post",
                url: "{{route('admin.get.task_data')}}", // need to create this post route
                data: {id: id, type: type, _token: '{{ csrf_token() }}'},
                cache: false,
                success: function (data) {

                    $('#tasks').modal('show');
                    $(".sidebar-model").html(data);
                    $(".sidebar-model").css({'width': '50%'});
                },
                error: function (jqXHR, status, err) {
                },
            });


        });

    });

    // Click On Comment To Scroll
    $(document).ready(function () {
        $(document).on('click', '.btn-task-comments', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            var comment_id  = $(this).data('comment') ;
            var type = '1';
            $.ajax({
                type: "post",
                url: "{{route('admin.get.task_data')}}", // need to create this post route
                data: {id: id, type: type, _token: '{{ csrf_token() }}'},
                cache: false,
                success:  function (data) {
                    $('#tasks').modal('show');
                    $('.overlay').css('display', 'block');
                    $(".sidebar-model").html( data);
                    $(".sidebar-model").css({'width': '50%'});
                    $('#sidebarMenu').animate({
                        scrollTop: $('.comments-list'+comment_id).offset().top
                    }, 1000);
                   $('#comment_name'+comment_id).parent('.comment-content').css('background-color' , 'rgb(1 122 199 / 9%)');
                    $.ajax({
                        type: "post",
                        url: "{{route('admin.update_comment_read')}}", // need to create this post route
                        data: {comment_id: comment_id, _token: '{{ csrf_token() }}'},
                        cache: false,
                        success: function (data) {

                        },
                        error: function (jqXHR, status, err) {
                        },
                    });
                },
                error: function (jqXHR, status, err) {
                },
            });

        });


        $(document).on('click', '.btn-task-popup2', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            var type = '2';
            $.ajax({
                type: "post",
                url: "{{route('admin.get.task_data')}}", // need to create this post route
                data: {id: id, type: type, _token: '{{ csrf_token() }}'},
                cache: false,
                success: function (data) {

                    $('#tasks').modal('show');
                    $(".sidebar-model").html(data);
                    $(".sidebar-model").css({'width': '50%'});
                },
                error: function (jqXHR, status, err) {
                },
            });


        });

    });


</script>

<script>
    $(document).ready(function () {
        $(document).on('click', '#links li a', function (event) {

            event.preventDefault();
            var type = $(this).data('type');
            // alert(type);
            $.ajax({
                type: "post",
                url: "{{route('admin.get.create_view')}}", // need to create this post route
                data: {type: type, _token: '{{ csrf_token() }}'},
                cache: false,
                success: function (data) {
                    $('#tasks').modal('show');
                    $(".sidebar-model").html(data);
                    $(".sidebar-model").css({'display': 'block', 'width': '50%'});
                },
                error: function (jqXHR, status, err) {
                },
            });
        });

        $(document).on('click', '#update_profile', function (event) {

            event.preventDefault();
            var type = $(this).data('type');
            // alert(type);
            $.ajax({
                type: "post",
                url: "{{route('admin.get.create_view')}}", // need to create this post route
                data: {type: type, _token: '{{ csrf_token() }}'},
                cache: false,
                success: function (data) {
                    $('#tasks').modal('show');
                    $(".sidebar-model").html(data);
                    $(".sidebar-model").css({'display': 'block', 'width': '50%'});
                },
                error: function (jqXHR, status, err) {
                },
            });
        });

        $(document).on('click', '#popup_button', function () {
            $.ajax({
                type: 'POST',
                url: '{{route('admin.change_user_login_status')}}',
                data: {

                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {

                    $("#online_users").html(data.options);

                    //alert('success');

                }, error: function (reject) {
                }
            }); // end ajax

            $('#myModal').modal('hide');
        });
    });


</script>


<script>

    $(document).ready(function () {


        var down = false;

        $('#notfi-bell').click(function (e) {

            var color = $(this).text();
            if (down) {
                $('#notfi-box').css('display', 'none');
                $('#notfi-box').css('height', '0px');
                $('#notfi-box').css('opacity', '0');
                down = false;
            } else {

                $('#notfi-box').css('height', 'auto');
                $('#notfi-box').css('display', 'block');
                $('#notfi-box').css('opacity', '1');
                down = true;

            }

        });

    });

</script>


<script>

    function updateLoginStatus() {

        $.ajax({
            type: 'POST',
            url: '{{route('admin.update_user_login_status')}}',
            data: {

                _token: '{{ csrf_token() }}'
            },
            success: function (data) {

                $("#online_users").html(data.options);

                //alert('success');

            }, error: function (reject) {
            }
        }); // end ajax
    }

</script>


<script>
    $('.notfi-notifications-item').on('click', function () {
        $(this).css('display', 'none');
        $('#notfi-box').css('height', '0px');
        $('#notfi-box').css('opacity', '0');
        down = false;
    });
</script>

<script>
    $(window).on("load", function () {
        $(".loading-page").fadeOut(2000);
    });

</script>

<!--Notifaction -->
<script>

    $('.notfi-icon').on('click', function (e) {
        $('.notfi-notifications').toggle();
        $('.notifi-box').css('display','none');
        e.stopPropagation();
    });

    $('.replay_icon').on('click', function (e) {
        $('.notifi-box').toggle();
        $('.notfi-notifications').css('display','none');
        e.stopPropagation();
    });

   /*
    $(document).on('click', function (e) {
        if ($(e.target).is('.notfi-icon') == false) {
            $('.notfi-notifications').css({'display': 'none', 'opacity': '0'});
        }
    });

*/


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

                if (data) {
                    if (data['timer'] == 1) {

                        $('.timer' + data['id']).css({'background-color': '#198754', 'color': '#fff'});
                        $('.start').css({'display': 'none'});
                        $('.pause').css({'display': 'none'});
                        $('.stop').css({'display': 'none'});
                        $('.pause' + data['id']).css('display', 'inline-block');
                        $('.stop' + data['id']).css('display', 'inline-block');
                        $('#toptimer').attr('data-bs-original-title', data['subtask_title']);
                        seconds = setseconds;
                        minutes = setminutes;
                        hours = sethours;
                        clearInterval(clearTime);
                        clearTime = setInterval("startWatch(" + data['id'] + ")", 1000);
                        setInterval(() => {
                            setheadertimer(data['id']);
                            var stopicon = document.getElementsByClassName("stotime_con");
                            for (var h = 0; h < stopicon.length; h++) {
                                stopicon[h].addEventListener("click", stopTime);
                            }
                        }, 1000);
                    }
                } else {

                    $('.user_subtasks .stop').each(function () {
                        $(this).css('display', 'none');
                    });
                    $('.user_subtasks .pause').each(function () {
                        $(this).css('display', 'none');
                    });
                }
            }
    });

    });
</script>

@yield('script')
</body>
</html>
