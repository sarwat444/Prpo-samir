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
  <link href="{{asset('public/assets/admin/assets2/img/favicon.png')}}" rel="icon">
  <link href="{{asset('public/assets/admin/assets2/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
 <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->

   <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

  <link href="{{asset('public/assets/admin/assets2/vendor/animate.css/animate.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/admin/assets2/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/admin/assets2/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/admin/assets2/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/admin/assets2/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/admin/assets2/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/admin/assets2/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/admin/assets/css/forms/theme-checkbox-radio.css')}}">
  <!-- Template Main CSS File -->
  <!--Loading -->
     <link href="{{asset('public/assets/admin/plugins/loaders/custom-loader.css')}}" rel="stylesheet" type="text/css" />
  <!--End Loading -->
    <link href="{{asset('public/assets/admin/assets2/css/style.css')}}" rel="stylesheet">
  @yield('css')
</head>
<body>

    <div class="container">
           <div class="sidebar-model"></div>

      <!-- fixed-top-->
      @if(auth()->user()->role == 3)
         @include('admin.includes.guest_header')
     @else
        @include('admin.includes.header')
     @endif
        <!-- ////////////////////////////////////////////////////////////////////////////-->
        @include('admin.includes.sidebar')


         @yield('content')

         <div class="loading">

               <div class="spinner-border text-primary align-self-center">Loading...</div>

         </div>

        @include('admin.includes.footer')
   </div>
</div>
<!-- Vendor JS Files -->
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="{{asset('public/assets/admin/assets2/vendor/aos/aos.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/vendor/php-email-form/validate.js')}}"></script>
<script src="{{asset('public/assets/admin/assets2/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touch/1.1.0/jquery.touch.min.js"></script>
<script src="{{asset('public/assets/admin/assets2/js/Sortable.min.js')}}"></script>
<!-- Template Main JS File -->
  <script src="https://cdn.jsdelivr.net/gh/prashantchaudhary/ddslick@master/jquery.ddslick.min.js"></script>

    <script src="{{ asset('public/assets/js/pusher.js') }}"></script>
    <script src="{{asset('public/assets/admin/assets2/js/main.js')}}"></script>

