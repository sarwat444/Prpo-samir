@extends('layouts.admin')
@section('css')
    <link href="{{asset('public/public/assets/crm/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link href="{{asset('public/public/assets/crm/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/public/assets/crm/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{asset('public/public/assets/crm/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <style>
        .image-avatar
        {
            width :150px ;
        }
        .image-avatar img
        {
        height: 25px;
        width: 25px;
        float: left;
        margin-right: 14px;
        }
        .user_name
        {
            margin-top:7px ;
            width:160px ;
        }
    </style>
@endsection
@section('content')


    <!--Start Crm Content -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">{{__('messages.Categories')}}</p>
                                                <h4 class="mb-0">{{$category_count}}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-briefcase-alt-2 font-size-24"></i>
                                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">{{__('messages.Packages')}}</p>
                                                <h4 class="mb-0">{{$package_count}}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center ">
                                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                            <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-detail  font-size-24"></i>
                                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">{{__('messages.Users')}} </p>
                                                <h4 class="mb-0">{{$user_count}}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                            <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-user-circle font-size-24"></i>
                                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4"> {{__('messages.Running_tasks')}} </h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered dt-responsive nowrap w-100 dataTable no-footer dtr-inline">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="align-middle">ID</th>
                                            <th class="align-middle">{{__('messages.User_Name')}} </th>
                                            <th class="align-middle">{{__('messages.Category')}}</th>
                                            <th class="align-middle">{{__('messages.Subtask')}}</th>
                                            <th class="align-middle">{{__('messages.Added_by')}}</th>
                                            <th class="align-middle">{{__('messages.Task_time_tracking')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($subtasks as $key => $subtask)
                                            <tr class="bg-blue">
                                                <td><a href="javascript: void(0);" class="text-body fw-bold"> {{$subtask->id}} </a></td>
                                                <td class="pt-2">
                                                    <div class="image-avatar">
                                                        <img src="{{asset('public/assets/images/users/'.$subtask->responsible->image)}}" class="rounded-circle" alt="">
                                                    </div>
                                                    <div class="user_name">
                                                        @if(!empty($subtask->responsible->user_name))
                                                            {{$subtask->responsible->user_name}}
                                                            @else
                                                            'Not Selected '
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="pt-3 mt-1">{!!  $subtask->subtask_title!!}</td>
                                                <td class="pt-3">{{$subtask->task->task_title}}</td>
                                                <td class="pt-3">{{$subtask->added_by->user_name}}</td>
                                                <td>
                                                    <span class="badge badge-pill badge-soft-success font-size-11 Timer{{$subtask->id}} Timer"></span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td> {{__('messages.No_Data_Found')}}  </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">  {{__('messages.Today_tasks')}}  </h4>
                                <div class="table-responsive dt-responsive  nowrap w-100">
                                    <table id="datatable" class="table table-bordered ">
                                        <thead class="table-light">
                                        <tr>
                                            <th class="align-middle">ID</th>
                                            <th class="align-middle"> {{__('messages.Responsible')}}  </th>
                                            <th class="align-middle">{{__('messages.Category')}} </th>
                                            <th class="align-middle"> {{__('messages.Subtask')}} </th>
                                            <th class="align-middle"> {{__('messages.Added_by')}}   </th>
                                            <th class="align-middle"> {{__('messages.Task_time_tracking')}} </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($today_subtasks as  $subtask)
                                            <tr class="bg-blue">
                                                <td><a href="javascript: void(0);" class="text-body fw-bold">{{ $subtask->id }}</a> </td>
                                                <td class="pt-3">       @if(!empty($subtask->responsible->user_name)) {{$subtask->responsible->user_name}}  @else 'Not Selected' @endif</td>
                                                <td class="pt-3">{{$subtask->task->task_title}}</td>
                                                <td class="pt-3 mt-1">{!! strip_tags($subtask->subtask_title) !!}</td>
                                                <td class="pt-2">
                                                    <div class="image-avatar">
                                                        <img src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}" class="rounded-circle" alt="">
                                                        <p> {{$subtask->added_by->user_name}} </p>
                                                    </div>
                                                </td>
                                            @if(!empty($subtask->subtask_time))
                                                <td class="pt-3 "><span class="badge badge-pill badge-soft-success font-size-11"> {{$subtask->subtask_time}}  </span> </td>
                                                 @else
                                                <td class="pt-3"><span class="badge badge-pill badge-soft-danger font-size-11"> No Time </span> </td>
                                                @endif
                                            </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5"><p class="text-center">  {{__('messages.No_Data_Found')}} </p></td>
                                                    </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- container-fluid -->
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
    <!--End Crm  Content  -->


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


 @stop
