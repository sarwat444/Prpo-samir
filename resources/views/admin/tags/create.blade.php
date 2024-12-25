@extends('layouts.admin')
@section('content')


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
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tags</a></li>
                                    <li class="breadcrumb-item active">{{__('messages.new_tag')}}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
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

                            <div class="card-body">
                                 <form id="create-category" action="{{route('admin.tags.store')}}" method="POST" enctype="multipart/form-data">
                                         @csrf
                                            <div class="row mb-5">
                                                <div class="col-sm-12">
                                                    <label class="form-label">Tag</label>
                                                    <input type="text" class="form-control"   name="tag_name" placeholder="Tag">
                                                </div>
                                            </div>
                                            <label class="form-label">{{__('messages.Category')}}</label>
                                            <div class="row">
                                                @foreach($categories as $category)
                                                <div class="col-xl-3 col-sm-6">
                                                    <div class="mt-4">
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input"  type="checkbox" name="category_id[]"  value="{{$category->id}}" id="formCheck{{$category->id}}">
                                                            <label class="form-check-label" for="formCheck{{$category->id}}">
                                                                {{$category->category_name}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach

                                            </div>
                                          <button type="submit" class="btn btn-primary mt-5"> {{__('messages.save')}}</button>
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
