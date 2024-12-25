@extends('layouts.dashboard')
@section('css')
<link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
<script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}" ></script>
<link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>

@endsection
@section('title')Meine Aufgaben @endsection
@section('content')
<!--Start  Users Tasks -->
<div class="container">
    <div class="mytasks">

           <div class="sub-tasks">

                    <div class="tasks user_subtasks">

                @if(!empty($logs))

                <div class="row task">

                   <div class="col-md-1">
                      Nutzername
                     </div>


                     <div class="col-md-2">
                        Unteraufgabe
                       </div>

                       <div class="col-md-2">
                           Post-it
                         </div>

                         <div class="col-md-2">
                           Kategorie
                           </div>

                     <div class="col-md-1">
                         Bezeichnung
                    </div>
                    <div class="col-md-2">
                          Erstellt am
                      </div>

                    <div class="col-md-1">
                       <p class="sub-date">
                      <span >Details</span>
                         </p>
                   </div>



                </div>

                 @foreach($logs as $log)

                   <div class="row task">

                       <div class="col-md-1">
                          <p>@if(!empty($log->userImage->user_name)) {{$log->userImage->user_name}}    @else  "User deleted" @endif </p>
                      </div>


                      <div class="col-md-2">
                         <p>   @if(!empty($log->subtask->subtask_title))    {{$log->subtask->subtask_title }} @else -- @endif </p>
                     </div>

                     <div class="col-md-2">
                        <p>   @if(!empty($log->task->task_title))    {{$log->task->task_title }} @else -- @endif </p>
                    </div>

                    <div class="col-md-2">
                       <p>   @if(!empty($log->category->category_name))    {{$log->category->category_name }} @else -- @endif </p>
                   </div>

                    <div class="col-md-1">
                          <p class="sub-date">

                             {!!$log->log_desc !!}  </p>
                      </div>

                       <div class="col-md-2">
                          <p class="sub-date">

                          {{ date('d.m.Y', strtotime($log->created_at))}}
                            </p>
                      </div>

                      <div class="col-md-1">

                         @if(!empty($log->log_task_id))
                           <p><i class="fa fa-eye btn-task-popup" data-id="{{$log->log_task_id}}"></i></p>
                          @else
                             @if(!empty($log->log_subtask_id))
                                 @php
                                    $subtask = \App\Models\SubTask::where('id' , $log->log_subtask_id)->first();
                                 @endphp
                                   @if(!empty($subtask))
                                       <p><i class="fa fa-eye btn-task-popup" data-id="{{$subtask->task_id}}"></i></p>
                                   @endif
                             @endif
                         @endif


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
