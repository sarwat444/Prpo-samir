
  <div class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
                  <a class="navbar-brand" href="{{url('/admin')}}">{{!empty($title) ? $title : 'Pripo'}}  </a>
              <p id="toptimer"> <span id="tasktimer2"></span></p>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
            </div>
            <div class="btn-group float-end">
            <ul class="navbar-nav navbar-light nav-bar">
              @auth

                   <li class="nav-item">

                      <nav class="notfi">
                     <div class="notfi-logo">   </div>
                     <div class="notfi-icon" id="notfi-bell"> <img src="{{asset('public/assets/images/notification.png')}}" alt=""> </div>
                     <div>
                     <div class="notfi-notifications" id="notfi-box">
                         <div class="notifation-header">
                             <h3>Benachrichtigungen</h3>
                             <a class="notifactino-button" href="{{route('admin.get.all_logs')}}" style="color:#000;"> Alle ansehen </a>
                         </div>
                       <div id="notifayitems" >
        @php
        $logs = \App\Models\Log::orderBy('id','desc')->limit(10)->get();
        @endphp

        @if(!empty($logs))

         @foreach($logs as $log )

               @php
                    $arr = json_decode($log->is_read) ;


               @endphp

               @if(!empty($arr))
          @if((!in_array(Auth::user()->id , $arr)))


           @if(!empty($log->log_task_id))
                          <div class="notfi-notifications-item">
                              <a href=""  data-log="{{$log->id}}" class="btn-task-popup" data-id="{{$log->log_task_id}}">
                               <div class="display-flex">
                                @if(!empty($log->userImage->image))   <img   src="{{asset('public/assets/images/users/'.$log->userImage->image) }}" alt="img2">  @else     <img src="https://i.imgur.com/uIgDDDd.jpg" alt="img"> @endif
                                 <h2> @if(!empty($log->userImage->user_name)) {{$log->userImage->user_name}}    @else  "User deleted" @endif  </h2>
                                 </div>
                                     <div class="text">
                                        <p> {!!$log->log_desc!!}
                                     </p>
                                  </div>
                                    </a>
                            </div>
                            @else

                            <div class="notfi-notifications-item">
                               <a class="notifactino-button" href="{{url('admin/categories/all/'.$log->id)}}" >
                                 <div class="display-flex">
                                  @if(!empty($log->userImage->image))   <img   src="{{asset('public/assets/images/users/'.$log->userImage->image) }}" alt="img2">  @else     <img src="https://i.imgur.com/uIgDDDd.jpg" alt="img"> @endif
                                   <h2> @if(!empty($log->userImage->user_name)) {{$log->userImage->user_name}}    @else  "User deleted" @endif  </h2>
                                   </div>
                                       <div class="text">
                                          <p> {!!$log->log_desc!!}
                                       </p>
                                    </div>
                                      </a>
                              </div>

                            @endif


                            @else

                   @php
                      continue;
                   @endphp
                @endif

                @else


            @if(!empty($log->subtask->task_id))

            <div class="notfi-notifications-item">
                <a href=""  data-log="{{$log->id}}" class="btn-task-popup" data-id="{{$log->subtask->task_id}}">
                 <div class="display-flex">
                  @if(!empty($log->userImage->image))   <img   src="{{asset('public/assets/images/users/'.$log->userImage->image) }}" alt="img2">  @else     <img src="https://i.imgur.com/uIgDDDd.jpg" alt="img"> @endif
                   <h2> @if(!empty($log->userImage->user_name)) {{$log->userImage->user_name}}    @else  "User deleted" @endif  </h2>
                   </div>
                       <div class="text">
                          <p> {!!$log->log_desc!!}
                       </p>
                    </div>
                      </a>
              </div>

               @else

               <div class="notfi-notifications-item">
                   <a href="{{url('admin/categories/all/'.$log->id)}}" >
                    <div class="display-flex">
                     @if(!empty($log->userImage->image))   <img   src="{{asset('public/assets/images/users/'.$log->userImage->image) }}" alt="img2">  @else     <img src="https://i.imgur.com/uIgDDDd.jpg" alt="img"> @endif
                      <h2> @if(!empty($log->userImage->user_name)) {{$log->userImage->user_name}}    @else  "User deleted" @endif  </h2>
                      </div>
                          <div class="text">
                             <p> {!!$log->log_desc!!}
                          </p>
                       </div>
                         </a>
                 </div>

                 @endif



                @endif




            @endforeach
          @endif
                  </div>
