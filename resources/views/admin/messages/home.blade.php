@extends('layouts.dashboard')
@section('css')
<link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
<script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}" ></script>
<link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="{{asset('public/assets/css/apps/mailing-chat.css')}}" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL STYLES -->
<link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">


    <style>
    /*

       ::-webkit-scrollbar {
           width: 7px;
       }

       ::-webkit-scrollbar-track {
           background: #f1f1f1;
       }

       ::-webkit-scrollbar-thumb {
           background: #a7a7a7;
       }

       ::-webkit-scrollbar-thumb:hover {
           background: #929292;
       }
       ul {
           margin: 0;
           padding: 0;
       }
       li {
           list-style: none;
       }
       .user-wrapper, .message-wrapper {
           border: 1px solid #dddddd;
           overflow-y: auto;
       }
       .user-wrapper {
           height: 600px;
       }
       .user {
           cursor: pointer;
           padding: 5px 0;
           position: relative;
       }
       .user:hover {
           background: #eeeeee;
       }
       .user:last-child {
           margin-bottom: 0;
       }

       .group {
           cursor: pointer;
           padding: 5px 0;
           position: relative;
       }
       .group:hover {
           background: #eeeeee;
       }
       .group:last-child {
           margin-bottom: 0;
       }

*/
       .pending {
           position: absolute;
           left: 13px;
           top: 9px;
           background: #b600ff;
           margin: 0;
           border-radius: 50%;
           width: 18px;
           height: 18px;
           line-height: 18px;
           padding-left: 5px;
           color: #ffffff;
           font-size: 12px;
       }
       .media-left {
           margin: 0 10px;
       }
       .media-left img {
           width: 64px;
           border-radius: 64px;
       }
       .media-body p {
           margin: 6px 0;
       }
       .message-wrapper {
           padding: 10px;
           height: 536px;
           background: #eeeeee;
       }
       .messages .message {
           margin-bottom: 15px;
       }
       .messages .message:last-child {
           margin-bottom: 0;
       }
       .received, .sent {
           width: 45%;
           padding: 3px 10px;
           border-radius: 10px;
       }
       .received {
           background: #ffffff;
       }
       .sent {
           background: #3bebff;
           float: right;
           text-align: right;
       }
       .message p {
           margin: 5px 0;
       }
       .date {
           color: #777777;
           font-size: 12px;
       }
       .active {
           background: #eeeeee;
       }
       input[type=text] {
           width: 100%;
           padding: 12px 20px;
           margin: 15px 0 0 0;
           display: inline-block;
           border-radius: 4px;
           box-sizing: border-box;
           outline: none;
           border: 1px solid #cccccc;
       }
       input[type=text]:focus {
           border: 1px solid #aaaaaa;
       }

       .select2-search__field {
           width: 100% !important;
       }

.chat-system .chat-box .chat-box-inner .chat-conversation-box .chat
{
  display: block !important ;
}
.chat-box-inner
{
  background-color: #141834bd;
}
.sent img
{
    width: 29% !important;
    border-radius: 13px;
}
   </style>

@endsection

@section('content')
<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="chat-section layout-top-spacing">
                <div class="row">

                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="chat-system">
                            <div class="hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu mail-menu d-lg-none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></div>
                            <div class="user-list-box">
                                <div class="search">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                    <input type="text" class="form-control" placeholder="Search" />
                                </div>
                                <div class="people">
                                       @foreach($users as $user)
                                              <div id="{{ $user->id }}"  class="person user" data-chat="person{{ $user->id }}" >
                                                  <div class="user-info">
                                                      <div class="f-head">
                                                          <img src="{{asset('public/assets/images/users/'.$user->image)}}" alt="avatar">
                                                      </div>
                                                      <div class="f-body">
                                                          <div class="meta-info">
                                                              <span class="user-name" data-name="Sean Freeman">{{ $user->user_name }}</span>
                                                              <span class="user-meta-time">2:09 PM</span>
                                                          </div>
                                                          <span class="preview">{{ $user->email }}</span>
                                                      </div>
                                                  </div>
                                              </div>
                                        @endforeach
                                </div>
                            </div>
                            <div class="chat-box">
                                <div class="chat-box-inner">
                                    <div class="chat-conversation-box">
                                        <div id="chat-conversation-box-scroll" class="chat-conversation-box-scroll">

                                        </div>

                                  </div>

                                     <div class="chat-footer">
                                       <div class="chat-message clearfix">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                         <textarea name="message" id="message-to-send" placeholder ="Type your message" rows="3" class="submit"></textarea>
                                         <form id="dataup" class="form"  method="POST" action="{{route('message2')}}" enctype="multipart/form-data">


                                                  <input type="file" id="myInput" name="image">
                                                      <input type="hidden" name="to" value="" >
                                                  <input type="submit" value="Send" style="display:inline-block;background-color:#3bebff;color:#fff;padding:8px;border-radius:5px;">
                                          </form>
                                       </div> <!-- end chat-message -->
                              
                                    </div> -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            </div>

    </div>
    <!--  END CONTENT AREA  -->

