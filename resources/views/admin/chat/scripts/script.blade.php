@php use Illuminate\Support\Facades\Auth; @endphp
<script>
    function hideLoading() {
        $('#loadingMessage').remove();
    }
</script>
<script>
    //View Room Contents
    $(document).ready(function () {
        //Get Room Data
        $('.contacts-link').on('click', function (e) {
            e.preventDefault(); // Prevent the default action of the link
            // Retrieve data attributes from the clicked link
            var room_id = $(this).data('room-id');
            var id = $(this).data('user-id');
            if (room_id) {
                var room_type = $(this).data('type');
                // Correctly set the chat name and avatar based on the clicked element
                $('.online_user h6').text($(this).find('.chat-name').text()); // Use .find() to get child elements
                if(room_type != 'Gruppe') {
                    $('.media .avatar-online img').attr('src', $(this).find('.avatar-online img').attr('src'));
                }else
                {
                    $('.media .avatar-online img').attr('src', $(this).find('.avatar img').attr('src'));
                }
                $('.contact_info').css('visibility' , 'visible') ;
                $('.chat-footer').css('visibility' , 'visible') ;
                $('.chat-content').attr('id', 'room-' + room_id);
                // Set hidden input values
                $('#room_type').val(room_type);
                $('#user_to').val(id);
                $('#room_id').val(room_id);

                // Make AJAX request to fetch messages
                $.ajax({
                    method: 'post',
                    url: "{{ route('admin.chat.room_messages') }}",
                    data: {
                        room_id: room_id,
                        room_type: room_type,
                        _token: '{{ csrf_token() }}'
                    },

                    //custom1111
                    success: function (response) {
                        let chatHtml = '';
                        const authUserId = {{ Auth::user()->id }}; // Get authenticated user ID

                        // Iterate through each message
                        response.data.forEach(message => {
                            // Check if the message is sent by the authenticated user
                            if (message.chat_from === authUserId) {
                                let  chatId =  message.chat_id ;
                                // Self message
                                chatHtml += `
                                            <div class="message self" id="mesage-${chatId}">
                                                <div class="message-wrapper">
                                                    <div class="message-content">`;

                                                            // Check the type of the message
                                                            if (message.chat_message_type === 'voice') {
                                                                // Set the voice message path
                                                                const voiceUrl = `${message.chat_attachment}`;
                                                                // Render voice message
                                                                chatHtml += `
                                                                <audio controls>
                                                                    <source src="${voiceUrl}" type="audio/mpeg">
                                                                    Your browser does not support the audio element.
                                                                </audio>`;
                                                            }

                                                            else if (message.chat_message_type === 'image') {
                                                                // Render image message
                                                                const imageUrl = `${message.chat_attachment}`;
                                                                chatHtml += `
                                                                       <a class="popup-media" href="${imageUrl}">
                                                                        <img class="img-fluid rounded" src="${imageUrl}" alt="Shared Image" onload="hideLoading()">
                                                                      </a> `;
                                                            } else {
                                                                // Default message display
                                                                chatHtml += `<span class="message${message.chat_id}">${message.chat_message}</span>`;
                                                            }

                                                            chatHtml += `
                                                    </div>
                                                </div>
                    <div class="message-options">
                        <span class="message-date">${message.time}</span>
                        <div class="dropdown">
                            <a class="text-muted" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="hw-18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                </svg>
                            </a>

                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item d-flex align-items-center text-danger deleteForEveryone" href="javascript:void(0)" data-id="${message.chat_id}">
                                    <svg class="hw-18 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span>Delete for ever</span>
                                </a>
                                <a class="dropdown-item d-flex align-items-center text-danger deleteForMe" href="javascript:void(0)" data-id="${message.chat_id}">
                                    <svg class="hw-18 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span>Delete for me</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                            } else {
                                // Received message
                                chatHtml += `
                <div class="message">
                    <div class="message-wrapper">
                        <div class="message-content">`;

                                // Check the type of the received message
                                if (message.chat_message_type === 'voice') {
                                    // Set the voice message path
                                    const voiceUrl = `${message.chat_attachment}`;

                                    // Render voice message
                                    chatHtml += `
                                    <audio controls>
                                        <source src="${voiceUrl}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>`;
                                } else if (message.chat_message_type === 'image') {
                                    // Render image message
                                    const imageUrl = `${message.chat_attachment}`;
                                    chatHtml += `
                                           <a class="popup-media" href="${imageUrl}">
                                            <img class="img-fluid rounded" src="${imageUrl}" alt="Shared Image" onload="hideLoading()">
                                          </a> `;
                                }else {
                                    // Default message display
                                    chatHtml += `<span class="message${message.chat_id}">${message.chat_message}</span>`;
                                }

                                chatHtml += `
                        </div>
                    </div>

                    <div class="message-options">
                        <span class="message-date" >${message.time}</span>
                        <div class="dropdown">
                            <a class="text-muted" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="hw-18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            `;
                            }
                        });
                        // Append the constructed chat HTML to the chat container
                        const roomElement = $(`.chat-body #room-${room_id}`);
                        roomElement.html(chatHtml);
                        roomElement.scrollTop(roomElement[0].scrollHeight);

                        // Start  Delete For Every Body
                        $('.deleteForEveryone').on('click', function () {
                            var message_id = $(this).data('id'); // Get the message ID from the data attribute
                            $.ajax({
                                method: 'POST',
                                url: "{{ route('admin.chat.deleteForMe') }}", // Route to handle the deletion
                                data: {
                                    chat_id: [message_id],
                                    room_type : 'Private' ,
                                    delete_type : 'every_one' ,
                                    _token: "{{ csrf_token() }}" // Include CSRF token for security
                                },
                                success: function (response) {
                                    $('#mesage-' + message_id).html(`<div class="message-wrapper"><div class="message-content"><span class="message54">Nachricht gelöscht für alle</span></div>  </div>`); // Ensure the ID matches the corrected HTML
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    alert('Failed to delete the message. Please try again.');
                                    console.error('Error details:', textStatus, errorThrown);
                                }
                            });
                        });
                        //Start  Delete For Me
                        $('.deleteForMe').on('click', function () {
                            var message_id = $(this).data('id'); // Get the message ID from the data attribute
                            $.ajax({
                                method: 'POST',
                                url: "{{ route('admin.chat.deleteForMe') }}", // Route to handle the deletion
                                data: {
                                    chat_id: [message_id],
                                    room_type : 'Private' ,
                                    delete_type : 'me' ,
                                    _token: "{{ csrf_token() }}" // Include CSRF token for security
                                },
                                success: function (response) {
                                    $('#mesage-' + message_id).html(`<div class="message-wrapper"><div class="message-content"><span class="message54">Nachricht für mich gelöscht</span></div>  </div>`); // Ensure the ID matches the corrected HTML
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    alert('Failed to delete the message. Please try again.');
                                    console.error('Error details:', textStatus, errorThrown);
                                }
                            });
                        });

                    },


                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Failed to send message. Please try again.');
                        console.error('Error details:', textStatus, errorThrown);
                    }
                });
            } else {
                var chat_room_creator = {{Auth::user()->id}};
                var chat_room_users = id;
                $('#room_id').val('');
                $('.online_user h6').text($(this).find('.chat-name').text()); // Use .find() to get child elements
                $('.media .avatar-online img').attr('src', $(this).find('.avatar-online img').attr('src')); // Use .attr('src') to get the image source
                $('.contact_info').css('visibility' , 'visible') ;
                $('.chat-footer').css('visibility' , 'visible') ;
                $('#room_type').val(room_type);
                $('#user_to').val(id);
                $('.chat-content').html('');

                var userId = $(this).data('user-id'); // Get the user-id

                $('.chat-content')
                    .removeClass(function (index, className) {
                        // Remove any class that starts with "data-to"
                        return (className.match(/\bdata-to\S+/g) || []).join(' ');
                    }).addClass('data-to' + userId); // Add the new class

                $(this)
                    .removeClass(function (index, className) {
                        // Remove any class that starts with "data-to"
                        return (className.match(/\bdata-to\S+/g) || []).join(' ');
                    }).addClass('data-to' + userId); // Add the new class


                }



        });
    });