</div>
                 </nav>
               </li>
                             @endauth


                             @php
                                     $users = \App\Models\User::where('login_status',1)->get();
                                  @endphp



                              <li class="nav-item dropdown ">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                           <i class="fal fa-user"></i>
                                        </a>

                                       @if(!empty($users))

                                        <ul class="dropdown-menu ul-users" id="links" aria-labelledby="navbarDropdownMenuLink">

                                             @foreach($users as $user)
                                           <li>
                                              <a class="dropdown-item user-data"  href="#">
                                               <img src="{{asset('public/assets/images/users/'.$user->image)}}" alt="img" class="img-user">
                                               <h5> {{$user->user_name}}  </h5>
                                              </a>
                                              </li>
                                              @endforeach


                                        </ul>

                                        @endif

                                  </li>


                   @if($status == 2)

                 <li class="nav-item">

                  <a class="nav-link" href="{{route('admin.dashboard','deleted')}}"  role="button" aria-expanded="false">
                     <i class="bi bi-trash" style=""></i>
                  </a>
                </li>

                @else

                <li class="nav-item">

                  <a class="nav-link" href="{{route('admin.dashboard','deleted')}}"  role="button" aria-expanded="false">
                     <i class="bi bi-trash" ></i>
                  </a>

                </li>
                @endif



                @if($status == 1)
                 <li class="nav-item">
                  <a class="nav-link" href="{{route('admin.dashboard','completed')}}"   role="button" aria-expanded="false">
                     <i class="bi bi-check-circle" style="color:green;font-size:28px;"></i>
                  </a>

                </li>
                @else
                    <li class="nav-item">
                  <a class="nav-link" href="{{route('admin.dashboard','completed')}}"   role="button" aria-expanded="false">
                     <i class="bi bi-check-circle" style="color:green"></i>
                  </a>

                </li>
                @endif


                  @if($status == 0)

                    <li class="nav-item">
                  <a class="nav-link" href="{{route('admin.dashboard')}}"   role="button" aria-expanded="false">
                     <i class="bi bi-check-circle" style="color:#fff;font-size:25px;"></i>
                  </a>

                </li>
                @else

               <li class="nav-item">
                  <a class="nav-link" href="{{route('admin.dashboard')}}"   role="button" aria-expanded="false">
                     <i class="bi bi-check-circle" style="color:#fff;font-size:20px;"></i>
                  </a>

                </li>
                @endif


                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     <i class="bi bi-plus-circle-fill"></i>
                  </a>
                  <ul class="dropdown-menu" id="links" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" data-type="task_create" href="#">Post-it</a></li>
                    <li><a class="dropdown-item" data-type="project_create"  href="#">Task</a></li>
                    <li><a class="dropdown-item" data-type="tag_create"  href="#">Tag</a></li>
                    @if(Auth::user()->role == 4)
                        <li><a class="dropdown-item" data-type="user_create"  href="#">Benutzer</a></li>
                   @endif
                     @if(Auth::user()->role == 1)
                      <li><a class="dropdown-item" data-type="user_create"  href="#">Benutzer</a></li>
                      <li><a class="dropdown-item" data-type="guest_create"  href="#">Besucher</a></li>
                      <li><a class="dropdown-item" data-type="invite_create"  href="#">Invite</a></li>
                      @endif
                  </ul>

                </li>

                 </div>

                <div class="btn-group float-end">
                    <a href="#" class="dropdown-toggle text-decoration-none text-light" data-bs-toggle="dropdown">
                    <!--<i class="bi bi-person-circle"></i>-->
                          <img src="{{asset('public/assets/images/users/'.auth()->user()->image)}}" style="width:30px;height:30px;" class="rounded-circle">
                    <span> {{ Auth::user()->user_name  }}  </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">

                           <li><a href="#" class="dropdown-item" data-type="profile_update" id="update_profile"><i class="bi bi-person-circle"></i>  Profil aktualisieren </a></li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                          @if(Auth::user()->role == 1)
                          <li><a class="dropdown-item" data-type="user_create"  href="{{route('admin.categories')}}"><i class="bi bi-menu-button-wide-fill"></i> CRM</a></li>
                          @endif

                          <li>
                            <hr class="dropdown-divider">
                        </li>
                           <li><a href="{{route('admin.usertasks')}}" class="dropdown-item"><i class="bi bi-list-task"></i>  Meine Aufgaben  </a></li>
                           <li><a href="{{route('admin.subtasks.task_history')}}" class="dropdown-item"><i class="bi bi-alarm"></i>  Zeiterfassung  </a></li>
                           <li><a href="{{route('admin.subtasks.viewcomments')}}" class="dropdown-item"><i class="bi bi-chat-dots"></i>  Kommentare  </a></li>
                           <li><a href="{{route('admin.logout')}}" class="dropdown-item"><i class="bi bi-box-arrow-left"></i>  Ausloggen  </a></li>
                    </ul>
                </div>






          </div>
        </nav>
  </div>


  <!--  BEGIN MAIN CONTAINER  -->
  <div class="main-container" id="container">
     <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Noch da?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <p> Bist du noch da? </p>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" id="popup_button">Ja</button>
      </div>
    </div>
  </div>
</div>


      <div class="overlay"></div>
      <div class="search-overlay"></div>
