@extends('layouts.login')
@section('title','Login')
@section('content')
    <style>
        body {
            background: #013c60;
        }


        input {
            outline: none !important;
        }

        h1 {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 40px;
            font-weight: 700;
        }

        .login-form h2 {
            color: #013c60;
            font-size: 21px;
        }

        .login-form p {
            color: #777;
            text-align: center;
        }

        section#formHolder {
            padding: 50px 0;
        }

        .brand {
            padding: 20px;
            background: url(https://goo.gl/A0ynht);
            background-size: cover;
            background-position: center center;
            color: #fff;
            min-height: 540px;
            position: relative;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.3);
            transition: all 0.6s cubic-bezier(1, -0.375, 0.285, 0.995);
            z-index: 9999;
        }

        .brand.active {
            width: 100%;
        }

        .brand::before {
            content: "";
            display: block;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background: #000;
            z-index: -1;
            border-radius: 10px 0 0 10px;
        }

        .brand a.logo {
            color: #f95959;
            font-size: 20px;
            font-weight: 700;
            text-decoration: none;
            line-height: 1em;
        }

        .brand a.logo span {
            font-size: 30px;
            color: #fff;
            transform: translateX(-5px);
            display: inline-block;
        }

        .brand .heading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            transition: all 0.6s;
            width: 80%;
        }

        .brand .heading img {
            width: 100%;
        }

        .brand .heading span {
            background-color: #013c60;
            margin-right: 5px;
        }

        .brand .heading.active {
            top: 100px;
            left: 100px;
            transform: translate(0);
        }

        .brand .heading h2 {
            font-size: 70px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 41px;
        }

        .brand .heading p {
            font-size: 15px;
            font-weight: 300;
            text-transform: uppercase;
            letter-spacing: 2px;
            white-space: 4px;
            font-family: "Raleway", sans-serif;
        }

        .brand .success-msg {
            width: 100%;
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin-top: 60px;
        }

        .brand .success-msg p {
            font-size: 25px;
            font-weight: 400;
            font-family: "Raleway", sans-serif;
        }

        .brand .success-msg a {
            font-size: 12px;
            text-transform: uppercase;
            padding: 8px 30px;
            background: #f95959;
            text-decoration: none;
            color: #fff;
            border-radius: 30px;
        }

        .brand .success-msg p, .brand .success-msg a {
            transition: all 0.9s;
            transform: translateY(20px);
            opacity: 0;
        }

        .brand .success-msg p.active, .brand .success-msg a.active {
            transform: translateY(0);
            opacity: 1;
        }

        .form {
            position: relative;

        }

        .form .form-peice {
            background: #fff;
            min-height: 480px;
            margin-top: 30px;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
            color: #bbbbbb;
            padding: 30px 0 60px;
            transition: all 0.9s cubic-bezier(1, -0.375, 0.285, 0.995);
            position: absolute;
            top: 0;
            left: -30%;
            width: 130%;
            overflow: hidden;
            border-radius: 0 10px 10px 0;
        }

        .form .form-peice.switched {
            transform: translateX(-100%);
            width: 100%;
            left: 0;
        }

        .form form {
            padding: 0 40px;
            margin: 0;
            width: 70%;
            position: absolute;
            top: 50%;
            left: 60%;
            transform: translate(-50%, -50%);
        }

        .form form .form-group {
            margin-bottom: 5px;
            position: relative;
        }

        .form form .form-group.hasError input {
            border-color: #f95959 !important;
        }

        .form form .form-group.hasError label {
            color: #f95959 !important;
        }

        .form form label {
            font-size: 12px;
            font-weight: 400;
            text-transform: uppercase;
            font-family: "Montserrat", sans-serif;
            transform: translateY(40px);
            transition: all 0.4s;
            cursor: text;
            z-index: -1;
        }

        .form form label.active {
            transform: translateY(10px);
            font-size: 10px;
        }

        .form form label.fontSwitch {
            font-family: "Raleway", sans-serif !important;
            font-weight: 600;
        }

        .form form input:not([type=submit]) {
            background: none;
            outline: none;
            border: none;
            display: block;
            padding: 10px 0;
            width: 100%;
            border-bottom: 1px solid #eee;
            color: #444;
            font-size: 15px;
            font-family: "Montserrat", sans-serif;
            z-index: 1;
        }

        .form form input:not([type=submit]).hasError {
            border-color: #f95959;
        }

        .form form span.error {
            color: #f95959;
            font-family: "Montserrat", sans-serif;
            font-size: 12px;
            position: absolute;
            bottom: -20px;
            right: 0;
            display: none;
        }

        .form form input[type=password] {
            color: #000;
        }

        .form form .CTA {
            margin-top: 30px;
        }

        .form form .CTA input {
            font-size: 12px;
            text-transform: uppercase;
            padding: 5px 30px;
            background: #f95959;
            color: #fff;
            border-radius: 30px;
            margin-right: 20px;
            border: none;
            font-family: "Montserrat", sans-serif;
        }

        .form form .CTA a.switch {
            font-size: 13px;
            font-weight: 400;
            font-family: "Montserrat", sans-serif;
            color: #bbbbbb;
            text-decoration: underline;
            transition: all 0.3s;
        }

        .form form .CTA a.switch:hover {
            color: #f95959;
        }

        footer {
            text-align: center;
        }

        footer p {
            color: #777;
        }

        footer p a, footer p a:focus {
            color: #b8b09f;
            transition: all 0.3s;
            text-decoration: none !important;
        }

        footer p a:hover, footer p a:focus:hover {
            color: #f95959;
        }

        @media (max-width: 768px) {
            .container {
                overflow: hidden;
            }

            section#formHolder {
                padding: 0;
            }

            section#formHolder div.brand {
                min-height: 200px !important;
            }

            section#formHolder div.brand.active {
                min-height: 100vh !important;
            }

            section#formHolder div.brand .heading.active {
                top: 200px;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            section#formHolder div.brand .success-msg p {
                font-size: 16px;
            }

            section#formHolder div.brand .success-msg a {
                padding: 5px 30px;
                font-size: 10px;
            }

            section#formHolder .form {
                width: 80vw;
                min-height: 500px;
                margin-left: 10vw;
            }

            section#formHolder .form .form-peice {
                margin: 0;
                top: 0;
                left: 0;
                width: 100% !important;
                transition: all 0.5s ease-in-out;
            }

            section#formHolder .form .form-peice.switched {
                transform: translateY(-100%);
                width: 100%;
                left: 0;
            }

            section#formHolder .form .form-peice > form {
                width: 100% !important;
                padding: 60px;
                left: 50%;
            }
        }

        /*Submit Button Design */

        button {
            position: relative;
            display: inline-block;
            cursor: pointer;
            outline: none;
            border: 0;
            vertical-align: middle;
            text-decoration: none;
            background: transparent;
            padding: 0;
            font-size: inherit;
            font-family: inherit;
        }

        button.learn-more {
            width: 12rem;
            height: auto;
            margin-top: 56px;
        }

        button.learn-more:focus {
            outline: 0;
        }

        button.learn-more .circle {
            transition: all 0.45s cubic-bezier(0.65, 0, 0.076, 1);
            position: relative;
            display: block;
            margin: 0;
            width: 3rem;
            height: 3rem;
            background: #282936;
            border-radius: 1.625rem;
        }

        button.learn-more .circle .icon {
            transition: all 0.45s cubic-bezier(0.65, 0, 0.076, 1);
            position: absolute;
            top: 0;
            bottom: 0;
            margin: auto;
            background: #fff;
        }

        button.learn-more .circle .icon.arrow {
            transition: all 0.45s cubic-bezier(0.65, 0, 0.076, 1);
            left: 0.625rem;
            width: 1.125rem;
            height: 0.125rem;
            background: none;
        }

        button.learn-more .circle .icon.arrow::before {
            position: absolute;
            content: "";
            top: -0.25rem;
            right: 0.0625rem;
            width: 0.625rem;
            height: 0.625rem;
            border-top: 0.125rem solid #fff;
            border-right: 0.125rem solid #fff;
            transform: rotate(45deg);
        }

        button.learn-more .button-text {
            transition: all 0.45s cubic-bezier(0.65, 0, 0.076, 1);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 0.75rem 0;
            margin: 0 0 0 1.85rem;
            color: #282936;
            font-weight: 700;
            line-height: 1.6;
            text-align: center;
            text-transform: uppercase;
        }

        button:hover .circle {
            width: 100%;
        }

        button:hover .circle .icon.arrow {
            background: #fff;
            transform: translate(1rem, 0);
        }

        button:hover .button-text {
            color: #fff;
        }

        @media (max-width: 480px) {
            section#formHolder .form {
                width: 100vw;
                margin-left: 0;
            }

            h2 {
                font-size: 50px !important;
            }
        }
    </style>


    <div class="container">
        <section id="formHolder">
            <div class="row">
                <div class="col-sm-6 brand">
                    <div class="heading">
                        <img src="{{asset('public/assets/images/Pri-Po_logo_long.png')}}"/>
                    </div>
                </div>
                <div class="col-sm-6 form">
                    <form action="{{route('changeLang')}}" method="get">
                        <select name="lang" id="lang" onchange="this.form.submit()" class="form-control"
                                style="background-color: #141833;color: white;border: none">
                            <option value="en" {{(session()->get('locale') === 'en' || session()->get('locale') === '')?'selected' :''}}><span>🇺🇸</span>
                                <span>English</span></option>
                            <option value="de" {{session()->get('locale') === 'de'?'selected' :''}}><span>🇩🇪</span>
                                <span>Deutsch</span></option>
                            <option value="tr" {{session()->get('locale') === 'tr'?'selected' :''}}><span>🇹🇷</span>
                                <span>Turkish</span></option>
                        </select>
                    </form>
                    <!-- Signup Form -->
                    <div class="signup form-peice">

                        <form id="signup-form" class="login-form signup-form " action="{{route('admin.login')}}" method="post">
                            @csrf
                            <h2 class="text-center">Welcome back !</h2>
                            <p>Login To Pripo . </p>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <input type="hidden" name="is_chat" value="{{$is_chat}}">

                            <div class="form-group">
                                <label for="user_name">Username</label>
                                <input id="user_name" name="user_name" value="{{$user_name}}" type="text"
                                       class="form-control name" placeholder="" autocomplete="off">
                                <span class="text-danger error-message" id="user_name_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="password">Password </label>
                                <input type="password" id="password" name="password" value="{{$user_pass}}"
                                       placeholder="" class="pass" autocomplete="off">
                                <span class="text-danger error-message" id="password_error"></span>
                            </div>

                            <button type="submit" class="learn-more" text-center>
                                    <span class="circle" aria-hidden="true">
                                      <span class="icon arrow"></span>
                                    </span>
                                <span class="button-text">Login</span>
                            </button>
                        </form>
                    </div><!-- End Signup Form -->
                </div>
            </div>

        </section>
    </div>
@endsection

@push('scripts')

<script>
    $(document).ready(function () {
        $(document).on('keypress', function (e) {
            // Check if Enter key is pressed (key code 13)
            if (e.which == 13) {
                // Trigger form submit if Enter key is pressed
                $('#signup-form').submit();
            }
        });

        $('#signup-form').on('submit', function (e) {
            let isValid = true;

            // Clear previous error messages
            $('.error-message').text('');

            // Validate Username
            const user_name = $('#user_name').val().trim();
            if (user_name === '') {
                isValid = false;
                $('#user_name_error').text('{{ __('messages.User name is required.') }}');
            }

            const password = $('#password').val().trim();
            if (password === '') {
                isValid = false;
                $('#password_error').text('{{ __('messages.Password is required.') }}');
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>
<script>
        //Toggle Eye Password
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(`togglePasswordIcon-${fieldId}`);
            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                field.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
 </script>
@endpush