</script>
<script>
    $(document).ready(function () {
        const channel = pusher.subscribe('my-channel');
        // Listen for new messages only once to prevent duplicate handlers
        channel.bind('my-event', function (data) {
            const room_id  = data.data.chat_room_id ;
            $('#loadingMessage').remove(); // Ensure loading message is removed
            // Create and append chat message HTML
            if (data.data.chat_attachment) {
                if (data.data.chat_message_type == 'image') {
                    const isSelf = data.data.id === authUserId || data.data.chat_from === authUserId;
                    const messageClass = isSelf ? 'self' : '';

                    var chatHtml = `
                        <div class="message ${messageClass}">
                        <div class="message-wrapper">
                            <div class="message-content">
                                <div class="form-row">
                                    <div class="col">
                                        <a class="popup-media" href="${data.data.chat_attachment}">
                                            <img class="img-fluid rounded" src="${data.data.chat_attachment}" alt="Shared Image" onload="hideLoading()">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                    const roomElement = $(`#room-${room_id}`);
                    roomElement.append(chatHtml);
                    roomElement.scrollTop(roomElement[0].scrollHeight);
                }
            }
        });
        // Handle file uploads
        $('#image_upload').on('change', function () {
            const file = this.files[0];
            if (file) {
                displayLoadingMessage(); // Show loading message

                const reader = new FileReader();
                reader.onload = function (e) {
                    uploadFile(file); // Call function to send data via AJAX
                };
                reader.onerror = function () {
                    alert('Failed to read the file. Please try again.');
                };
                reader.readAsDataURL(file); // Trigger reading the file
            }
        });

        // AJAX function to send the file and message
        function uploadFile(file) {
            const formData = new FormData();
            formData.append('message', $('#message_input').val());
            formData.append('room_type', $('#room_type').val());
            formData.append('room_id', $('#room_id').val());
            if($('#room_type').val() !== 'Gruppe')
            {
                formData.append('to', $('#user_to').val());
            }
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}'); // Laravel CSRF token

               $.ajax({
                   method: 'POST',
                   url: "{{ route('admin.chat.send_message') }}",
                   data: formData,
                   contentType: false,
                   processData: false,
                   success: function () {
                       console.log('Message sent successfully.');
                   },
                   error: function (jqXHR, textStatus, errorThrown) {
                       alert('Failed to send the message. Please try again.');
                       console.error('Error details:', textStatus, errorThrown);
                       $('#loadingMessage').remove(); // Remove loading message
                   }
               });
        }

        // Function to display the loading message
        function displayLoadingMessage() {
           const room_id= $('#room_id').val() ;

            var loadingHtml = `
                <div id="loadingMessage" class="message">
                    <div class="message-wrapper">
                        <div class="message-content">
                            <div class="form-row">
                                <div class="col">
                                    <div class="loading-indicator">
                                        <span class="loading-text">Uploading image...</span>
                                        <div class="spinner"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;


            const roomElement = $(`#room-${room_id}`);
            roomElement.append(loadingHtml);
            roomElement.scrollTop(roomElement[0].scrollHeight);
        }

        // Function to hide the loading message

    });
