<div class="form-group">

    <form id="edit-tag-form" method="post">
        <input type="hidden" name="id" value="{{encrypt($tag->id)}}">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="validationCustom01">{{__('messages.tag')}}</label>
                <input type="text" class="form-control" placeholder="{{__('messages.tag')}}"
                       value="{{$tag->tag_name}}" name="name" required>

            </div>
            <div class="col-md-6 mb-3">
                <label for="validationCustom02">{{__('messages.sorting')}}</label>
                <input type="number" class="form-control" id="validationCustom02" placeholder="{{__('messages.sorting')}}"
                       value="{{$tag->priority}}" name="priority" required>
            </div>
        </div>


    </form>
    <button class="btn btn-primary update_tag_btn" type="submit">{{__('messages.save')}}</button>
</div>

