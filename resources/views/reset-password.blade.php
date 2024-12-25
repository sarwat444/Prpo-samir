<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"
            integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2"
            crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        html, body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: -webkit-box;
            display: flex;
            -ms-flex-align: center;
            -ms-flex-pack: center;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            background: rgb(2,0,36);
            background: radial-gradient(circle, rgba(2,0,36,1) 0%, rgba(21,21,36,1) 30%, rgba(0,212,255,1) 100%);
        }

        form {
            padding-top: 10px;
            font-size: 14px;
            margin-top: 30px;
        }

        .card-title {
            font-weight: 300;
        }

        .btn {
            font-size: 14px;
            margin-top: 20px;
        }

        .login-form {
            width: 30%;
            margin: 20px;
        }

        .sign-up {
            text-align: center;
            padding: 20px 0 0;
        }

        span {
            font-size: 14px;
        }
    </style>
</head>
<body >
<div class="card login-form" style="border: none">
    <div class="card-body " style="    background: #013c60;color: white;">

        @if(session('success'))
            <div class="alert alert-success">{{session('success')}}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
        @endif

        <h3 class="text-center"><img data-imagetype="External"
                                     src="{{asset('public/assets/images/header-logo.png')}}"
                                     style="width:335px">
        </h3>
            <hr>
        <h3 class="card-title text-center">Forget <span style="font-size: xx-large;" class="text-primary">password</span> ?</h3>

        <div class="card-text">
            <form id="reset-password" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Enter your email address</label>
                    <input type="email" name="email" class="form-control form-control-sm"
                           placeholder="Enter your email address" required>

                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Enter code send via mail </label>
                    <input name="code" type="text" class="form-control form-control-sm" placeholder="Enter your code"
                           required>

                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Enter new password.</label>
                    <input type="password" name="password" class="form-control form-control-sm"
                           placeholder="Enter your new Password" required>

                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">confirm new password.</label>
                    <input type="password" name="confirm_password" class="form-control form-control-sm"
                           placeholder="confirm your new Password" required>

                </div>
                <button type="button" class="btn btn-primary btn-block confirm">Confirm</button>
            </form>
        </div>
    </div>
</div>
</body>
<script>
    $(document).ready(function () {
        $(document).on('click', '.confirm', function (event) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let formData = new FormData(document.getElementById('reset-password'));

            $.ajax({
                type: "post",
               url: "{{route('reset-password')}}", // need to create this post route
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {

                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: `${data.message}`,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                    if(!data.status){
                        Swal.fire({
                            icon: 'error',
                            title: `${data.message}`,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                },
                error: function (jqXHR, status, err) {
                 if(err){
                     console.log(err)
                     Swal.fire({
                         icon: 'error',
                         title: `${err}`,
                         showConfirmButton: false,
                         timer: 2000
                     })
                 }

                },


            });
        });
    });

</script>
</html>
