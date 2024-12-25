<form method="post" action="{{route('admin.images.update_category',$image->id)}}"  enctype="multipart/form-data">
                         @csrf

      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Move Image </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg> ... </svg>
          </button>
      </div>
      <div class="modal_body">
                <div>
                                <select class="selectpicker form-control" name="type"  data-size="5" >

                                        <option value="mugs" @if($image->type == "mugs") selected @else   " "  @endif     >   Mugs  </option>
                                        <option value="hautfarbe" @if($image->type == "hautfarbe") selected @else   " "  @endif >  Hautfarbe  </option>
                                        <option value="kleidung_unter_teil"   @if($image->type == "kleidung_unter_teil") selected @else   " "  @endif >  Kleidung UnterTeil </option>
                                        <option value="kleidung_boer_teil"  @if($image->type == "kleidung_boer_teil") selected @else   " "  @endif > Kleidung OberTeil </option>
                                        <option value="hinterground"   @if($image->type == "hinterground") selected @else   " "  @endif > HinterGround </option>
                                        <option value="hairstyle"   @if($image->type == "hairstyle") selected @else   " "  @endif > HairStyle </option>

                                 </select>

              </div>
      </div>
      <div class="modal-footer">
          <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
          <button type="submit" class="btn btn-primary">Move</button>
      </div>

      </form>
