@extends('layouts.admin')

@section('title')
    Pripo Packages
@endsection
@section('css')
<style>
    .modal-content .modal-header
    {
        padding: 12px 26px;
        border: 1px solid #e0e6ed;
        border: 0;
        padding: 27px;
    }
    .modal-content .modal-footer
    {
        border: 0 ;
    }
  .card
  {
      min-height:230px ; 
  }
</style>
@endsection

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
                            <h4 class="mb-sm-0 font-size-18">{{__('messages.packages')}}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active"> {{__('messages.packages')}}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <!--Start Package  cards -->
                    @if(!empty($datas))
                        <?php foreach ($datas as $key => $data): ?>
                        <div class="col-xl-4 col-sm-6">
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
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle card-drop float-end" data-bs-toggle="dropdown" aria-expanded="false" >
                                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item btn-edit-package text-success" data-id=" {{ $data -> id }}"  > <i class="bx bxs-edit-alt"></i> {{__('messages.edit_package')}}</a>
                                        <a class="dropdown-item btn-invite-package-user text-primary" data-id=" {{ $data ->id }}" > <i class="bx bx-envelope"></i>{{__('messages.invite_user')}}</a>
                                        <a class="dropdown-item btn-remove text-danger" data-id=" {{ $data ->id }}" > <i class="bx bx-trash"></i> {{__('messages.delete_package')}} </a>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-4">
                                            <div class="avatar-md">
                                                        <span class="avatar-title rounded-circle bg-light text-danger font-size-16">
                                                            <img src="assets/images/companies/img-1.png" alt="" height="30">
                                                        </span>
                                            </div>
                                    </div>

                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="text-truncate font-size-15"><a href="javascript: void(0);" class="text-dark">{{$data->package_name}} </a></h5>
                                        <p class="text-muted mb-4">{{$data->package_desc}}</p>
                                        <h4 class="text-primary" style="font-size:15px">{{__('messages.Package_Details')}}</h4>
                                            <ul style="margin: 0;list-style-type: circle;">
                                                <li>Number Of users - {{$data->user_limit}}</li>
                                            </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 border-top">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item me-3 float-start ">
                                        <i class= "bx bx-calendar me-1"></i> {{ date('d.m.Y' , strtotime($data->created_at)) }}
                                    </li>
                                    <li class="list-inline-item me-3 float-end">
                                        <span class="badge bg-success" style="font-size: 16px;"> {{$data->package_price}} €  </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                        <?php endforeach; ?>
                        @endif

                    <!--End Packages Cards -->

                </div>

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <!-- Modal -->
        <div class="modal fade" id="EditPackageModal" tabindex="-1" role="dialog"
             aria-labelledby="EditPackageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal_body  edit_package_modal container">
                    </div>


                </div>
            </div>
        </div>


        <div class="modal fade" id="InvitePackageModal" tabindex="-1" role="dialog" aria-labelledby="InvitePackageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Konto hinzufügen </h5>
                    </div>
                    <div class="modal_body  invite_package_modal container">
                    </div>
                </div>
            </div>
        </div>

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
        @section('script')
            <script>
                $(document).ready(function () {
                    $(document).on('click', '.btn-invite-package-user', function (event) {
                        //  alert('hello');
                        event.preventDefault();
                        var id = $(this).data('id');

                        $.ajax({

                            type: "post",
                            url: "{{route('admin.packages.add_account')}}", // need to create this post route
                            data: {id: id, _token: '{{ csrf_token() }}'},
                            cache: false,
                            success: function (data) {


                                $('#InvitePackageModal').modal('show');
                                $(".invite_package_modal").html(data);
                            },
                            error: function (jqXHR, status, err) {


                            },

                        });
                    });

                });
                // invite user
            </script>
            <script>
                $(document).ready(function () {
                    $(document).on('click', '.btn-edit-package', function (event) {

                        event.preventDefault();
                        var id = $(this).data('id');

                        $.ajax({

                            type: "post",
                            url: "{{route('admin.packages.edit')}}", // need to create this post route
                            data: {id: id, _token: '{{ csrf_token() }}'},
                            cache: false,
                            success: function (data) {

                                $('#EditPackageModal').modal('show');
                                $(".edit_package_modal").html(data);
                            },
                            error: function (jqXHR, status, err) {


                            },

                        });
                    });
                });
                // Delete Category

                $(document).on('click', '.btn-remove', function (e) {
                    if (!confirm("Are You Sure You Will Delete This Record")) {
                        e.preventDefault();
                        return false;
                    }
                    var selector = $(this);
                    var id = $(this).data('id');
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('admin.packages.delete') }}',
                        data: {id: id, _token: '{{ csrf_token() }}'},
                        success: function (data) {
                            if (data.status == true) {
                                selector.closest('tr').hide('slow');
                                $('.error').css('display', 'none');
                                $('.success').css('display', 'block');
                                $('.success').html(data.msg);
                            } else {
                                $('.error').css('display', 'block');
                                $('.success').css('display', 'none');
                                $('.error').html(data.msg);
                            }
                            //  toastr.success(data.msg);
                            window.location.reload();
                        },
                        error: function (data) {
                            toastr.error(data.msg);
                        }
                    });
                });

            </script>
@stop
