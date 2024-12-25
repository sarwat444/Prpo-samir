

<form id="edit-category" method="post" action="{{route('admin.categories.update',$category->id)}}"  enctype="multipart/form-data">
  @csrf
     <div class="form-group">
       <label>Task Name</label>
       <input type="text" name="category_name" class="form-control" value="{{$category->category_name}}">
     </div>
     <div class="form-group">
       <label>Task Farbe</label>
        <input type="color" name="category_color" value="{{$category->category_color}}" class="form-control">
     </div>

      <div class="modal-footer">
          <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Abbrechen</button>
          <button type="submit" class="btn btn-primary">Editieren</button>
      </div>
</form>
<!-- form advanced init -->
<script src="{{asset('public/public/assets/crm/js/pages/form-advanced.init.js')}}"></script>
<script src="{{asset('public/public/assets/crm/js/app.js')}}"></script>


