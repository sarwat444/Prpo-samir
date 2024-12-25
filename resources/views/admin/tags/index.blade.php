@extends('layouts.admin')
@section('css')
    <link href="{{asset('public/public/assets/crm/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/public/assets/crm/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/public/assets/crm/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{__('messages.Tags')}}</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">{{__('messages.Tags')}}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <!--Start edit   Modal-->
                <div class="modal fade" style="z-index: 150000" id="admin_modal" tabindex="1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="admin_modal_body">

                            </div>
                        </div>
                    </div>
                </div>

                <!--End Edit Users Modal -->
                <div class="row">
                    <div class="col-12">
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
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <div class="search-box me-2 mb-2 d-inline-block">
                                            <div class="position-relative">
                                                <input type="text" class="form-control" placeholder="Search...">
                                                <i class="bx bx-search-alt search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="text-sm-end">
                                            <a href="{{route('admin.tags.create')}}" type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> {{__('messages.create_new_tag')}}</a>
                                        </div>
                                    </div><!-- end col-->
                                </div>

                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="align-middle">ID</th>
                                            <th class="align-middle">{{__('messages.tag')}}</th>
                                            <th class="align-middle">{{__('messages.Category')}}  </th>
                                            <th class="align-middle">{{__('messages.actions')}} </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if(!empty($datas))
                                            <?php foreach ($datas as $key => $data): ?>
                                            <tr>
                                                <td><a href="javascript: void(0);" class="text-body fw-bold">{{ $data->id }}</a></td>
                                                <td>{{$data->tag_name}}</td>
                                                @if(!empty($data->categories))
                                                    <td>{{$data->categories->category_name}}</td>
                                                @else
                                                    <td>
                                                        'No Category'
                                                    </td>
                                                @endif
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <a href="javascript:void(0);" class="text-success btn-edit-category" data-id="{{$data->id}}"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                        <a href="javascript:void(0);" class="text-danger btn-remove" data-id="{{$data->id}}"><i class="mdi mdi-delete font-size-18"></i></a>
                                                    </div>


                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <!-- Modal -->
        <div class="modal fade orderdetailsModal" tabindex="-1" role="dialog" aria-labelledby=orderdetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id=orderdetailsModalLabel">Order Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-2">Product id: <span class="text-primary">#SK2540</span></p>
                        <p class="mb-4">Billing Name: <span class="text-primary">Neal Matthews</span></p>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap">
                                <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">
                                        <div>
                                            <img src="assets/images/product/img-7.png" alt="" class="avatar-sm">
                                        </div>
                                    </th>
                                    <td>
                                        <div>
                                            <h5 class="text-truncate font-size-14">Wireless Headphone (Black)</h5>
                                            <p class="text-muted mb-0">$ 225 x 1</p>
                                        </div>
                                    </td>
                                    <td>$ 255</td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <div>
                                            <img src="assets/images/product/img-4.png" alt="" class="avatar-sm">
                                        </div>
                                    </th>
                                    <td>
                                        <div>
                                            <h5 class="text-truncate font-size-14">Hoodie (Blue)</h5>
                                            <p class="text-muted mb-0">$ 145 x 1</p>
                                        </div>
                                    </td>
                                    <td>$ 145</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h6 class="m-0 text-right">Sub Total:</h6>
                                    </td>
                                    <td>
                                        $ 400
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h6 class="m-0 text-right">Shipping:</h6>
                                    </td>
                                    <td>
                                        Free
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h6 class="m-0 text-right">Total:</h6>
                                    </td>
                                    <td>
                                        $ 400
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal -->

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


    <!-- Modal -->
    {{--<div class="modal fade" id="EditCategoryModal" tabindex="-1" role="dialog" aria-labelledby="EditCategoryModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
                <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"> Task Editieren </h5>

        </div>
        <div class="modal_body  edit_category_modal container">
         </div>




     </div>
    </div>--}}
@endsection
@section('script')
    <!-- Required datatable js -->
    <script src="{{asset('public/public/assets/crm/libs/datatables.net/js/jquery.dataTables.min.js ')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js ')}} "></script>
    <!-- Buttons examples -->
    <script src="{{asset('public/public/assets/crm/libs/datatables.net-buttons/js/dataTables.buttons.min.js ')}} "></script>
    <script src="{{asset('public/public/assets/crm/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js ')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/jszip/jszip.min.js ')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/pdfmake/build/pdfmake.min.js ')}} "></script>
    <script src="{{asset('public/public/assets/crm/libs/pdfmake/build/vfs_fonts.js ')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/datatables.net-buttons/js/buttons.html5.min.js ')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/datatables.net-buttons/js/buttons.print.min.js ')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/datatables.net-buttons/js/buttons.colVis.min.js ')}}"></script>

    <!-- Responsive examples -->
    <script src="{{asset('public/public/assets/crm/libs/datatables.net-responsive/js/dataTables.responsive.min.js ')}}"></script>
    <script src="{{asset('public/public/assets/crm/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js ')}}"></script>

    <!-- Datatable init js -->
    <script src="{{asset('public/public/assets/crm/js/pages/datatables.init.js ')}}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.update_tag_btn', function (event) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let formData = new FormData(document.getElementById('edit-tag-form'));

                $.ajax({
                    type: "post",
                    url: "{{route('tags.update')}}", // need to create this post route
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.success) {
                            $('#admin_modal').modal('hide');
                            swal(`${data.success}`, {
                                icon: "success"
                            })
                        }
                    },
                    error: function (jqXHR, status, err) {
                        $('#admin_modal').modal('hide');
                        swal(`${err.error}`, {
                            icon: "warning"
                        })

                    },

                });
            });

            $(document).on('click', '.btn-edit-category', function (event) {
                event.preventDefault();
                let id = $(this).data('id');
                $.ajax({

                    type: "post",
                    url: "{{route('tags.edit')}}", // need to create this post route
                    data: {id : id , _token : '{{ csrf_token() }}'},
                    cache: false,
                    success: function (data) {

                        $('#admin_modal').modal('show');
                        $("#admin_modal_body").html(data.html);
                    },
                    error: function (jqXHR, status, err) {


                    },

                });
            });

            // Delete Category

            $(document).on('click','.btn-remove' ,  function (e) {
                    var selector = $(this);
                    var id = $(this).data('id');
                    Swal.fire({
                        title: 'Möchtest Du dieses Tag wirklich löschen ? ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#013c60',
                        cancelButtonColor: '#ec6630',
                        confirmButtonText: 'Ja' ,
                        cancleButtonText: 'NEIN'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Check  If Tag  Has Posts
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('admin.tags.delete') }}',
                                data: {id: id, _token: '{{ csrf_token() }}'},
                                success: function (data) {
                                    if(data.status == true) {
                                        selector.closest('tr').hide('slow');
                                    }else {
                                        Swal.fire({
                                            icon: 'error',
                                            text: 'Dieser Tag kann nicht gelöscht werden da es eine oder mehrere Post-It beinhaltet !',
                                        })
                                    }
                                },
                                error: function (data) {
                                    toastr.error(data.msg);
                                }
                            });
                        }

                    })



            });

        });
    </script>
@stop
