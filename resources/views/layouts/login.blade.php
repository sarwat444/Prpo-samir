<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>pripo</title>
    <link rel="icon" type="image/x-icon" href="{{asset('public/assets/img/favicon.ico')}}"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="{{asset('public/assets/admin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/assets/admin/assets/css/authentication/form-1.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/admin/assets/css/forms/theme-checkbox-radio.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/admin/assets/css/forms/switches.css')}}">
     <link rel="stylesheet" type="text/css" href="{{asset('public/assets/admin/assets/css/style.css')}}">
         <script src="{{asset('public/assets/admin/assets/js/libs/jquery-3.1.1.min.js')}}"></script>
</head>
<body class="form">


    <div class="form-container">
          @yield('content')
    </div>


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->

    <script src="{{asset('public/assets/admin/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('public/assets/admin/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{asset('public/assets/admin/assets/js/authentication/form-1.js')}}"></script>
     @stack('scripts')
    <script>
        /*global $, document, window, setTimeout, navigator, console, location*/
        $(document).ready(function () {

            'use strict';
            var usernameError = true,
                emailError    = true,
                passwordError = true,
                passConfirm   = true;

            // Label effect
            $('input').focus(function () {
                $(this).siblings('label').addClass('active');
            });

            // Form validation
            $('input').blur(function () {

                // User Name
                if ($(this).hasClass('name')) {
                    if ($(this).val().length === 0) {
                        $(this).siblings('span.error').text('Please type your full name').fadeIn().parent('.form-group').addClass('hasError');
                        usernameError = true;
                    }  else {
                        $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                        usernameError = false;
                    }
                }
                // Email
                if ($(this).hasClass('email')) {
                    if ($(this).val().length == '') {
                        $(this).siblings('span.error').text('Please type your email address').fadeIn().parent('.form-group').addClass('hasError');
                        emailError = true;
                    } else {
                        $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                        emailError = false;
                    }
                }

                // PassWord
                if ($(this).hasClass('pass')) {
                    if ($(this).val().length === 0) {
                        $(this).siblings('span.error').text('Password Required ').fadeIn().parent('.form-group').addClass('hasError');
                        passwordError = true;
                    } else {
                        $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                        passwordError = false;
                    }
                }


                // label effect
                if ($(this).val().length > 0) {
                    $(this).siblings('label').addClass('active');
                } else {
                    $(this).siblings('label').removeClass('active');
                }
            });

        });


   </script>

</body>
</html>
