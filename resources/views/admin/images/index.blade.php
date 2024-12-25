
        @foreach($messages as $message)
            <div class="chat" data-chat="person{{$receiver}}">
                {{--if message from id is equal to auth id then it is sent by logged in user --}}
                <div class="{{ ($message->from == Auth::id()) ? 'sent' : 'received' }}" >

                      @if(!empty($message->image ))  <img src="{{asset('assets/images/messages/'. $message->image)}}" style="width:100%;height:100%;">    @endif

                    <div class="conversation-start">
                        <span>{{ date('d M y, h:i a', strtotime($message->created_at)) }}</span>
                    </div>
                            @if(!empty($message->message ))
                    <div class="bubble you">
                         {{$message->message }}
                    </div>
                     @endif
                </div>
            </div>
        @endforeach


<script>
// $(document).ready(function(){
//
//
//
//    var receiver_id = 'er';
//   $('.user').click(function () {
//
//       receiver_id = $(this).attr('id');
//
//   });
//     $("#myInput").change(function(){
//
//              var imge = $(this).val();
//              alert(receiver_id) ;
//
//     });
// });
</script>
