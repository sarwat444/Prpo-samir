@extends('layouts.admin')
@section('css')
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{asset('public/assets/admin/assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('public/assets/admin/assets/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('public/public/assets/crm/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/public/assets/crm/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{asset('public/public/assets/crm/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
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

   </style>
@endsection

@section('content')

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
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
                                <form id="submit-form">
                                <div class="table-responsive">
                                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                                <thead class="table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>{{__('messages.user')}}</th>
                                                    <th>{{__('messages.sort_users')}}</th>
                                                    <th>{{__('messages.actions')}} </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                        @foreach($users as $key=> $user)
                                                            <tr>
                                                                <td> {{$user->id}} </td>
                                                                <td>
                                                                    @if(!empty($user->image))
                                                                        <img src="{{asset('assets/images/users/'.$user->image)}}">
                                                                        <p>{{$user->user_name}}</p>
                                                                    @else
                                                                        <img src="https://pri-po.com/public/assets/images/default.png">
                                                                        <p>{{$user->user_name}}</p>
                                                                    @endif
                                                                </td>
                                                                <td> <input min="0" class="form-control col-md-4" type="number" name="{{$user->id}}" id="{{$key}}" value="{{$user->user_piriority}}" style="width: 100px"></td>
                                                            <td>  <button class="btn btn-primary btn-sm" id="submit_button"> {{__('messages.Save_sort')}} </button></td>
                                                            </tr>
                                                        @endforeach
                                            </table>

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
                <script>

                    $(document).ready(function () {
                        $(document).on('click', '#submit_button', function (event) {
                            const data = $('#submit-form').serializeArray();
                            $.ajax({

                                type: "post",
                                url: "{{route('update.users.priority')}}", // need to create this post route
                                data: {data, _token: '{{ csrf_token() }}'},
                                cache: false,
                                success: function (data) {
                                  if(data.success){
                                      location.reload()

                                      let timerInterval
                                      Swal.fire({
                                          title: `${data.success}`,
                                          timer: 1200,
                                          timerProgressBar: true,
                                          willClose: () => {
                                              clearInterval(timerInterval)
                                          }
                                      }).then((result) => {
                                          if (result.dismiss === Swal.DismissReason.timer) {

                                          }
                                      })
                                  }
                                },
                                error: function (jqXHR, status, err) {


                                },

                            });
                        });
                        $(document).on('click', '.btn-edit-user', function (event) {
                            //  alert('hello');
                            event.preventDefault();
                            var id = $(this).data('id');

                            $.ajax({

                                type: "post",
                                url: "{{route('admin.users.edit')}}", // need to create this post route
                                data: {id: id, _token: '{{ csrf_token() }}'},
                                cache: false,
                                success: function (data) {


                                    $('#EditUserModal').modal('show');
                                    $(".edit_user_modal").html(data);
                                },
                                error: function (jqXHR, status, err) {


                                },

                            });
                        });

                    });
                    // invite user
                </script>
                <script>

                    // Delete Category
                    $(document).ready(function () {
                        $(document).on('click', '.btn-danger', function (e) {
                            if (!confirm("Are You Sure You Will Delete This Record")) {
                                e.preventDefault();
                                return false;
                            }
                            var selector = $(this);
                            var id = $(this).data('id');
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('admin.users.delete') }}',
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
                                },
                                error: function (data) {
                                    toastr.error(data.msg);
                                }
                            });
                        });
                    });
                </script>
@stop
