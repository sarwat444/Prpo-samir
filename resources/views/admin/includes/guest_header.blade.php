
  <div class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
                  <a class="navbar-brand" href="{{url('/admin')}}">{{!empty($title) ? $title : 'Pripo'}}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
            </div>
            <div class="btn-group float-end">
          
           

                <div class="btn-group float-end">
                    <a href="#" class="dropdown-toggle text-decoration-none text-light" data-bs-toggle="dropdown">
                    <!--<i class="bi bi-person-circle"></i>-->
                          <img src="{{asset('public/assets/images/users/'.auth()->user()->image)}}" style="width:30px;height:30px;" class="rounded-circle">
                        <span>{{ Str::limit(auth()->user()->user_name, 8) }}</span>

                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">

                            <li><a href="#" class="dropdown-item" data-type="profile_update" id="update_profile"><i class="bi bi-lock-fill"></i>  Profil aktualisieren </a></li>
                            <li><a href="{{route('admin.guestsubtasks')}}" class="dropdown-item"><i class="bi bi-box-arrow-right"></i>  Meine Aufgaben  </a></li>
                              <li><a href="{{route('admin.usertasks')}}" class="dropdown-item"><i class="bi bi-list-task"></i>  Meine Aufgaben  </a></li>
                           <li><a href="{{route('admin.subtasks.assigned_tasks')}}" class="dropdown-item"><i class="bi bi-list-check"></i>  Vergebene Aufgaben  </a></li>
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
    


      <div class="overlay"></div>
      <div class="search-overlay"></div>
