@extends('layouts.admin')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{__('messages.create_new_package')}}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">{{__('messages.create_new_package')}} </li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="create-category" action="{{route('admin.packages.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-lg-12">
                                            <label for="packagename" class="col-form-label col-lg-2">{{__('messages.Package')}}</label>
                                            <input id="packagename" type="text" name="package_name" class="form-control" placeholder="{{__('messages.Package')}}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-6">
                                            <label for="price" class="col-form-label col-lg-2">{{__('messages.price')}} - € </label>
                                            <input id="price" type="number" name="package_price" class="form-control" placeholder="{{__('messages.price')}}" >
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="projectname" class="col-form-label col-lg-2">{{__('messages.user_limit')}} </label>
                                            <input type="number" name="user_limit" class="form-control" placeholder="{{__('messages.user_limit')}}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-12">
                                            <label for="projectdesc" class="col-form-label col-lg-2"> {{__('messages.desc')}}</label>
                                            <textarea name="package_desc" class="form-control"  rows="3" placeholder="{{__('messages.desc')}} ..." ></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary"> {{__('messages.save')}}</button>
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
    <!-- end main content-->
@endsection
