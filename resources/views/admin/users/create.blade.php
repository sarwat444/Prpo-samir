@extends('layouts.admin')
@section('content')
<!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
      <div class="container">
          <div class="container">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @include('admin.includes.alerts.success')
            @include('admin.includes.alerts.errors')
           <div class="row layout-top-spacing">
             <div id="basic" class="col-lg-12 layout-spacing">
              <div class="statbox widget box box-shadow">
                  <div class="widget-header">
                      <div class="row">
                          <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                              <h4> Add New Package </h4>
                          </div>
                      </div>
                  </div>
              <div class="widget-content widget-content-area">
                  <form class="text-left" id="add_user" action="{{route('admin.register')}}" method="POST" enctype="multipart/form-data">
                               @csrf
                          <div id="username-field" class="field-wrapper input form-group">
                            
                              <label>First Name</label>
                              <input id="first_name" name="first_name" type="text" class="form-control" placeholder="First Name">
                          </div>

                          <div id="username-field" class="field-wrapper input form-group">
                              <label>Last Name</label>
                              <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Last Name">
                          </div>

                          <div id="username-field" class="field-wrapper input form-group">
                                
                                <label>User Name</label>
                                <input id="user_name" name="user_name" type="text" class="form-control" placeholder="User Name" autocomplete="off">
                          </div>
                        <div id="username-field" class="field-wrapper input form-group">
                               <label> Email</label>
                            <input id="emai" name="email" type="text" class="form-control" placeholder="Email">
                        </div>

                        <div id="password-field" class="field-wrapper input mb-2 form-group">
                              <label> Password</label>
                            <input id="password" name="password" type="password" class="form-control" placeholder="Password" autocomplete="off">
                        </div>

                        <div id="password-field" class="field-wrapper input mb-2 form-group">
                             
                                <label> confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password" autocomplete="off">
                        </div>

                        <div id="password-field" class="field-wrapper input mb-2 form-group">
                          
                            <input id="image" name="image" type="file" class="form-control">
                        </div>

                     
                                <button type="submit" class="btn btn-primary"> Save </button>
                          



                    
                    
                        
                </form>
                
            <div class="code-section-container show-code">
             <div class="code-section text-left">
           </div>
              </div>
        </div>
        </div>
        </div>
        </div>
       </div>
      </div>
     </div>
@endsection
