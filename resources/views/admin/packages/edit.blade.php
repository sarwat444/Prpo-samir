<form id="edit-category" method="post" action="{{route('admin.packages.update',$package->id)}}"  enctype="multipart/form-data">
  @csrf

          <div class="row mb-3">
              <div class="col-md-6">
                  <label>{{__('messages.Package')}}</label>
                  <input type="text" name="package_name" class="form-control" value="{{$package->package_name}}">
              </div>
              <div class="col-md-6">
                  <label>{{__('messages.desc')}}</label>
                  <textarea name="package_desc" class="form-control">{{$package->package_desc}}</textarea>

              </div>
          </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label>{{__('messages.price')}}</label>
            <input type="text" name="package_price" class="form-control" value="{{$package->package_price}}">
        </div>
        <div class="col-md-6">
            <label>{{__('messages.user_limit')}}</label>
            <input type="number" name="user_limit" class="form-control" value="{{$package->user_limit}}">
        </div>
    </div>

      <div class="modal-footer">
          <button type="submit" class="btn btn-primary ">{{__('messages.save')}} </button>
      </div>
</form>
