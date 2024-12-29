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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo" rel="stylesheet">
    <link  rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" ref="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Include Chosen library and CSS from CDN -->
    <!-- Include Selectize.js library and CSS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/selectize@0.12.6/dist/css/selectize.default.min.css">
    <script src="https://cdn.jsdelivr.net/npm/selectize@0.12.6/dist/js/standalone/selectize.min.js"></script>



    <link href="{{asset('public/assets/admin/assets2/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/admin/assets2/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/admin/assets2/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/admin/assets2/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/admin/assets2/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/assets/admin/assets2/css/jquery-ui.css')}} ">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/admin/assets/css/forms/theme-checkbox-radio.css')}}">
    <link href="{{asset('public/assets/admin/plugins/loaders/custom-loader.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/admin/assets2/css/jquery.dataTables.min.css')}}">
    <link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/assets/admin/assets2/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/admin/assets2/css/main_components.css')}}" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('public/assets/admin/assets2/images/shortcutimage.png')}}"/>
    <link  rel="stylesheet" href="{{asset('public/assets/admin/assets2/css/animate.min.css')}}"/>
    <link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">
    <script src="{{asset('public/assets/admin/assets2/js/dd.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('public/assets/admin/assets2/css/dashboardstyle.css')}}">
    <script src="{{asset('assets/admin/assets2/js/sweetalert.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/admin/assets2/css/theme-checkbox-radio.css')}}">
    <link href="{{asset('public/assets/admin/assets2/css/mattarialicon.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/admin/assets2/css/theme-checkbox-radio.css')}}">
    <link href="{{asset('public/assets/admin/assets2/css/mattarialicon.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <!--Drag And Drop Images -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.min.js"></script>
    @yield('css')
</head>
<body>
<div class="container-fluid">
    <!--Tasks Success Images -->
    <div class="success-image1">
        <img src="{{asset('public/assets/images/users/success.gif')}}">
    </div>
    <div class="success-image2">
        <img src="{{asset('public/assets/images/users/success2.gif')}}">
    </div>
    <div class="success-image3">
        <img src="{{asset('public/assets/images/users/success3.gif')}}">
    </div>
    <!--End Tasks Success Images -->

    <!--Loading  -->
    <div class="sidebar-model">
        <article class="background">
            <div class="a"></div>
            <div class="b"></div>
            <div class="c"></div>
            <div class="d"></div>
            <div class="e"></div>
            <div class="f"></div>
            <div class="g"></div>
            <div class="h"></div>
            <div class="i"></div>
            <div class="j"></div>
            <div class="k"></div>
            <div class="l"></div>
        </article>
    </div>

    <!--End Loading  -->
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
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>



    @yield('content')
    @include('admin.includes.footer')
</div>
</div>
<!-- Vendor JS Files -->
<script src="{{asset('public/assets/admin/assets2/js/jquery-ui.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/vendor/aos/aos.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/js/sweetalert2@11.js')}}"></script>
<script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/vendor/php-email-form/validate.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/js/Sortable.min.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/js/jquery.ddslick.min.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/js/main.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/js/dashboardscript.js')}}"></script>


<script>
    $(document).ready(function () {


        var select = $('#categories_select').change(function (e) {});
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
    });

