@extends('layouts.admin')
@section('title')
  Pripo Accounts
@endsection
@section('css')

<link href="{{asset('public/public/assets/crm/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('public/assets/admin/assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('public/assets/admin/assets/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="{{asset('public/public/assets/crm/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('public/public/assets/crm/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{asset('public/public/assets/crm/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<style>
 tbody td img
{
    width: 30px;
    height: 30px;
    border-radius: 50%;
    float: left;
    margin-right: 9px;
}
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
 .modal-content .modal-header
 {
     padding: 12px 26px;
     border: 1px solid #e0e6ed;
     border: 0;
     padding: 22px;
 }
</style>
@endsection

@section('content')
    <!--New Accounts Style -->
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <div class="text-sm-end">
                                            <a href="{{route('admin.accounts.create')}}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i>  {{__('messages.Add_New_Account')}}</a>
                                        </div>
                                    </div><!-- end col-->
                                </div>
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


                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="align-middle">ID</th>
                                            <th class="align-middle">{{__('messages.user')}}</th>
                                            <th class="align-middle">Email</th>
                                            <th class="align-middle"> {{__('messages.Package')}}</th>
                                            <th class="align-middle">{{__('messages.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($datas))
                                                @foreach ($datas as $key => $data)
                                                <tr>
                                                    <td><a href="javascript: void(0);" class="text-body fw-bold">{{ $data->id }}</a> </td>
                                                    <td>
                                                        <img src="{{asset('public/assets/images/users/'.$data->image)}}" >
                                                        <p>{{$data->user_name}}</p>
                                                    </td>
                                                    <td>{{$data->email}}</td>
                                                    <td> {{!empty($data->package->package_name) ?  $data->package->package_name:"No Package Selected" }} </td>
                                                    <td>
                                                        <div class="d-flex gap-3">
                                                            <a href="javascript:void(0);" class="text-success btn-edit-account" data-id="{{$data -> id}}" ><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger btn-remove" data-id="{{$data -> id}}"><i class="mdi mdi-delete font-size-18"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                 @else
                                                <tr> <td>No Account Found </td> </tr>
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
    <!-- end main content-->
    <!--End New ACCOUNTS style-->
<!-- Modal -->
<div class="modal fade" id="EditAccountModal" tabindex="-1" role="dialog" aria-labelledby="EditAccountModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">

     <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
    <div class="modal_body  edit_account_modal container">
     </div>




 </div>
</div>
</div>


<div class="modal fade" id="InvitePackageModal" tabindex="-1" role="dialog" aria-labelledby="InvitePackageModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
            <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Invite User </h5>

    </div>
    <div class="modal_body  invite_package_modal container">
     </div>




 </div>
</div>
</div>


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

    <!-- Sweet Alerts js -->
    <script src="{{asset('public/public/assets/crm/libs/sweetalert2/sweetalert2.min.js')}}"></script>

    <!-- Sweet alert init js-->
    <script src="{{asset('public/public/assets/crm/js/pages/sweet-alerts.init.js')}}"></script>


    <script>
$(document).ready(function () {
  $(document).on('click', '.btn-invite-package-user', function (event) {
    //  alert('hello');
    event.preventDefault();
                var id = $(this).data('id');

                  $.ajax({
                      type: "post",
                      url: "{{route('admin.packages.add_account')}}", // need to create this post route
                      data: {id : id , _token : '{{ csrf_token() }}'},
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
  $(document).on('click', '.btn-edit-account', function (event) {
    event.preventDefault();
                var id = $(this).data('id');
                  $.ajax({

                      type: "post",
                      url: "{{route('admin.accounts.edit')}}", // need to create this post route
                      data: {id : id , _token : '{{ csrf_token() }}'},
                      cache: false,
                      success: function (data) {


                           $('#EditAccountModal').modal('show');
                            $(".edit_account_modal").html(data);
                      },
                      error: function (jqXHR, status, err) {


                      },

                 });
  });
 });
    // Delete Category
$(document).ready(function () {
   $(document).on('click','.btn-remove' ,  function (e) {
            var selector = $(this);
            var id = $(this).data('id');
       Swal.fire({
           title: 'Are You Sure U Want To Delete ?',
           type: 'warning',
           confirmButtonText: 'Yes',
           cancelButtonText: 'No',
           showCancelButton: true,
           showCloseButton: true
       }).then((result) => {
           if (result.value) {
               $.ajax({
                   type: 'POST',
                   url: '{{ route('admin.accounts.delete') }}',
                   data: {id: id, _token: '{{ csrf_token() }}'},
                   success: function (data) {

                       if(data.status == true) {
                           selector.closest('tr').hide('slow');
                           $('.error').css('display','none');
                           $('.success').css('display','block');
                           $('.success').html(data.msg);
                       }else {
                           $('.error').css('display','block');
                           $('.success').css('display','none');
                           $('.error').html(data.msg);
                       }

                   },
                   error: function (data) {
                       toastr.error(data.msg);
                   }
               });
           } else if (result.dismiss == 'cancel') {

           }


       });

       });
     });
</script>
@stop
