  <form class="text-left" id="add_user" action="{{route('admin.account.store')}}" method="POST" enctype="multipart/form-data">
                               @csrf
                 <input type="hidden" name="package_id" value="{{$id}}">
                             <div class="row mb-3">
                                       <div class="col-md-6">
                                          <div id="username-field" class="field-wrapper input form-group">
                                              <label>{{__('messages.firstname')}}</label>
                                              <input id="first_name" name="first_name" type="text" class="form-control" placeholder="{{__('messages.firstname')}}">
                                          </div>
                                       </div>
                                      <div class="col-md-6">
                                          <div id="username-field" class="field-wrapper input form-group">
                                              <label>{{__('messages.lastname')}}</label>
                                              <input id="last_name" name="last_name" type="text" class="form-control" placeholder="{{__('messages.lastname')}}">
                                          </div>
                                      </div>
                             </div>


      <div class="row mb-3">
          <div class="col-md-6">
                          <div id="username-field" class="field-wrapper input form-group">
                                <label>{{__('messages.username')}}</label>
                                <input id="user_name" name="user_name" type="text" class="form-control" placeholder="{{__('messages.username')}} autocomplete="off">
                          </div>
          </div>
          <div class="col-md-6">
                        <div id="username-field" class="field-wrapper input form-group">
                               <label> Email</label>
                            <input id="emai" name="email" type="text" class="form-control" placeholder="Email">
                        </div>
          </div>

      </div>

      <div class="row mb-3">
          <div class="col-md-6">
                        <div id="password-field" class="field-wrapper input mb-2 form-group">
                              <label> {{__('messages.password')}}</label>
                            <input id="password" name="password" type="password" class="form-control" placeholder="{{__('messages.password')}}" autocomplete="off">
                        </div>
          </div>
          <div class="col-md-6">

                        <div id="password-field" class="field-wrapper input mb-2 form-group">
                                <label> {{__('messages.confirm_password')}}</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="{{__('messages.confirm_password')}}" autocomplete="off">
                        </div>
          </div>
      </div>
      <div class="row mb-3">
          <div class="col-md-12">
                        <div id="password-field" class="field-wrapper input mb-2 form-group">
                            <label> {{__('messages.image')}}</label>
                            <input id="image" name="image" type="file" class="form-control">
                        </div>
          </div>
      </div>

      <div class="modal-footer">
          <button type="submit" class="btn btn-primary">{{__('messages.save')}}</button>
      </div>
</form>


