@extends('layouts.admin')
@section('content')

    <!--Start  Add new Account -->
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{__('messages.Add_New_Account')}}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Accounts</a></li>
                                    <li class="breadcrumb-item active">{{__('messages.Add_New_Account')}}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
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

                                <form class="text-left" id="add_user" action="{{route('admin.account.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                <div class="row">
                                        <div class="col-sm-6">

                                            <div class="mb-3">
                                                <label for="first_name">{{__('messages.firstname')}} </label>
                                                <input id="first_name" name="first_name" type="text" class="form-control" placeholder="{{__('messages.firstname')}}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="last_name">{{__('messages.lastname')}} </label>
                                                <input id="last_name" name="last_name" type="text" class="form-control" placeholder="{{__('messages.lastname')}}">
                                            </div>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="mb-3">
                                                <label for="password">{{__('messages.username')}}</label>
                                                <input id="user_name" name="user_name" type="text" class="form-control" placeholder="{{__('messages.Username')}}">

                                            </div>
                                            <div class="mb-3">
                                                <label for="emai">Email </label>
                                                <input id="emai" name="email" type="text" class="form-control" placeholder="Email">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="password">{{__('messages.password')}} </label>
                                                <input id="password" name="password" type="password" class="form-control" placeholder="{{__('messages.password')}}" autocomplete="off">

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="password_confirmation"> {{__('messages.confirm_password')}}</label>
                                                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="{{__('messages.confirm_password')}}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="Image">{{__('messages.image')}} </label>
                                                <input id="image" name="image" type="file" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="control-label">{{__('messages.Package')}}</label>
                                                <select class="selectpicker form-control" id="package_id" name="package_id" data-size="5" >
                                                       <option value="">{{__('messages.Package')}}</option>
                                                        @foreach ($packages as $key => $package)
                                                            <option value="{{$package->id}}"> {{$package->package_name }} </option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="submit" class="btn btn-primary"> {{__('messages.save')}} </button>
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
                        <script>document.write(new Date().getFullYear())</script> © Pripo.
                    </div>

                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

@endsection
