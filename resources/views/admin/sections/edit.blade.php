<form method="post" action="{{route('admin.sections.update',$section->id)}}"  enctype="multipart/form-data">
                         @csrf

      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Edit Section </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg> ... </svg>
          </button>
      </div>
      <div class="modal_body">

           <div class="form-group">

                <label>Section Name</label>
                <input type="text" name="section_name" class="form-control" value="{{$section->section_name}}">

            </div>


      </div>
      <div class="modal-footer">
          <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
          <button type="submit" class="btn btn-primary">Update</button>
      </div>

      </form>
