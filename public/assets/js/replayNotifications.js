var notificationsWrapperr = $('#nav-profile');

//var notificationsToggle = notificationsWrapper.find('a[data-toggle]');

var notificationsCountElem = $('.icon span');
/*
var notificationsCount = parseInt(notificationsCountElem.data('count'));
*/

var notifications = notificationsWrapperr.find('.notifi-item');
var pusher = new Pusher('9ebfe213ba01f2ba5e4b', {
    //  cluster: 'mt1',
    encrypted: false
});

// Subscribe to the channel we specified in our Laravel Event
var channel = pusher.subscribe('replay_channel');
// Bind a function to a Event (the full Laravel class)
channel.bind('App\\Events\\ReplayNotification', function (data) {
    var existingNotifications = notificationsWrapperr.html();

    var newNotificationHtml = `<div class="notifi-item btn-task-replaycomment" data-id="`+data.task_id+`"  style="background-color: #d4efff;">
                                    <img src="https://gtek.pri-po.com/public/assets/images/users/`+data.user_image+ `" alt="img">
                                  
                                        <div class="text"> 
                                             <h4><span>`+data.added_by+`</span>  Replay On Your comment  </h4> 
                                             <p><span>`+data.date+` `+data.time+`</span></p>
                                    </div> 
                                    
                            </div> `;

    notificationsWrapperr.prepend(newNotificationHtml );
    var  count = $('.icon span').text() ;
    var  newcount  =  Number(count) ;
    $('.icon span').text(newcount + 1) ;




    //notificationsCount += 1;
  //  notificationsCountElem.attr('data-count', notificationsCount);
   // notificationsWrapper.find('.notif-count').text(notificationsCount);
    /*notificationsWrapper.show();*/
});
