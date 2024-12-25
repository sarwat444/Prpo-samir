@extends('layouts.admin')
@section('css')
    <link  rel="stylesheet" type="text/css"  href="{{asset('public/public/assets/crm/libs/select2/css/select2.min.css')}}" />
    <link  rel="stylesheet" type="text/css"  href="{{asset('public/public/assets/crm/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}"/>
    <link  rel="stylesheet" type="text/css"  href="{{asset('public/public/assets/crm/libs/spectrum-colorpicker2/spectrum.min.css')}}">
    <link  rel="stylesheet" type="text/css"  href="{{asset('public/public/assets/crm/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}">
    <link  rel="stylesheet" type="text/css"  href="{{asset('public/public/assets/crm/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}">
    <style>
    .page-content
    {
        min-height: 580px;
    }
    .warnalert
    {
        display:none ;
    }
    </style>
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @if(session()->has('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif
                <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">{{__('messages.Delete Selected Data')}}</h4>
                    <div class="alert alert-warning alert-dismissible fade show warnalert" role="alert">
                        <i class="mdi mdi-alert-outline me-2"></i>
                          A simple warning alert—check it out!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <form action="{{route('admin.deleteModule')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                 <div class="mb-4">
                                        <label> Type </label>
                                        <select name="module_name" class="form-control change_modules">
                                            <option value="posts">    {{__('messages.post')}} </option>
                                            <option value="subtasks"> {{__('messages.Subtask')}}  </option>
                                            <option value="comments"> {{__('messages.comments')}} </option>
                                            <option value="tags">     {{__('messages.tags')}} </option>
                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label>{{__('messages.Select Range Date')}}</label>
                                    <div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                        <input type="text" class="form-control" name="start" placeholder="{{__('messages.Start Date')}}" />
                                        <input type="text" class="form-control" name="end" placeholder="{{__('messages.End Date')}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-danger">{{__('messages.delete')}}</button>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('public/public/assets/crm/libs/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/spectrum-colorpicker2/spectrum.min.js')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/@chenfengyuan/datepicker/datepicker.min.js')}}"></script>
    <!-- form advanced init -->
    <script src="{{asset('public/public/assets/crm/js/pages/form-advanced.init.js')}} "></script>
    <script>
        $(document).ready(function (){
            setTimeout(()=>{
                $('.alert').css('display' , 'none') ;
            },3000)

            $('.change_modules').on('change' , function(){
               if($(this).val() == 'posts')
               {
                   $('.warnalert').html('<i class="mdi mdi-alert-outline me-2"></i> Notice ! Tasks with its Comments, Replays, subtasks will be Deleted');
                   $('.warnalert').css('display', 'block') ;

               }
               else if ($(this).val() == 'comments')
               {
                   $('.warnalert').html('<i class="mdi mdi-alert-outline me-2"></i> Notice ! Comments with its  Replays   will be Deleted');
                   $('.warnalert').css('display', 'block') ;
               }
               else if($(this).val() == 'tags')
               {
                   $('.warnalert').html('<i class="mdi mdi-alert-outline me-2"></i> Notice ! Tags  with its  Categorie  will be Deleted');
                   $('.warnalert').css('display', 'block') ;
               }
            });
        })
    </script>
@endsection
