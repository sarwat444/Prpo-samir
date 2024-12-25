<form method="post" action="{{route('admin.images.update',$image->id)}}"  enctype="multipart/form-data">
                         @csrf

      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Move Image </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg> ... </svg>
          </button>
      </div>
      <div class="modal_body">
                <div class="form-group">


                  <label> Gender </label>


                      <div class="n-chk">
                              <label class="new-control new-radio radio-success">
                                <input type="radio" class="new-control-input" name="gender[]" value="1" @if($image->gender == "1") checked @else   " "  @endif  >
                                <span class="new-control-indicator"></span>Mann
                              </label>
                        </div>

                        <div class="n-chk">
                                <label class="new-control new-radio radio-primary">
                                  <input type="radio" class="new-control-input" name="gender[]" value="2"  @if($image->gender == "2") checked @else   " "  @endif>
                                  <span class="new-control-indicator"></span>Fabru
                                </label>
                          </div>


                          <div class="n-chk">
                                  <label class="new-control new-radio radio-danger">
                                    <input type="radio" class="new-control-input" name="gender[]" value="3" @if($image->gender == "3") checked @else   " "  @endif>
                                    <span class="new-control-indicator"></span>No thing
                                  </label>
                            </div>




                </div>



                 <div class="form-group">

                 <label>Upload Images</label>
                  <input type="file" name="image" >
                 </div>

      </div>
      <div class="modal-footer">
          <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
          <button type="submit" class="btn btn-primary">Update</button>
      </div>

      </form>