</script>





<script>
    // Store the authenticated user's ID from a backend variable (passed via Blade)
    const authUserId = {{ auth()->user()->id }};
    // Initialize Pusher and subscribe to the channel only once
    Pusher.logToConsole = true;
    const pusher = new Pusher('9ebfe213ba01f2ba5e4b', {
        cluster: 'mt1'
    });
    const channel = pusher.subscribe('my-channel');
    // Bind the event only once
    channel.bind('my-event', function (data) {
        const room_id = data.data.chat_room_id;

        const isSelf = data.data.id === authUserId || data.data.chat_from === authUserId;
        const messageClass = isSelf ? 'self' : '';

        if (data.data.chat_message_type === 'text') {
            const chatToValue = data.data.chat_from; // Convert array to string
            const chatHtml = `
            <div class="message ${messageClass}">
                <div class="message-wrapper">
                    <div class="message-content"><span>${data.data.chat_message}</span></div>
                </div>
                <div class="message-options">
                    <span class="message-date">Jetzt</span>
                </div>
            </div>`;

            // Set Counter To Messages
            const chatCounter = parseInt($(`#chat-count-${chatToValue}`).val(), 10) || 0; // Parse as integer
            $(`#chat-count-${chatToValue}`).val(chatCounter + 1); // Update the hidden input with the incremented value
            $(`.chat-count-${chatToValue} span`).text(chatCounter + 1); // Update the display with the incremented value

            const roomElement = $(`.chat-body #room-${room_id}`);
            roomElement.append(chatHtml);
            roomElement.scrollTop(roomElement[0].scrollHeight);
        }
    });

    // Send message on button click
    $('#submit_button').on('click', function (e) {
        e.preventDefault();
        const message = $('#message_input').val();
        const user_to = $("#user_to").val();
        const room_type = $("#room_type").val();
        var  room_id  = $("#room_id").val() ;
        var chat_room_creator = {{Auth::user()->id}};
        var id = $('#user_to').val();
        const $button = $(this);
        $button.prop('disabled', true);
        if(room_id) {
            if(room_type != 'Gruppe') {
                $.ajax({
                    method: 'post',
                    url: "{{ route('admin.chat.send_message') }}",
                    data: {
                        message: message,
                        room_type: room_type,
                        to: user_to,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        $('#message_input').val('');
                        $button.prop('disabled', false);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Failed to send message. Please try again.');
                        console.error('Error details:', textStatus, errorThrown);
                        $button.prop('disabled', false);
                    }
                });
            }else
            {
                $.ajax({
                    method: 'post',
                    url: "{{ route('admin.chat.send_message') }}",
                    data: {
                        message: message,
                        room_type: room_type,
                        room_id : room_id ,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        $('#message_input').val('');
                        $button.prop('disabled', false);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Failed to send message. Please try again.');
                        console.error('Error details:', textStatus, errorThrown);
                        $button.prop('disabled', false);
                    }
                });
            }
        }else
        {
            $.ajax({
                method: 'post',
                url: "{{ route('admin.chat.craete_room') }}",
                data: {
                    chat_room_creator: chat_room_creator,
                    chat_room_users: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    //Set Room
                    $('.data-to'+id).attr('id', `room-${response.chat_room.chat_room_id}`);
                    $('.data-to'+id).attr('data-room-id', `${response.chat_room.chat_room_id}`);

                    $.ajax({
                        method: 'post',
                        url: "{{ route('admin.chat.send_message') }}",
                        data: {
                            message: message,
                            room_type: 'Private',
                            to: user_to,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            $('#message_input').val('');
                            $button.prop('disabled', false);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert('Failed to send message. Please try again.');
                            console.error('Error details:', textStatus, errorThrown);
                            $button.prop('disabled', false);
                        }
                    });
                },

                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Failed to send message. Please try again.');
                    console.error('Error details:', textStatus, errorThrown);
                }
            });
        }
    });
