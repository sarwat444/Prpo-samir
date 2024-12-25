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
                <form id="create-category" action="{{route('admin.categories.store')}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{__('messages.Kategorie')}}</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="category_name" class="form-control" id="category_name"
                                       placeholder="{{__('messages.Kategorie')}}">
                                <span class="text-danger error-message" id="category_name_error"></span>
                            </div>
                            <div class="col-md-1">
                                <button id="dismiss" class="dismiss" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{__('messages.Farbe')}}</label>
                            </div>
                            <div class="col-md-7">
                                <input type="color" name="category_color" class="form-control category_color"
                                       placeholder="{{__('messages.Farbe')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-10">
                                    <button type="submit" class="btn btn-primary save_task custom-btn btn_1"
                                            style="float: right"> {{__('messages.save')}} </button>
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
    $(document).ready(function (){
            $(document).on('keypress', function (e) {
                if (e.which == 13) {

                    $('#create-category').submit();
                }
            });
            $('#create-category').on('submit', function (e) {

                let isValid = true;

                // Clear previous error messages
                $('.error-message').text('');

                // Validate First Name
                const category_name = $('#category_name').val().trim();
                if (category_name === '') {
                    isValid = false;
                    $('#category_name_error').text('{{ __('messages.Category Name is required.') }}');
                }
                // Prevent form submission if validation fails
                if (!isValid) {
                    e.preventDefault();
                }
            });
    })
</script>