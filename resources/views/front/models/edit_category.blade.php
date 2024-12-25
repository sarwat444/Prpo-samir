<div class="form-group">
    <form id="edit-category-form-data" method="POST">
        <input type="hidden" name="id" value="{{encrypt($category->id)}}">
        @csrf
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="validationCustom01">{{__('messages.Category')}}</label>
                <input type="text" class="form-control" placeholder="{{__('messages.Category')}}"
                       value="{{$category->category_name}}" name="name" required>

            </div>
            <div class="col-md-4 mb-3">
                <label for="validationCustom02">{{__('messages.sorting')}}</label>
                <input type="text" class="form-control" id="validationCustom02" placeholder="{{__('messages.sorting')}} "
                       value="{{$category->priority}}" name="priority" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="validationCustom02">{{__('messages.Color')}}</label>
                <input type="text" class="form-control" name="category_color"  id="colorpicker-default" value="{{$category->category_color}}">
            </div>


        </div>


    </form>
    <button class="btn btn-primary update-category" >{{__('messages.save')}}</button>
</div>

<!-- form advanced init -->
<script src="{{asset('public/public/assets/crm/libs/spectrum-colorpicker2/spectrum.min.js')}}"></script>
<script src="{{asset('public/public/assets/crm/js/pages/form-advanced.init.js')}}"></script>
<script src="{{asset('public/public/assets/crm/js/app.js')}}"></script>

