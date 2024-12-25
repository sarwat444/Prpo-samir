 @if(!empty($users2))   
        <option value=""> Online Users </option>
      @foreach($users2 as $user) 
          <option value="{{$user->id}}" data-image="{{asset('public/assets/images/users/'.$user->image)}}">   {{$user->user_name}}   <i class="bi bi-circle-fill"></i> </option>
      @endforeach
      @endif