     
 <form class="text-left" id="add_user" action="{{route('admin.invite.store')}}" method="POST" enctype="multipart/form-data">
  @csrf    
  
    <input type="hidden" name="package_id" value="{{$id}}">
           <div class="form-group">
                                <label>Invite Email</label>
                                <input id="emai" name="email" type="email" class="form-control" placeholder="Email">
          </div>
             
                   
     
      <div class="modal-footer">
          <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Abbrechen</button>
          <button type="submit" class="btn btn-primary">Invite</button>
      </div>
</form>
     

                               


