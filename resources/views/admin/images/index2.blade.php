<table id="images" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>Photo</th>
            <th>Type</th>
            <th>Gender</th>

            <th>Action</th>
        </tr>
    </thead>
    <tbody>

@if(!empty($datas))

     <?php foreach ($datas as $key => $data): ?>


              <tr>
                <td><img src="{{asset('assets/images/' . $data->image ) }}" style="width:100px;height:100px;"></td>
                  <td>{{$data->type}}</td>
                  <td>  @if($data->gender == "1") Mann @elseif ($data->gender == "2")   Fabru  @else No Thing  @endif </td>

                  <td ><button class="btn btn-primary btn-move-image"  data-id=" {{ $data -> id }} " >   Move  </button>
                       <button class="btn btn-success btn-edit-image"  data-id=" {{ $data -> id }} " >   Edit  </button>
                         <a href="javascript:;" class="btn btn-danger" data-id="{{ $data->id }}" style="color:#fff;">delete</a> </td>
              </tr>

          <?php endforeach; ?>
  @endif
    </tbody>
    <tfoot>
        <tr>
            <th>Photo</th>
            <th>Type</th>
            <th>Gender</th>
            <th class="invisible"></th>
        </tr>
    </tfoot>
</table>


<script>


     $('#images').DataTable( {
         "oLanguage": {
             "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
             "sInfo": "Showing page _PAGE_ of _PAGES_",
             "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
             "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
         },
         "order": [[ 3, "desc" ]],
         "stripeClasses": [],
         "lengthMenu": [7, 10, 20, 50],
         "pageLength": 7,
         drawCallback: function () { $('.dataTables_paginate > .pagination').addClass(' pagination-style-13 pagination-bordered mb-5'); }
   } );

 </script>

  <script>
$(document).ready(function () {

       $(document).on('click','.btn-danger' ,  function (e) {
          if (!confirm("Are You Sure You Will Delete This Record")) {
              e.preventDefault();
              return false;
          }

           var selector = $(this);
          var id = $(this).data('id');



          $.ajax({
              type: 'POST',
              url: '{{ route('admin.images.delete') }}',
              data: {id: id, _token: '{{ csrf_token() }}'},
              success: function (data) {

                          selector.closest('tr').hide('slow');
                          toastr.success(data.msg);


              }
          });
      });

    });


     </script>


   <!-- END PAGE LEVEL SCRIPTS -->
