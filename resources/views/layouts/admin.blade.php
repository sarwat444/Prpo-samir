
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title> Pripo  Crm </title>
    <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
     <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- Bootstrap Css -->
   <link href="{{asset('public/public/assets/crm/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
     <link href="{{asset('public/public/assets/crm/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
    <link href="{{asset('public/public/assets/crm/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')
</head>
<body data-sidebar="dark">

<!-- <body data-layout="horizontal" data-topbar="dark"> -->

<!-- Begin page -->
<div id="layout-wrapper">

        @include('admin.includes.header3')
        @include('admin.includes.sidebar2')
        @yield('content')

        @include('admin.includes.footer2')

        <script src="{{asset('public/public/assets/crm/libs/jquery/jquery.min.js')}} "></script>

        <script src="{{asset('public/public/assets/crm/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

        <script src="{{asset('public/public/assets/crm/libs/metismenu/metisMenu.min.js')}}"></script>

        <script src="{{asset('public/public/assets/crm/libs/simplebar/simplebar.min.js')}}"></script>

        <script src="{{asset('public/public/assets/crm/libs//node-waves/waves.min.js')}}"></script>
        <!-- apexcharts -->
        <script src="{{asset('public/public/assets/crm/libs/apexcharts/apexcharts.min.js')}}"></script>
        <!-- dashboard init -->
        <script src="{{asset('public/public/assets/crm/js/pages/dashboard.init.js')}}"></script>
        <!-- App js -->
        <script src="{{asset('public/public/assets/crm/js/app.js')}}"></script>

        <!--Start Timer-->
           <script>
            $(document).ready(function () {
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

                    var xv = document.getElementsByClassName("Timer"+ yy);
                    for (var xd = 0; xd < xv.length; xd++) {
                        if (xv[xd]) {
                            xv[xd].innerHTML = gethours + mins + secs;
                        }
                    }

                    seconds++;

                }

                document.addEventListener('visibilitychange', function() {
                    if(document.hidden) {
                        console.log('tab is now inactive');
                    }
                    else {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.subtasks.get_timers') }}',
                            data: {_token: '{{ csrf_token() }}'},
                            success: function (data) {

                                for(var i=0 ; i < data.timer_data.length ; i ++)
                                {
                                    var task_id  = data.timer_data[i].id;
                                    if (task_id) {
                                        if (data.timer_data[i].timer  == 1) {
                                            var xv = document.getElementsByClassName("Timer"+ task_id);
                                            for (var xd = 0; xd < xv.length; xd++) {
                                                if (xv[xd]) {
                                                    xv[xd].innerHTML = data.timer_data[i].hours +':'+ data.timer_data[i].minutes +':'+ data.timer_data[i].seconds;
                                                }
                                            }
                                        }
                                    }
                                }

                            }
                        });


                    }
                });


       /* Inital Time  */
                // Dashboard Timer
                $(document).ready(function () {

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('admin.subtasks.get_timers') }}',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (data) {

                               for(var i=0 ; i < data.timer_data.length ; i ++)
                               {
                                   var task_id  = data.timer_data[i].id;
                               if (task_id) {
                                   if (data.timer_data[i].timer  == 1) {
                                       var xv = document.getElementsByClassName("Timer"+ task_id);
                                       for (var xd = 0; xd < xv.length; xd++) {
                                           if (xv[xd]) {
                                               xv[xd].innerHTML = data.timer_data[i].hours +':'+ data.timer_data[i].minutes +':'+ data.timer_data[i].seconds;
                                           }
                                       }
                                   }
                               }
                               }

                        }
                    });

                });



            });


        </script>
        <!--End Timer-->
      @yield('script')
</body>
</html>
