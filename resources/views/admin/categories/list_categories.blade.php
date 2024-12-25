@extends('layouts.admin')

@section('css')
    <link href="{{asset('public/public/assets/crm/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link href="{{asset('public/public/assets/crm/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/public/assets/crm/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{asset('public/public/assets/crm/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/public/assets/crm/libs/spectrum-colorpicker2/spectrum.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        tbody td img
        {
            height: 30px;
            width: 30px;
            border-radius: 50%;
            float: left;
            margin-right: 18px;
        }

        .header-image img
        {
            border-radius: 65%;
            height: 115px;
            width: 132px;
            margin: 0 auto;
            margin-bottom: 32px;
        }
        .modal-header
        {
            border-bottom: 0 ;
        }
   
    </style>
@endsection
@section('content')
    <!--Start edit   Modal-->
    <div class="modal fade" style="z-index: 150000" id="admin_modal" tabindex="1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    {{__('messages.Edit_Category_Tags')}}
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="admin_modal_body">

                </div>
            </div>
        </div>
    </div>

    <!--End Edit Users Modal -->


    <!--Categories List  -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{__('messages.Categories')}}</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">{{__('messages.Categories')}}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">

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

                        <div class="alert alert-danger error" style="display:none;">

                        </div>
                        <div class="alert alert-success success" style="display:none;">

                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <div class="text-sm-end">
                                            <a href="{{route('admin.categories.create')}}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> {{__('messages.Add_New_Category')}}</a>
                                        </div>
                                    </div>
                                    <!-- end col-->
                                </div>

                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="align-middle">ID</th>
                                            <th class="align-middle">{{__('messages.Category')}}</th>
                                            <th class="align-middle">{{__('messages.Color')}}  </th>
                                            <th class="align-middle">{{__('messages.sorting')}} </th>
                                            <th class="align-middle">{{__('messages.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($categories as $category)
                                            <tr>
                                                <td> <a href="javascript: void(0);" class="text-body fw-bold">{{$category->id}}</a> </td>
                                                <td> {{$category->category_name}} </td>
                                                <td>
                                                    <div style="background-color: {{$category->category_color}};
                                                        height: 45px;
                                                        border: 1px solid #eee;
                                                        padding: 9px;
                                                        width: 45px;
                                                        border-radius: 4px;"></div>
                                                </td>
                                                <td><input class="form-control" type="number" name="cat_priority[{{$category->id}}]" value="{{$category->priority}}"  style="width: 140px;"></td>
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <a href="javascript:void(0);" class="text-success btn-edit-category"   data-id="{{$category->id}}" ><i class="mdi mdi-pencil font-size-18"></i></a>
                                                        <a href="javascript:void(0);" class="text-danger btn-remove" data-id="{{$category->id}}" ><i class="mdi mdi-delete font-size-18"></i></a>
                                                        <a href="javascript:void(0);" class="text-primary btn-list-tags" data-id="{{$category->id}}" ><i class="mdi mdi-tag font-size-18"></i></a>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>



            <script>
                $(document).ready(function () {

                    $(document).on('click', '.btn-remove', function (e) {
                        e.preventDefault();
                        var id = $(this).data('id'); // Get the category ID

                        // Send AJAX request to check if the category has tasks
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.categories.showtaskcount') }}', // Route to check task existence
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}',
                            },
                            success: function (response) {
                                if (response.status) {
                                    // If the category has tasks, show a confirmation dialog
                                    Swal.fire({
                                        title: 'This category has ' + response.task_count + ' tasks!',
                                        text: 'Deleting this category will also delete all associated tasks. Do you want to proceed?',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, delete it!',
                                        cancelButtonText: 'No, cancel',
                                        reverseButtons: true,
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // If confirmed, delete the category with tasks
                                            $.ajax({
                                                type: 'POST',
                                                url: '{{ route('admin.categories.deletewithtasks') }}',
                                                data: {
                                                    id: id,
                                                    _token: '{{ csrf_token() }}',
                                                    delete_with_tasks: true,
                                                },
                                                success: function (response) {
                                                    Swal.fire('Deleted!', response.msg, 'success');
                                                    $('.btn-remove[data-id="' + id + '"]').closest('tr').hide('slow');
                                                },
                                                error: function () {
                                                    Swal.fire('Error!', 'Failed to delete the category.', 'error');
                                                },
                                            });
                                        }
                                    });
                                } else {
                                    // If the category has no tasks, show a simpler confirmation dialog
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: "This will delete the category permanently!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, delete it!',
                                        cancelButtonText: 'No, cancel',
                                        reverseButtons: true,
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // If confirmed, delete the category
                                            $.ajax({
                                                type: 'POST',
                                                url: '{{ route('admin.categories.deletenotasks') }}',
                                                data: {
                                                    id: id,
                                                    _token: '{{ csrf_token() }}',
                                                },
                                                success: function (response) {
                                                    Swal.fire('Deleted!', response.msg, 'success');
                                                    $('.btn-remove[data-id="' + id + '"]').closest('tr').hide('slow');
                                                },
                                                error: function () {
                                                    Swal.fire('Error!', 'Failed to delete the category.', 'error');
                                                },
                                            });
                                        }
                                    });
                                }
                            },
                            error: function () {
                                Swal.fire('Error!', 'Unable to fetch category details.', 'error');
                            },
                        });
                    });







                    /*End Remove Category */
                    /*Start edit Categories */
                    $(document).on('click', '.update-category', function (event) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        let formData = new FormData(document.getElementById('edit-category-form-data'));

                        $.ajax({
                            type: "post",
                            url: "{{route('category.update.modal')}}", // need to create this post route
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
                            url: "{{route('category.edit.modal')}}", // need to create this post route
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



                    /*End Edit Categories */
                    $(document).on('click', '.btn-list-tags', function (event) {
                        event.preventDefault();
                        let id = $(this).data('id');
                        $.ajax({

                            type: "post",
                            url: "{{route('categories.list.tags')}}", // need to create this post route
                            data: {id: id, _token: '{{ csrf_token() }}'},
                            cache: false,
                            success: function (data) {

                                $('#admin_modal').modal('show');
                                $("#admin_modal_body").html(data.html);
                            },
                            error: function (jqXHR, status, err) {


                            },

                        });
                    });
                    $(document).on('click', '.update_category_tags_btn', function (event) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        let formData = new FormData(document.getElementById('update-category-tags'));

                        $.ajax({
                            type: "post",
                            url: "{{route('tags.update.modal')}}", // need to create this post route
                            data: formData,
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                if (data.success) {
                                    $('.edittagssuccess').css('display' , 'block') ;
                                    setTimeout(()=>{
                                        $('#admin_modal').modal('hide');
                                        swal(`${data.success}`, {
                                            icon: "success"
                                        })
                                    },1000)

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
                });

            </script>
@endsection
