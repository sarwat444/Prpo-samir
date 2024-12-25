@extends('layouts.admin')
@section('css')
    <link href="{{asset('public/public/assets/crm/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/public/assets/crm/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/public/assets/crm/libs/spectrum-colorpicker2/spectrum.min.css')}}" rel="stylesheet" type="text/css">
@endsection


@section('content')
    <!--Create New Category -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{__('messages.Add_New_Category')}}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{__('messages.Categories')}}</a></li>
                                    <li class="breadcrumb-item active">{{__('messages.Add_New_Category')}} </li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            @if (session('success'))
                                <div class="alert alert-success" id="successMessage">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card-body">
                                <form id="create-category" action="{{route('admin.categories.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="form-label">{{__('messages.Category')}}</label>
                                            <input type="text" name="category_name" class="form-control" placeholder="{{__('messages.Category')}}">
                                        </div>

                                        <div class="col-sm-6">
                                            <label class="form-label">{{__('messages.Color')}}</label>
                                            <input type="text" class="form-control" name="category_color"  placeholder="{{__('messages.Color')}}" id="colorpicker-default" value="#f1b44c">
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2 " style="margin-top: 23px" >
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{__('messages.save')}} </button>
                                        <button type="button" class="btn btn-secondary waves-effect waves-light">{{__('messages.cancle')}}</button>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>

                </div>
                <!-- end row -->


            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © Germaniatek.
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!--End category -->

@endsection
@section('script')

    <script src="{{asset('public/public/assets/crm/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/spectrum-colorpicker2/spectrum.min.js')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <!-- form advanced init -->
    <script src="{{asset('public/public/assets/crm/js/pages/form-advanced.init.js')}}"></script>
    <script src="{{asset('public/public/assets/crm/js/app.js')}}"></script>

@endsection
