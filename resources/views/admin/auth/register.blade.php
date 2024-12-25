@extends('layouts.login')
@section('title','register')
@section('content')
<div class="form-form">
    <div class="form-form-wrap">
        <div class="form-container">
            <div class="form-content">
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

                <h1 class="">Sign Up<a href="{{route('admin.dashboard')}}"><span class="brand-name">To Pripo</span></a></h1>
                <!-- <p class="signup-link">New Here? <a href="auth_register.html">Create an account</a></p> -->
                <form class="text-left" action="{{route('admin.register')}}" method="post" enctype="multipart/form-data">
                                @csrf
                    <div class="form">

                          <div id="username-field" class="field-wrapper input">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                              <input id="first_name" name="first_name" type="text" class="form-control" placeholder="First Name">
                          </div>

                          <div id="username-field" class="field-wrapper input">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                              <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Last Name">
                          </div>

                          <div id="username-field" class="field-wrapper input">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                              <input id="user_name" name="user_name" type="text" class="form-control" placeholder="User Name">
                          </div>
                        <div id="username-field" class="field-wrapper input">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <input id="emai" name="email" type="text" class="form-control" placeholder="Email">
                        </div>

                        <div id="password-field" class="field-wrapper input mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                        </div>

                        <div id="password-field" class="field-wrapper input mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password">
                        </div>

                        <div id="password-field" class="field-wrapper input mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            <input id="image" name="image" type="file" class="form-control">
                        </div>

                        <div class="d-sm-flex justify-content-between">
                            <div class="field-wrapper toggle-pass">
                                <p class="d-inline-block">Show Password</p>
                                <label class="switch s-primary">
                                    <input type="checkbox" id="toggle-password" class="d-none">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="field-wrapper">
                                <button type="submit" class="btn btn-primary" value="">Sign Up</button>
                            </div>

                        </div>



                        <!-- <div class="field-wrapper">
                            <a href="auth_pass_recovery.html" class="forgot-pass-link">Forgot Password?</a>
                        </div> -->

                    </div>
                </form>



            </div>
        </div>
    </div>
</div>
<div class="form-image">
    <div class="l-image">
    </div>
</div>
@endsection
