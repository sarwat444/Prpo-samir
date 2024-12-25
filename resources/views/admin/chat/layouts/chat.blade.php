<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- SEO Meta Tags-->
    <meta name="keywords" content="quicky, chat, messenger, conversation, social, communication">
    <meta name="description" content="Pripo chat app ">
    <meta name="subject" content="communication">
    <meta name="copyright" content="frontendmatters">
    <meta name="revised" content="Tuesday, November 10th, 2020, 08:00 am">
    <title> Chat App </title>
    <!-- Favicon and Touch Icons-->
    <link rel="apple-touch-icon" sizes="180x180" href="../../apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../favicon-16x16.png">
    <link rel="shortcut icon" href="../../favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{asset(PUBLIC_PATH.'assets/chat/css/app.min.css')}}">
    <link rel="stylesheet" href="{{asset(PUBLIC_PATH.'assets/chat/css/inter.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .sidebar-navigation {
            display: inline-block;
            min-height: 100vh;
            width: 60px;
            position: fixed;
            top: 0;
            right: 0;
            height: 100%;
            background-color: #1b5b96;
            padding-top: 70px ;
            z-index: 20;
        }
        .sidebar-navigation ul {
            text-align: center;
            color: white;

        }
        .sidebar-navigation ul .active {
            padding: 14px 0;
        }
        .sidebar-navigation ul li .dropdown-menu  li
        {
            padding: 2px 0 !important;
            font-size: 13px;
        }
        .sidebar-navigation ul  .nav-link i{
            color: #ffffff !important;
            background-color: #486b81;
            padding: 8px;
            border-radius: 50%;
            font-size: 13px;
        }
        /*Custom desgin */
        .sidebar-navigation .logout
        {
            position: absolute;
            bottom: 20px ;

        }
        .sidebar-navigation .logout  i
        {
            background: #A75656 !important;
        }

        .sidebar-navigation  .admintasks i
        {
            background: #2778c4 !important;
        }
        .sidebar-navigation  .assignedtasks i
        {
            background: #2b87e0 !important
        }
        .sidebar-navigation .history i
        {
            background: #a47500 !important
        }
        .sidebar-navigation .test i{
            background: #9c00f5 !important
        }

        .sidebar-navigation ul li {
            padding: 5px 0;
            cursor: pointer;
            transition: all ease-out 120ms;
        }
        .sidebar-navigation ul li i {
            display: block;
            font-size: 24px;
            transition: all ease 450ms;
            color: #ffffff;
            font-size: 16px;
            padding: 0;
        }
        .sidebar-navigation
        ul li .tooltip {
            display: inline-block;
            position: absolute;
            background-color: #313443;
            padding: 8px 15px;
            border-radius: 3px;
            margin-top: -26px;
            left: -109px;
            opacity: 0;
            visibility: hidden;
            font-size: 13px;
            letter-spacing: 0.5px;
            color: #ffffff;
            z-index: 7777777777;
        }
        .sidebar-navigation ul li .fa-trash ,
        .sidebar-navigation ul li .fa-plus ,
        .sidebar-navigation ul li .fa-check-double
        {
            color: #ffffff !important;
            background-color: #486b81;
            padding: 8px;
            border-radius: 50%;
            font-size: 13px;
        }
        .sidebar-navigation ul li .fa-check-double {
            background-color:#799B73 ;
        }
        .sidebar-navigation ul li .fa-check {
            color: #ffffff !important;
            background-color: #486b81;
            padding: 8px;
            border-radius: 50%;
            font-size: 13px;
        }
        .sidebar-navigation ul li .fa-trash {
            background-color:#A75656;
        }


        .sidebar-navigation ul li .tooltip:before {
            content: "";
            display: block;
            position: absolute;
            right: -4px;
            top: 10px;
            transform: rotate(45deg);
            width: 10px;
            height: 10px;
            background-color: inherit;
        }
        .sidebar-navigation ul li:hover {
            background-color: #2778c4;
        }
        .sidebar-navigation ul li:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }

        .sidebar-navigation ul li.active i {
            color: #ffffff;
        }
        .sidebar-navigation ul{
            list-style-type: none;
            margin: 0 ;
            padding: 0;
        }

        .sidebar-navigation .messages{
            position: absolute;
            background-color: #ec6630;
            border-radius: 50%;
            color: #ffffff;
            height: 20px;
            width: 20px;
            font-size: 8px;
            top: -4px;
            padding-top: 6px;
            left: 20px;
        }
        .chats-tab-open
        {
            margin-right: 60px;
        }
    </style>
    @stack('style')
</head>
<body>
 <div class="chats-tab-open">
             <div class="main-layout">
                 @yield('content')
                 @include('admin.chat.includes.header')
             </div>
     </div>
</body>
<!-- Javascript Files -->
<script src="{{asset(PUBLIC_PATH.'assets/chat/js/jquery-3.5.0.min.js')}}"></script>
<script src="{{asset(PUBLIC_PATH.'assets/chat/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset(PUBLIC_PATH.'assets/chat/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset(PUBLIC_PATH.'assets/chat/js/svg-inject.min.js')}}"></script>
<script src="{{asset(PUBLIC_PATH.'assets/chat/js/modal-steps.min.js')}}"></script>
<script src="{{asset(PUBLIC_PATH.'assets/chat/js/emojionearea.min.js')}}"></script>
<script src="{{asset(PUBLIC_PATH.'assets/chat/js/app.js')}}"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        document.querySelector('.chat-finished').scrollIntoView({
            block: 'end',
            behavior: 'auto',
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.contacts-item').on('click', function() {
                // Remove active class from all items
                $('.contacts-item').removeClass('active');
                // Add active class to the clicked item
                $(this).addClass('active');
            });
        });
    </script>
@stack('script')
</body>
</html>