</script>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
        document.addEventListener('visibilitychange', function() {
            if(document.hidden) {
                // tab is now inactive
                // temporarily clear timer using clearInterval() / clearTimeout()

                console.log('tab is now inactive');

            }
            else {
                // tab is active again
                // restart timers
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


            }
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
            "<i data-id='"+x+"' class='fa fa-stop stotime_con'></i>" ;

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
                toptimer[z].innerHTML =  gethours + mins + secs + "  <i class='bi bi-alarm '></i>";

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
    $(document).ready(function () {

        $(document).on('click', '.dismiss', function () {
            $('.sidebar').css({'width': '0'});
            $('.sidebar-model').css({'width': '0'});
            $('.sidebar-model').empty() ;
            $('.sidebar-model').html("<article class='background'> <div class='a'></div> <div class='b'></div> <div class='c'></div> <div class='d'></div> <div class='e'></div> <div class='f'></div> <div class='g'></div> <div class='h'></div> <div class='i'></div> <div class='j'></div> <div class='k'></div> <div class='l'></div> </article>") ;
            $('.overlay').css('display', 'none');
            $('body').css('overflow-y', 'scroll');

        });

        $(document).on('click', '.overlay', function () {
            $('.sidebar').css({'width': '0'});
            $('.sidebar-model').css({'width': '0'});
            $('.sidebar-model').empty() ;
            $('.sidebar-model').html("<article class='background'> <div class='a'></div> <div class='b'></div> <div class='c'></div> <div class='d'></div> <div class='e'></div> <div class='f'></div> <div class='g'></div> <div class='h'></div> <div class='i'></div> <div class='j'></div> <div class='k'></div> <div class='l'></div> </article>") ;
            $('.overlay').css('display', 'none');
            $('body').css('overflow-y', 'scroll');
        });

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
                    $('body').css('overflow' , 'hidden') ;
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

                        $.ajax({
                            url:'{{route('admin.comments.viewreplays')}}' ,
                            type:'post' ,
                            data:{comment_id: comment_id , _token: '{{ csrf_token() }}'} ,
                            cache: false,
                            success:function (data)
                            {
                                $('#replyalist'+comment_id).html(data.options);
                                $('#replyalist'+comment_id).toggle() ;
                                $('.comment-box'+replay_id+' .comment-name a').css('color' , '#ff5722');
                                $('.comment-box'+replay_id).css('background-color' , '#017ac717');
                                $('#sidebarMenu').animate({
                                    scrollTop: $('.comment-box'+replay_id).offset().top
                                }, 500);
                            },
                            error:function ()
                            {
                            }
                        });
                    }else {

                        /* View All Replays */
                        $.ajax({
                            url: '{{route('admin.comments.viewreplays')}}',
                            type: 'post',
                            data: {comment_id: comment_id, _token: '{{ csrf_token() }}'},
                            cache: false,
                            success: function (data) {
                                $('#replyalist' + comment_id).html(data.options);
                                $('#replyalist' + comment_id).toggle();
                                $('.comment-box' + replay_id + ' .comment-name a').css('color', '#ff5722');
                                $('.comment-box' + replay_id).css('background-color', '#017ac717');
                                $('#sidebarMenu').animate({
                                    scrollTop: $('.comment-box' + replay_id).offset().top
                                }, 500);

                            },
                            error: function () {
                            }
                        });

                    }
                    $('.add_new_replay' + comment_id).css("display", "block");


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

                        $.ajax({
                            url:'{{route('admin.comments.viewreplays')}}' ,
                            type:'post' ,
                            data:{comment_id: comment_id , _token: '{{ csrf_token() }}'} ,
                            cache: false,
                            success:function (data)
                            {
                                $('#replyalist'+comment_id).html(data.options);
                                $('#replyalist'+comment_id).toggle() ;
                                $('.comment-box'+replay_id+' .comment-name a').css('color' , '#ff5722');
                                $('.comment-box'+replay_id).css('background-color' , '#017ac717');
                                $('#sidebarMenu').animate({
                                    scrollTop: $('.comment-box'+replay_id).offset().top
                                }, 500);
                            },
                            error:function ()
                            {
                            }
                        });
                    }
                    else
                    {

                        $.ajax({
                            url: '{{route('admin.comments.viewreplays')}}',
                            type: 'post',
                            data: {comment_id: comment_id, _token: '{{ csrf_token() }}'},
                            cache: false,
                            success: function (data) {
                                $('#replyalist' + comment_id).html(data.options);
                                $('#replyalist' + comment_id).toggle();
                                $('.comment-box' + replay_id + ' .comment-name a').css('color', '#ff5722');
                                $('.comment-box' + replay_id).css('background-color', '#017ac717');
                                $('#sidebarMenu').animate({
                                    scrollTop: $('.comment-box' + replay_id).offset().top
                                }, 500);

                            },
                            error: function () {
                            }
                        });
                    }
                    $('.add_new_replay'+comment_id).css("display" , "block") ;
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

        //Comments Notification
        $(document).on('click', '.btn_comments_notifactions', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            var comment_id  = $(this).data('comment') ;
            var type = '1';
            $(".sidebar-model").css({'width': '50%'});
            var done =    $(this).data('done') ;

            $.ajax({
                type: "post",
                url: "{{route('admin.get.task_data')}}", // need to create this post route
                data: {id: id, type: type , comment_id : comment_id , _token: '{{ csrf_token() }}'},
                cache: false,
                success:  function (data) {
                    $('#tasks').modal('show');
                    $('.overlay').css('display', 'block');
                    $(".sidebar-model").html( data);
                    if(done == 1 )
                    {
                        $('.uncompleted_comments').css("display", "none");
                        $('.completed_comments').css("display", "block");

                    }
                    $('#sidebarMenu').animate({
                        scrollTop: $('.comments-list'+comment_id).offset().top
                    }, 1000);
                    $('#comment_name'+comment_id).parent('.comment-content').css('background-color' , 'rgb(1 122 199 / 9%)');


                    $.ajax({
                        type: "post",
                        url: "{{route('admin.update_comment_readnotify')}}", // need to create this post route
                        data: {comment_id: comment_id , _token: '{{ csrf_token() }}'},
                        cache: false,
                        success: function (data) {
                           console.log('updated') ;
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
        $(document).on('click', '.float-action-button  a', function (event) {
            event.preventDefault();
            var type = $(this).data('type');
            // alert(type);
            $.ajax({
                type: "post",
                url: "{{route('admin.get.create_view')}}", // need to create this post route
                data: {type: type, _token: '{{ csrf_token() }}'},
                cache: false,
                success: function (data) {
                    $(".overlay").css('display' , 'block');
                    $('#tasks').modal('show');
                    $(".sidebar-model").html(data);
                    $(".sidebar-model").css({'display': 'block', 'width': '50%'});
                    $('body').css('overflow' , 'hidden') ;
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
                    $(".overlay").css('display' , 'block');
                    $('#tasks').modal('show');
                    $(".sidebar-model").html(data);
                    $(".sidebar-model").css({'display': 'block', 'width': '50%'});
                    $('body').css('overflow' , 'hidden') ;
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
        $('body').addClass('loaded');
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
</script>
<script>

    setInterval(()=> {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: '{{__('messages.still_online')}}',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '{{__('messages.yes')}}',
            cancelButtonText: '{{__('messages.no')}}',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
            } else
            {
                window.location.href = "{{route('admin.logout')}}" ;
            }
        })
    }, 3600000);
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
<script>
    // Auto-hide the success message after 4 seconds

    setTimeout(() => {
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 4000); // 4000ms = 4 seconds
</script>

<script>
    // click on idea card popup
    $(document).on('click', '.btn-idea-popup', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            type: "post",
            url: "{{route('admin.get_idea_task_data')}}",
            data: {id : id , _token : '{{ csrf_token() }}'},
            cache: false,
            success: function (data) {
                $('#tasks').modal('show');
                $('.overlay').css('display' ,'block');
                $(".sidebar-model").html(data);
                $(".sidebar-model").css({'width':'50%'}) ;
            },
            error: function (jqXHR, status, err) {
            },
        });
    });
</script>

@yield('script')
</body>
</html>