<script>

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

   //  console.log(existingNotifications + 'yes');
     if(data.catid == null) {
      var imgg = "{!! asset('public/assets/images/users') !!}";
     var newNotificationHtml =  '<div class="notfi-notifications-item">' + '<a href="" class="btn-task-popup" data-id="'+data.taskid+'">'

               +'<div class="display-flex">'
                +'<img src="'+imgg+"/"+data.userimage+'"  alt="img">'
                +'<h2>'+ data.username + '</h2>'
                +'</div>'
               +'<div class="text">'
               +'<p>'+  data.desc +'</p>'
            +'</div>'
        +'</a></div>';
     }else {
          var newNotificationHtml =  '<div class="notfi-notifications-item">' + '<a href="{{route('admin.categories')}}">'


                +'<img src="'+imgg+"/"+data.userimage+'"  alt="img">' +

               '<div class="text">'+
                '<h4>'+ data.username+'</h4>'+
               '<p>'+  data.desc +'</p>'+
            '</div>'+
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





<script>

$(document).on('click' , '.dismiss' , function(){
    $('.sidebar').css({'width':'0'}) ;
    $('.sidebar-model').css({'width':'0'}) ;
    $('.overlay').css('display' ,'none');
});

$(document).on('click' , '.overlay' , function(){
    $('.sidebar').css({'width':'0'}) ;
    $('.sidebar-model').css({'width':'0'}) ;
    $('.overlay').css('display' ,'none');
});


    $(document).ready(function () {
                       $(document).on('click', '.btn-task-popup', function (event) {
                                    event.preventDefault();
                                    var id = $(this).data('id');
                                     var type = '1';
                                      $.ajax({
                                          type: "post",
                                          url: "{{route('admin.get.task_data')}}", // need to create this post route
                                          data: {id : id , type : type , _token : '{{ csrf_token() }}'},
                                          cache: false,
                                          success: function (data) {

                                                $('#tasks').modal('show');
                                                $('.overlay').css('display' ,'block');
                                                $(".sidebar-model").html(data);
                                                $(".sidebar-model").css({'width':'50%'}) ;
                                                  /*Start  Plugin */

                                                                    $( ".testinput" ).each(function( index, elem ) {

                                                                       $z = $(this).val();
                                                                      $('.slick'+$z).ddslick({
                                                                      onSelected: function(selectedData)
                                                                      {

                                                                               var resp_val =   selectedData.selectedData.value  ;
                                                                               var  subtask_id  =  selectedData.selectedData.description;


                                                                               $.ajax({
                                                                               type: "POST",
                                                                               url: '{{route('admin.subtasks.updatefielddd')}}', // need to create this post route
                                                                               data: {subtask_id : subtask_id  ,  resp_val : resp_val , _token : '{{ csrf_token() }}'},
                                                                               cache: false,
                                                                               success: function (data) {
                                                                                  // console.log('done');

                                                                               },
                                                                               error: function (jqXHR, status, err) {
                                                                               },
                                                                             });


                                                                      }

                                                                 });

                                                });



                                                  /* End plugin */

                                          },
                                          error: function (jqXHR, status, err) {
                                          },
                                     });

                                     var log = $(this).data('log');

                                                              //alert(id);

                                                         if(log) {
                                                             $.ajax({
                                                                           type: "post",
                                                                           url: "{{route('admin.update_log_read')}}", // need to create this post route
                                                                           data: {log : log , _token : '{{ csrf_token() }}'},
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
                                                                     data: {id : id , type : type , _token : '{{ csrf_token() }}'},
                                                                     cache: false,
                                                                     success: function (data) {

                                                                           $('#tasks').modal('show');
                                                                           $(".sidebar-model").html(data);
                                                                           $(".sidebar-model").css({'width':'50%'}) ;
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
                                          data: {type : type , _token : '{{ csrf_token() }}'},
                                          cache: false,
                                          success: function (data) {
                                               $('#tasks').modal('show');
                                                 $(".sidebar-model").html(data);
                                                 $(".sidebar-model").css({'display':'block' , 'width':'50%'}) ;
                                          },
                                          error: function (jqXHR, status, err) {
                                          },
                                     });
                                });

                                 $(document).on('click', '#update_profile', function (event) {

                                    event.preventDefault();

                                    var type = $(this).data('type');

                                      $.ajax({
                                          type: "post",
                                          url: "{{route('admin.get.create_view')}}",
                                          data: {type : type , _token : '{{ csrf_token() }}'},
                                          cache: false,
                                          success: function (data) {
                                              alert('test') ;
                                                         $(".overlay").css('display' , 'block');
                                                         $('body').css('overflow' , 'hidden') ;
                                                         $('#tasks').modal('show');
                                                         $(".sidebar-model").html(data);
                                                         $(".sidebar-model").css({'display':'block' , 'width':'50%'}) ;
                                          },
                                          error: function (jqXHR, status, err) {
                                          },
                                     });

                                });

                                $(document).on('click','#popup_button',function(){
                                    $.ajax({
                                           type: 'POST',
                                          url:  '{{route('admin.change_user_login_status')}}',
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

$(document).ready(function(){




var down = false;

$('#notfi-bell').click(function(e){


var color = $(this).text();
if(down){
$('#notfi-box').css('display','none');
$('#notfi-box').css('height','0px');
$('#notfi-box').css('opacity','0');
down = false;
}else{

$('#notfi-box').css('height','auto');
$('#notfi-box').css('display','block');
$('#notfi-box').css('opacity','1');
down = true;

}

});

});

</script>





<script>

function  updateLoginStatus()
{

         $.ajax({
            type: 'POST',
           url:  '{{route('admin.update_user_login_status')}}',
            data: {

                 _token: '{{ csrf_token() }}'
            },
            success: function (data) {

                 $("#online_users").html(data.options);

                  //alert('success');

            }, error: function (reject) {
            }
        }); // end ajax

//console.log(imggg);
// return imggg;
}

      //  setInterval(updateLoginStatus, 60000);
      /*  setInterval(function() {
                @php
                    $minutes_to_add = 9;
                    $time = new DateTime(auth()->user()->login_at);
                    $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                    $stamp = $time->format('Y-m-d H:i:s');
              @endphp

              if('{{$stamp <= \Carbon\Carbon::now()->addHour(2) }}') {
                    // alert('HIIIIIIIIIIIIIIIIIIIIIIIII');
                    $('#myModal').modal('show');
              }

               // alert('{{$stamp}}' + '{{\Carbon\Carbon::now()->addHour(2)}}');

        }, 60000);*/

</script>


<script>
   $('.notfi-notifications-item').on('click',function(){
       $(this).css('display','none');
       $('#notfi-box').css('height','0px');
       $('#notfi-box').css('opacity','0');
       down = false;
   });
</script>


    @yield('script')
</body>
</html>