</script>

<script>
    let mediaRecorder;
    let audioChunks = [];
    let audioBlob;
    let audioUrl;
    let isRecording = false; // Track recording state
    $('#deleteRecording, #sendRecording').css('display', 'none');
    $(document).ready(function () {

        const authUserId = {{ auth()->id() }};
        const channel = pusher.subscribe('my-channel');

        channel.bind('my-event', function (data) {
            const room_id = data.data.chat_room_id;

            $('#loadingMessage').remove();
            if (data.data.chat_attachment && data.data.chat_message_type === 'voice') {
                const isSelf = data.data.id === authUserId || data.data.chat_from === authUserId;
                const messageClass = isSelf ? 'self' : '';
                // Set the voice message path
                const voiceUrl = `${data.data.chat_attachment}`; // Adjust this based on your asset structure

                var chatHtml = `
            <div class="message ${messageClass}">
                <div class="message-wrapper">
                    <div class="message-content">
                        <div class="form-row">
                            <div class="col">
                                <audio controls>
                                    <source src="${voiceUrl}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

                const roomElement = $(`.chat-body #room-${room_id}`);
                roomElement.append(chatHtml);
                roomElement.scrollTop(roomElement[0].scrollHeight);
            }
        });

        // Start/Stop Recording
        $('#recordButton').on('click', function () {
            if (!isRecording) {
                // Start recording
                navigator.mediaDevices.getUserMedia({ audio: true })
                    .then(stream => {
                        mediaRecorder = new MediaRecorder(stream);
                        mediaRecorder.start();

                        isRecording = true;
                        $('#recordButton').html("<i class='fa fa-record-vinyl'></i>");
                        $('#deleteRecording, #sendRecording').attr('disabled', true);
                        $('#deleteRecording, #sendRecording').css('display', 'none');

                        mediaRecorder.ondataavailable = event => {
                            audioChunks.push(event.data);
                        };
                    })
                    .catch(error => {
                        console.error('Microphone access error:', error);
                        alert('Failed to access microphone.');
                    });
            } else {
                // Stop recording
                mediaRecorder.stop();
                isRecording = false;
                $('#recordButton').html('<button id="recordButton" class="btn btn-primary"><i class="fa fa-microphone"></i> </button>');

                mediaRecorder.onstop = () => {
                    audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                    audioUrl = URL.createObjectURL(audioBlob);
                    $('#audioPreview').html(`
                            <audio controls>
                                <source src="${audioUrl}" type="audio/wav">
                                Your browser does not support the audio element.
                            </audio>
                    `);
                    $('#deleteRecording, #sendRecording').attr('disabled', false);
                    $('#deleteRecording, #sendRecording').css('display', 'block');

                    // Clear audio chunks for the next recording
                    audioChunks = [];
                };
            }
        });

        // Delete Recording
        $('#deleteRecording').on('click', function () {
            audioChunks = [];
            $('#audioPreview').html('');
            $('#deleteRecording, #sendRecording').attr('disabled', true);
            $('#deleteRecording, #sendRecording').css('display', 'none');
        });

        // Send Recording via AJAX
        $('#sendRecording').on('click', function () {
            let message = $('#message_input').val();
            let user_to = $("#user_to").val();
            let room_type = $("#room_type").val();
            let room_id = $("#room_id").val();
            let formData = new FormData();

            formData.append('voice', audioBlob); // Append the audio file
            formData.append('message', message);
            formData.append('room_type', room_type);
            formData.append('room_id', room_id);
            if(room_id)
            {
             if (room_type != 'Gruppe') {
                    formData.append('to', user_to);
               }
            }
            formData.append('_token', '{{ csrf_token() }}'); // CSRF token

            // Display loading indicator in the chat
            let loadingHtml = `
                <div id="loadingMessage" class="message">
                    <div class="message-wrapper">
                        <div class="message-content">
                            <div class="loading-indicator">
                                <span class="loading-text">Sending audio...</span>
                                <div class="spinner"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#messageBody').append(loadingHtml);


            // AJAX call to send audio
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.chat.send_message') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#loadingMessage').remove(); // Remove loading indicator
                    $('#audioPreview').html('');
                    $('#deleteRecording, #sendRecording').attr('disabled', true);
                    $('#deleteRecording, #sendRecording').css('display', 'none');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Failed to send audio. Please try again.');
                    console.error('Error details:', textStatus, errorThrown);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {

        // Get references to the input and the user list
        const searchInput = document.getElementById('searchInput');
        const userList = document.getElementById('userList');

        // Add an event listener to the search input field
        searchInput.addEventListener('keyup', function () {
            const query = this.value.toLowerCase();
            const users = userList.getElementsByTagName('li');

            // Loop through all the list items and hide those that don't match the search query
            for (let i = 0; i < users.length; i++) {
                const userName = users[i].querySelector('.media-body h6 a').textContent.toLowerCase();
                if (userName.includes(query)) {
                    users[i].style.display = '';
                } else {
                    users[i].style.display = 'none';
                }
            }
        });

    });
</script>
<script>
    $(document).ready(function () {

        // Get references to the input and the user list
        const searchInput = document.getElementById('searchInput');
        const userList = document.getElementById('userList');

        // Add an event listener to the search input field
        searchInput.addEventListener('keyup', function () {
            const query = this.value.toLowerCase();
            const users = userList.getElementsByTagName('li');

            // Loop through all the list items and hide those that don't match the search query
            for (let i = 0; i < users.length; i++) {
                const userName = users[i].querySelector('.media-body h6 a').textContent.toLowerCase();
                if (userName.includes(query)) {
                    users[i].style.display = '';
                } else {
                    users[i].style.display = 'none';
                }
            }
        });

    });
</script>
<script>
    function collectSelectedUsers() {
        const checkboxes = document.querySelectorAll('.user-checkbox:checked');
        const selectedUsers = Array.from(checkboxes).map(checkbox => checkbox.value);

        // Include the authenticated user's ID
        const authUserId = "{{ auth()->id() }}";
        if (authUserId) {
            selectedUsers.push(authUserId);
        }

        // Store the selected users as a JSON string in the hidden input
        document.getElementById('selectedUsers').value = JSON.stringify(selectedUsers);

        return true; // Allow form submission
    }

</script>
<script>
    $(document).ready(function() {
        // Search filter event
        $('#top_searchInput').on('input', function() {
            var searchTerm = $(this).val().toLowerCase(); // Get the input value and convert to lowercase
            $('#chatContactTab .contacts-item').each(function() {
                var userName = $(this).data('name').toLowerCase(); // Get the user name from the data-name attribute

                // If the user name contains the search term, show the item, otherwise hide it
                if (userName.indexOf(searchTerm) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
