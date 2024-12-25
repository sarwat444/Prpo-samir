<div class="form-group">
    <div class="text-center alert-success mb-17 edittagssuccess" style="display:none ; font-size:14px; padding:7px; width:50% ; margin: 0 auto ; margin-bottom: 17px;">{{__('messages.Data_Updated_Successfuly')}}</div>
    <form id="update-category-tags" method="POST">
        @csrf
        @foreach($tags as $tag)
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="validationCustom01">{{__('messages.tag')}}</label>
                    <input type="text" class="form-control" placeholder="{{__('messages.tag')}} "
                           value="{{$tag->tag_name}}" name="name[{{$tag->id}}]" required>
                    <input type="hidden" name="keys[]" value="{{$tag->id}}"  >
                </div>
                <div class="col-md-6 mb-4">
                    <label for="validationCustom02">{{__('messages.sorting')}}</label>
                    <input type="number" class="form-control" id="validationCustom02" placeholder="{{__('messages.sorting')}}"
                           value="{{$tag->priority}}" name="priority[{{$tag->id}}]" required>
                </div>

            </div>

        @endforeach

    </form>
    <button class="btn btn-primary update_category_tags_btn" type="submit">{{__('messages.save')}}</button>
</div>


