 <form class="text-left" id="add_user" action="{{route('admin.users.update',$id)}}" method="POST" enctype="multipart/form-data">
                               @csrf
                          <div id="username-field" class="field-wrapper input form-group">
                            
                              <label>First Name</label>
                              <input id="first_name" name="first_name" type="text" class="form-control" placeholder="First Name" value="{{$user->first_name}}">
                          </div>

                          <div id="username-field" class="field-wrapper input form-group">
                              <label>Last Name</label>
                              <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Last Name" value="{{$user->last_name}}">
                          </div>

                          <div id="username-field" class="field-wrapper input form-group">
                                
                                <label>User Name</label>
                                <input id="user_name" name="user_name" type="text" class="form-control" placeholder="User Name" autocomplete="off" value="{{$user->user_name}}">
                          </div>
                        <div id="username-field" class="field-wrapper input form-group">
                               <label> Email</label>
                            <input id="emai" name="email" type="text" class="form-control" placeholder="Email"  value="{{$user->email}}"> 
                        </div>

                        <div id="password-field" class="field-wrapper input mb-2 form-group">
                              <label> Password</label>
                            <input id="password" name="password" type="password" class="form-control" placeholder="Password" autocomplete="off" >
                        </div>

                        <div id="password-field" class="field-wrapper input mb-2 form-group">
                             
                                <label> confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password" autocomplete="off">
                        </div>

                        <div id="password-field" class="field-wrapper input mb-2 form-group">
                          
                            <input id="image" name="image" type="file" class="form-control">
                        </div>

                  <div class="modal-footer">
          <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Abbrechen</button>
          <button type="submit" class="btn btn-primary">Editieren</button>
      </div>      
</form>