</div>
<!-- END MAIN CONTAINER -->




@endsection

@section('script')

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{asset('public/assets/admin/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('public/assets/js/apps/mailbox-chat.js')}}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
    <script>

       var group_id = '';
        var my_id = "{{ Auth::id() }}";

    $(document).ready(function () {
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

                 //cluster: 'mt1',
              encrypted: false
       });
     //   var channel = pusher.subscribe('my-channel');

        var channel = pusher.subscribe('group-channel');

        channel.bind('App\\Events\\NewMessage2', function (data) {

                       // channel.bind('my-event', function (data) {

                     $('#'+'group'+ data.group_id).click();

           });


        $('.group').click(function () {
            $('.group').removeClass('active');
            $(this).addClass('active');
            group_id = $(this).data('val');
            $.ajax({
                type: "get",
                url: "group/messages/" + group_id, // need to create this route
                data: "",
                cache: false,
                success: function (data) {
                    $('#messages').html(data);
                    //scrollToBottomFunc2();

                }
            });
        });


        $(document).on('keyup', '.input-text-group input', function (e) {

            var message = $(this).val();

              //var group_id = $(this).attr('id');
            // check if enter key is pressed and message is not null also receiver is selected
            if (e.keyCode == 13 && message != '' && group_id != '') {
                $(this).val(''); // while pressed enter text box will be empty

                var datastr = "group_id=" + group_id + "&message=" + message;
                $.ajax({
                    type: "post",
                    url: "conversation/add", // need to create this post route
                    data: datastr,
                    cache: false,
                    success: function (data) {
                    },
                    error: function (jqXHR, status, err) {


                    },
                    complete: function () {
                      //  scrollToBottomFunc();


                    }
                })
            }
        });


      });

  </script>

  <script>


   var receiver_id = '';
   var my_id = "{{ Auth::id() }}";
   $(document).ready(function () {
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

                //cluster: 'mt1',
             encrypted: false
      });
    //   var channel = pusher.subscribe('my-channel');

       var channel = pusher.subscribe('my-channel');
    // Bind a function to a Event (the full Laravel class)
    channel.bind('App\\Events\\newMessage', function (data) {

      // channel.bind('my-event', function (data) {


           // alert(JSON.stringify(data));
           if (my_id == data.from) {


               $('#' + data.to).click();
           } else if (my_id == data.to) {


               if (receiver_id == data.from) {
                   // if receiver is selected, reload the selected user ...
                   $('#' + data.from).click();
               } else {
                   // if receiver is not seleted, add notification for that user
                   var pending = parseInt($('#' + data.from).find('.pending').html());
                   if (pending) {
                       $('#' + data.from).find('.pending').html(pending + 1);
                   } else {
                       $('#' + data.from).append('<span class="pending">1</span>');
                   }
               }
           }
       });
       $('.user').click(function () {
           $('.user').removeClass('active');
           $(this).addClass('active');
           $(this).find('.pending').remove();
           receiver_id = $(this).attr('id');
           $.ajax({
               type: "get",
               url: "message/" + receiver_id, // need to create this route
               data: "",
               cache: false,
               success: function (data) {
                   $('#chat-conversation-box-scroll').html(data);

                   scrollToBottomFunc();
               }
           });
       });
       $(document).on('keyup', '.input-text input', function (e) {
           var message = $(this).val();
           // check if enter key is pressed and message is not null also receiver is selected
           if (e.keyCode == 13 && message != '' && receiver_id != '') {
               $(this).val(''); // while pressed enter text box will be empty
               var datastr = "receiver_id=" + receiver_id + "&message=" + message;
               $.ajax({
                   type: "post",
                   url: "message", // need to create this post route
                   data: datastr,
                   cache: false,
                   success: function (data) {
                   },
                   error: function (jqXHR, status, err) {


                   },
                   complete: function () {
                       scrollToBottomFunc();
                   }
               })
           }
       });

    $(document).on('submit','.form' , function(e)  {

                e.preventDefault();

                  var formData = new FormData($( "#dataup" )[0]);

                  var url = $(this).attr("action");
                 $.ajax({
                                        type: "post",
                                        url: url, // need to create this post route
                                        data: formData,
                                        async: false,
                                       cache: false,
                                       contentType: false,
                                       processData: false,
                                        success: function (data) {


                                        },
                                        error: function (jqXHR, status, err) {


                                        },
                                        complete: function () {
                                            scrollToBottomFunc();
                                        }
                                    });

          });


   });
   // make a function to scroll down auto
   function scrollToBottomFunc() {


   }







</script>

@endsection
