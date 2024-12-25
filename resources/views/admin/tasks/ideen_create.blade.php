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
                <form id="create-category" action="{{route('admin.ides.store')}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{__('messages.Titel')}}</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="task_title" class="form-control" id="task_title"
                                       placeholder="{{__('messages.Titel')}}">
                                <input type="hidden" name="task_added_by" value="{{auth()->user()->id }}" >
                                <span class="text-danger error-message" id="category_name_error"></span>
                            </div>
                            <div class="col-md-1">
                                <button id="dismiss" class="dismiss" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <lable class="control-label">{{__('messages.dead_line')}}</lable>
                                </div>
                                <div class="col-md-7">
                                    <div class="datepicker">
                                        <input type="text" class="dateTimeFlatpickr form-control flatpickr flatpickr-input target" data-name="task_due_date" name="task_due_date" placeholder="DeadLine">
                                        <span class="text-danger error-message" id="task_due_date_error"></span>
                                     </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <lable class="control-label">{{__('messages.Beschreibung')}}</lable>
                                </div>
                                <div class="col-md-7">
                                    <textarea  name="task_desc" class="form-control" id="description" rows="6" placeholder="{{__('messages.Beschreibung')}}"></textarea>
                                    <span class="text-danger error-message" id="description_error"></span>
                                </div>
                            </div>

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
    $(document).ready(function () {
        // Initialize Flatpickr
        flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
            enableTime: true,
            dateFormat: "d.m.Y",
        });

        // Prevent form submission on Enter key press, except in textarea
        $(document).on('keypress', function (e) {
            if (e.which == 13 && !$(e.target).is('textarea')) {
                e.preventDefault();
                $('#create-category').submit();
            }
        });

        // Form submit validation
        $('#create-category').on('submit', function (e) {
            let isValid = true;

            // Clear previous error messages
            $('.error-message').text('');

            // Validate Category Name
            const category_name = $('#task_title').val().trim();
            if (category_name === '') {
                isValid = false;
                $('#task_title').text('{{ __("messages.Task title Name is required.") }}');
            }

            // Validate Deadline (optional but can be required based on your needs)
            const task_due_date = $('.dateTimeFlatpickr').val().trim();
            if (task_due_date === '') {
                isValid = false;
                $('#task_due_date_error').text('{{ __("messages.Category Name is required.") }}');
            }

            // Validate Description
            const description = $('#description').val().trim();
            if (description === '') {
                isValid = false;
                $('#description_error').text('{{ __("messages.Description is required.") }}');
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                e.preventDefault();
            }
        });

        // Dismiss button functionality
        $('#dismiss').on('click', function () {
            $('#category_name').val('');
            $('#description').val('');
            $('.error-message').text('');
        });
    });
</script>

