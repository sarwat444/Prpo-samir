

         <form class="text-left" id="add_user" action="{{route('admin.accounts.update',$id)}}" method="POST" enctype="multipart/form-data">
                               @csrf
             <div class="row mb-3">
                 <div class="col-md-6">
                          <div id="username-field" class="field-wrapper input form-group">

                              <label>{{__('messages.firstname')}}</label>
                              <input id="first_name" name="first_name" type="text" class="form-control" placeholder="{{__('messages.firstname')}}" value="{{$account->first_name}}">
                          </div>
                 </div>
                 <div class="col-md-6">
                          <div id="username-field" class="field-wrapper input form-group">
                              <label>{{__('messages.lastname')}}</label>
                              <input id="last_name" name="last_name" type="text" class="form-control" placeholder="{{__('messages.lastname')}}" value="{{$account->last_name}}">
                          </div>
                 </div>
             </div>

               <div class="row mb-3">
                   <div class="col-md-6">
                        <label> {{__('messages.username')}}  </label>
                        <input id="user_name" name="user_name" type="text" class="form-control" placeholder="{{__('messages.username')}} " autocomplete="off" value="{{$account->user_name}}">
                    </div>
                   <div class="col-md-6">
                        <div id="username-field" class="field-wrapper input form-group">
                               <label> Email</label>
                            <input id="emai" name="email" type="text" class="form-control" placeholder="Email" value="{{$account->email}}">
                        </div>
                   </div>
                </div>

             <div class="row mb-3">
                 <div class="col-md-6">
                     <div id="password-field" class="field-wrapper input mb-2 form-group">
                         <label> {{__('messages.password')}} </label>
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
                 <div class="col-md-6">
                     <label>  {{__('messages.Packages')}}  </label>
                     <select class="selectpicker form-control" id="package_id" name="package_id" data-size="5" required>

                         <option value="">{{__('messages.Packages')}}</option>

                         @foreach ($packages as $key => $package)


                             <option value="{{$package->id}}" @if( $account->package_id == $package->id ) selected @endif > {{$package->package_name }} </option>

                         @endforeach

                     </select>
                 </div>
                 <div class="col-md-6">
                     <label> {{__('messages.image')}} </label>
                     <input id="image" name="image" type="file" class="form-control">
                 </div>

          </div>

             <div class="row mb-3">
                 <div class="col-md-6">
                       <button type="submit" class="btn btn-primary">{{__('messages.save')}}</button>
                 </div>
             </div>

                </form>
