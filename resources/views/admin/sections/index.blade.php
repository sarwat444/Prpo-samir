@extends('layouts.admin')

@section('css')


<!--  BEGIN CUSTOM STYLE FILE  -->
<link href="{{asset('assets/admin/assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/assets/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('content')




 <!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">


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

                    <div class="table-responsive mb-4 mt-4 images_view">
                        <table id="images" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Section Name</th>
                                     <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                        @if(!empty($datas))

                             <?php foreach ($datas as $key => $data): ?>


                                      <tr>

                                          <td>{{$data->section_name}}</td>


                                    <td>
                                          <button class="btn btn-success btn-edit-section"  data-id=" {{ $data -> id }} " >   Edit  </button>
                                           <a href="javascript:;" class="btn btn-danger" data-id="{{ $data->id }}" style="color:#fff;">delete</a>   </td>

                                      </tr>

                                  <?php endforeach; ?>
                          @endif
                            </tbody>
                            <tfoot>
                                <tr>

                                    <th>Section name </th>

                                    <th class="invisible"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        </div>

<!--  END CONTENT AREA  -->






<!-- Modal -->
<div class="modal fade" id="EditSectionModal" tabindex="-1" role="dialog" aria-labelledby="EditMotiveModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content edit_section_modal">

     </div>
 </div>
</div>





@endsection


@section('script')





<script>
$(document).ready(function () {


                     $(document).on('click', '.btn-edit-section', function (event) {


                               //  alert('hello');
                                  event.preventDefault();
                                  var id = $(this).data('id');

                                    $.ajax({

                                        type: "post",
                                        url: "{{route('admin.sections.edit')}}", // need to create this post route
                                        data: {id : id , _token : '{{ csrf_token() }}'},
                                        cache: false,
                                        success: function (data) {


                                             $('#EditSectionModal').modal('show');
                                              $(".edit_section_modal").html(data);
                                        },
                                        error: function (jqXHR, status, err) {


                                        },

                                   });




                              });





                      // Delete Image


                     $(document).on('click','.btn-danger' ,  function (e) {
                             if (!confirm("Are You Sure You Will Delete This Record")) {
                                 e.preventDefault();
                                 return false;
                             }

                              var selector = $(this);
                             var id = $(this).data('id');



                             $.ajax({
                                 type: 'POST',
                                 url: '{{ route('admin.sections.delete') }}',
                                 data: {id: id, _token: '{{ csrf_token() }}'},
                                 success: function (data) {

                                             selector.closest('tr').hide('slow');
                                             toastr.success(data.msg);


                                 }
                             });
                         });
     });
</script>




@stop
