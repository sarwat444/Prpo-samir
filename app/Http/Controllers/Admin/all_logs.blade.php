@extends('layouts.dashboard')
@section('css')
<link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
<script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}" ></script>
<link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
<link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">
@endsection
@section('title')Meine Aufgaben @endsection
@section('content')
<!--Start  Users Tasks -->
<div class="container">
    <div class="mytasks">

           <div class="sub-tasks">

                    <div class="tasks user_subtasks">

                @if(!empty($logs))
                 @foreach($logs as $log)
                    @php dd($log); @endphp
                   <div class="row task">x

                       <div class="col-md-2">
                          <p>@if(!empty($log->userImage->user_name)) {{$log->userImage->user_name}}    @else  "User deleted" @endif </p>
                      </div>
                    <div class="col-md-7">
                          <p class="sub-date">
                           <span class="last-updates" > Log Description </span>
                             {!!$log->log_desc !!}  </p>
                      </div>

                       <div class="col-md-2">
                          <p class="sub-date">
                         <span >Date</span>
                          {{ date('d.m.Y', strtotime($log->created_at))}}
                            </p>
                      </div>
                   </div>
                   @endforeach
                 @endif

               </div>

           </div>
    </div >
</div>
<!--End Users Tasks -->
@endsection

@endsection
