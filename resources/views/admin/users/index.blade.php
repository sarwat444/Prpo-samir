@extends('layouts.admin')
@section('css')
<link href="{{asset('public/public/assets/crm/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('public/public/assets/crm/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('public/public/assets/crm/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
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
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="admin_modal_body">

                </div>
            </div>
        </div>
    </div>

    <!--End Edit Users Modal -->
    <!--Start -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table  id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="align-middle">ID</th>
                                            <th class="align-middle">{{__('messages.user')}}</th>
                                            <th class="align-middle">Email </th>
                                            <th>{{__('messages.status')}}</th>
                                            <th class="align-middle">{{__('messages.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                                @if(!empty($datas))
                                                            @foreach($datas as $key => $data)
                                                                    <tr>
                                                                        <td><a href="javascript: void(0);" class="text-body fw-bold">{{$data->id}}</a> </td>
                                                                        <td>
                                                                            @if(!empty($data->image))
                                                                                <img src="{{asset('assets/images/users/'.$data->image)}}">
                                                                                <p>{{$data->user_name}}</p>
                                                                            @else
                                                                                <img src="https://pri-po.com/public/assets/images/default.png">
                                                                                <p>{{$data->user_name}}</p>
                                                                            @endif
                                                                        </td>
                                                                            <td>{{$data->email}}</td>
                                                                             <td>
                                                                                 <input class="btn-toggle" data-id="{{$data->id}}" type="checkbox" value="{{$data->status}}" name="status" id="status{{$data->id}}" switch="none" @if($data->status == 0 ) checked @endif/>
                                                                                 <label for="status{{$data->id}}" data-on-label="{{__('messages.yes')}}" data-off-label="{{__('messages.no')}}"></label>
                                                                             </td>
                                                                            <td>
                                                                                <div class="d-flex gap-3">
                                                                                    <a href="javascript:void(0);" data-id=" {{ $data -> id }}"  class="text-success edit-user"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                                                    <a href="javascript:void(0);" data-id=" {{ $data -> id }}" class="text-danger delete-user"><i class="mdi mdi-delete font-size-18"></i></a>
                                                                                </div>
                                                                            </td>
                                                                    </tr>
                                                            @endforeach
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
    <!--End -->
            @endsection

            @section('script')
                <!-- Sweet Alerts js -->
                <script src="{{asset('public/public/assets/crm/libs/sweetalert2/sweetalert2.min.js')}}"></script>

                <!-- Sweet alert init js-->
                <script src="{{asset('public/public/assets/crm/js/pages/sweet-alerts.init.js')}}"></script>
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
                        $(document).on('click', '.edit-user', function (event) {
                            event.preventDefault();
                            var id = $(this).data('id');
                            $.ajax({
                                type: "post",
                                url: "{{route('users.edit')}}", // need to create this post route
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
                    });
                    // invite user
                </script>

                <!--Change User Activation  -->
                <script>
                    $(document).ready(function() {
                        $(document).on('click', '.btn-toggle', function() {
                            var user_status = $(this).val();
                            var user_id = $(this).data('id') ;
                            $.ajax({
                                type: "post",
                                url: "{{route('admin.change_user_status')}}",
                                cache: false,
                                data: {
                                    user_id : user_id ,
                                    user_status: user_status,
                                    _token: "{{csrf_token()}}"
                                },
                                success: function (data) {
                                },
                                error: function (jqXHR, status, err) {
                                }
                            });
                        });
                    });
                </script>
                <script>

                    // Delete Category
                    $(document).ready(function () {
                        $(document).on('click', '.update_user_btn', function (event) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            let formData = new FormData(document.getElementById('edit-user-form'));

                            $.ajax({
                                type: "post",
                                url: "{{route('users.update')}}", // need to create this post route
                                data: formData,
                                cache: false,
                                processData: false,
                                contentType: false,
                                success: function (data) {
                                    if (data.success) {
                                       $('.alert-success').css('display' , 'block') ;
                                       setTimeout(()=>{

                                           $('#admin_modal').modal('hide');
                                           swal(`${data.success}`, {
                                               icon: "success"
                                           });

                                       } , 500)

                                    }
                                },
                                error: function (jqXHR, status, err) {
                                },

                            });
                        });



                        $(document).on('click', '.delete-user', function (e) {
                            const selector = $(this).parent('tr');
                            const  id = $(this).data('id');
                            Swal.fire({
                                title: 'Are You Sure U Want To Delete ?',
                                type: 'warning',
                                confirmButtonText: 'Yes ',
                                cancelButtonText: 'No',
                                showCancelButton: true,
                                showCloseButton: true
                            }).then((result) => {
                                if (result.value) {
                                    $.ajax({
                                        type: 'POST',
                                        url: '{{ route('admin.users.delete') }}',
                                        data: {id: id, _token: '{{ csrf_token() }}'},
                                        success: function (data) {
                                            if (data.success) {
                                                swal({
                                                    title: 'der Erfolg',
                                                    text: `${data.success}`,
                                                    icon: 'success'
                                                })
                                               selector.remove();
                                            }
                                            if (data.error) {
                                                swal({
                                                    title: 'der Fehler',
                                                    text: `${data.error}`,
                                                    icon: 'error'
                                                })
                                            }
                                        },
                                        error: function (data) {
                                            toastr.error(data.error);
                                        }
                                    });
                                } else if (result.dismiss == 'cancel') {

                                }


                            });


                        });
                    });
    </script>
@stop
