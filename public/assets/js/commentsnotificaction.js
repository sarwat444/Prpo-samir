var notificationsWrapper = $('#nav-home');

//var notificationsToggle = notificationsWrapper.find('a[data-toggle]');
/*
var notificationsCountElem = notificationsToggle.find('span[data-count]');
var notificationsCount = parseInt(notificationsCountElem.data('count'));
*/

var notifications = notificationsWrapper.find('.notifi-item');
var pusher = new Pusher('9ebfe213ba01f2ba5e4b', {
    //  cluster: 'mt1',
    encrypted: false
});

// Subscribe to the channel we specified in our Laravel Event
var channel = pusher.subscribe('replay_channel');
// Bind a function to a Event (the full Laravel class)
channel.bind('App\\Events\\ComentsNotification', function (data) {
    var existingNotifications = notificationsWrapper.html();

    var newNotificationHtml = `<div class="notifi-item btn-task-replaycomment" data-id="`+data.task_id+`" style="background-color: #d4efff;"> 
                                    <img src="https://gtek.pri-po.com/public/assets/images/users/`+data.user_image+ `" alt="img">
                                    <div class="text"> 
                                             <h4><span>`+data.comment_author+`</span>  Has Added  New comment </h4> 
                                             <p><span>`+data.date+` `+data.time+`</span></p>
                                    </div> 
                            </div> `;
    notificationsWrapper.prepend(newNotificationHtml );
    //notificationsCount += 1;
  //  notificationsCountElem.attr('data-count', notificationsCount);
   // notificationsWrapper.find('.notif-count').text(notificationsCount);
    /*notificationsWrapper.show();*/
});
