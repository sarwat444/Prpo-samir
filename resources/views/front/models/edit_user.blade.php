


<div class="form-group">

    <form id="edit-user-form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{encrypt($user->id)}}">

@csrf
        <div class="row text-center header-image">

            @if(!empty($user->image))
                <img  class=" img-fluid" src="{{asset('assets/images/users/'.$user->image)}}">
            @else
                <img src="https://pri-po.com/public/assets/images/default.png">
            @endif

        </div>
        <div class="text-center alert-success mb-17" style="display:none ; font-size:14px; padding:7px; width:50% ; margin: 0 auto ; margin-bottom: 17px;">{{__('messages.Data_Updated_Successfuly')}}</div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="validationCustom01">First Name </label>
                <input type="text" class="form-control" id="validationCustom01" placeholder="First Name "
                       value="{{$user->first_name}}" name="firstname" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationCustom02">Last  Name </label>
                <input type="text" class="form-control" id="validationCustom02" placeholder="Last  Name"
                       value="{{$user->last_name}}" name="lastname" required>
            </div>
        </div>



        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="validationCustomUsername">User Name</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="validationCustomUsername"
                           value="{{$user->user_name}}" placeholder="Username" name="username" aria-describedby="inputGroupPrepend"
                           required>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="validationCustom03">Sorting </label>
                <input type="number" class="form-control" id="validationCustom03" placeholder="Priority" name="priority"
                       value="{{$user->user_piriority  }}" required>
            </div>

        </div>


        <div class="row">

            <div class="col-md-6 mb-3">
                <label for="validationCustomEmail">Email</label>
                <div class="input-group">

                    <input type="text" name="email" class="form-control" id="validationCustomEmail"
                           value="{{$user->email}}" placeholder="Username" aria-describedby="inputGroupPrepend"
                           required>

                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="password" >Password</label>
                <div class="input-group">
                    <input type="password" name="password"  id="password" class="form-control">
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="role">Role</label>
                <select class="form-control" name="role" id="role"
                        required>
                    <option value="1" {{$user->role ==1?'selected':''}}>Admin</option>
                    <option value="2" {{$user->role ==2?'selected':''}}>User</option>
                    <option value="3" {{$user->role ==3?'selected':''}}>Guest</option>
                    <option value="4" {{$user->role ==4?'selected':''}}>Invited</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="">Image </label>
                <input type="file" name="image" class="form-control">
            </div>
        </div>
    </form>
    <button class="btn btn-primary update_user_btn btn_sm float-end btn-sm" type="submit">Save Changes </button>
</div>
