@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>
@endif
@include('admin.includes.alerts.success')
@include('admin.includes.alerts.errors')
<div class="row layout-top-spacing">
    <div id="basic" class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">

            </div>
            <div class="widget-content widget-content-area">
                <form class="text-left" id="add_user" action="{{route('admin.tag.store')}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div id="password-field" class="field-wrapper input mb-2 form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Tag </label>
                            </div>
                            <div class="col-md-6">
                                <input id="tag_name" name="tag_name" type="text" class="form-control" placeholder="Tag">
                                <span class="text-danger error-message" id="tag_name_error"></span>
                            </div>
                            <div class="col-md-1">
                                <button id="dismiss" class="dismiss" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="username-field" class="field-wrapper input form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{__('messages.Kategorie')}}</label>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    @foreach($categories as $cat)
                                        <div class="col-md-6">
                                            <input type="checkbox" name="cat_id[]" value="{{$cat->id}}"
                                                   @if(!empty(session()->get('catt_id'))) @if(session()->get('catt_id') == $cat->id) checked @endif  @endif>
                                            <label>{{$cat->category_name}}</label><br>
                                        </div>
                                    @endforeach
                                </div>
                                <span class="text-danger error-message" id="cat_id_error"></span>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-primary custom-btn btn_1"
                                        style="float: right"> {{__('messages.Speichern')}} </button>
                            </div>
                        </div>
                    </div>
                </form>


                <div class="code-section-container show-code">
                    <div class="code-section text-left">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(document).on('keypress', function (e) {
            // Check if Enter key is pressed (key code 13)
            if (e.which == 13) {
                $('#add_user').submit();
            }
        });

        $('#add_user').on('submit', function (e) {
            let isValid = true;

            // Clear previous error messages
            $('.error-message').text('');

            // Validate Tag Name
            const tag_name = $('#tag_name').val().trim();
            const tagNameRegex = /^[a-zA-Z0-9\s]+$/; // Allows only letters, numbers, and spaces

            if (tag_name === '') {
                isValid = false;
                $('#tag_name_error').text('{{ __('messages.Tag name is required.') }}');
            } else if (!tagNameRegex.test(tag_name)) {
                isValid = false;
                $('#tag_name_error').text('{{ __('messages.Tag name must only contain letters, numbers, and spaces.') }}');
            }

            // Validate Category (at least one checkbox should be checked)
            if ($('input[name="cat_id[]"]:checked').length === 0) {
                isValid = false;
                $('#cat_id_error').text('{{ __('messages.At least one category must be selected.') }}');
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>



