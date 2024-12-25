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

            <div class="widget-content widget-content-area">
                <form class="text-left" id="add_user" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div id="username-field" class="field-wrapper input form-group">
                            <div class="row">
                                <label class="col-md-2">{{ __('messages.Vorname') }}</label>
                                <div class="col-md-7">
                                    <input id="first_name" name="first_name" value="{{ auth()->user()->first_name }}" type="text" class="form-control" placeholder="{{ __('messages.Vorname') }}">
                                    <span class="text-danger" id="first_name_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="username-field" class="field-wrapper input form-group">
                            <div class="row">
                                <label class="col-md-2">{{ __('messages.Nachname') }}</label>
                                <div class="col-md-7">
                                    <input id="last_name" name="last_name" value="{{ auth()->user()->last_name }}" type="text" class="form-control" placeholder="{{ __('messages.Nachname') }}">
                                    <span class="text-danger" id="last_name_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="username-field" class="field-wrapper input form-group">
                            <div class="row">
                                <label class="col-md-2">{{ __('messages.Nutzername') }}</label>
                                <div class="col-md-7">
                                    <input id="user_name" name="user_name" value="{{ auth()->user()->user_name }}" type="text" class="form-control" placeholder="{{ __('messages.Nutzername') }}">
                                    <span class="text-danger" id="user_name_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="username-field" class="field-wrapper input form-group">
                            <div class="row">
                                <label class="col-md-2">{{ __('messages.Email') }}</label>
                                <div class="col-md-7">
                                    <input id="email"  name="email" value="{{ auth()->user()->email }}" type="email" class="form-control" placeholder="{{ __('messages.Email') }}">
                                    <span class="text-danger" id="email_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="username-field" class="field-wrapper input form-group">
                            <div class="row">
                                <label class="col-md-2">{{ __('messages.Foto_hochladen') }}</label>
                                <div class="col-md-7">
                                    <input id="image" name="image" type="file" class="form-control" accept="image/*">
                                    <span class="text-danger" id="image_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="username-field" class="field-wrapper input form-group">
                            <div class="row">
                                <label class="col-md-2">{{ __('messages.password') }}</label>
                                <div class="col-md-7">
                                    <input id="password" name="password" type="password" class="form-control" placeholder="{{ __('messages.password') }}">
                                    <span class="text-danger" id="password_error"></span>
                                </div>
                                <div class="col-md-1">
                                    <i style="font-size: 18px" id="togglePasswordIcon-password" class="fa fa-eye" onclick="togglePassword('password')"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="username-field" class="field-wrapper input form-group">
                            <div class="row">
                                <label class="col-md-2">{{ __('messages.confirm_password') }}</label>
                                <div class="col-md-7">
                                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="{{ __('messages.confirm_password') }}">
                                    <span class="text-danger" id="password_confirmation_error"></span>
                                </div>
                                <div class="col-md-1">
                                    <i style="font-size: 18px" id="togglePasswordIcon-password_confirmation" class="fa fa-eye" onclick="togglePassword('password_confirmation')"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary custom-btn btn_1">{{ __('messages.Speichern') }}</button>
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
        $('#add_user').on('submit', function (e) {
            let isValid = true;

            // Clear previous error messages
            $('.text-danger').text('');

            // Regex to validate names without special characters
            const nameRegex = /^[a-zA-Z\s]*$/;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Validate First Name
            const firstName = $('#first_name').val().trim();
            if (firstName === '') {
                isValid = false;
                $('#first_name_error').text('{{ __("messages.First name is required.") }}');
            } else if (!nameRegex.test(firstName)) {
                isValid = false;
                $('#first_name_error').text('{{ __("messages.First name must not contain special characters.") }}');
            }

            // Validate Last Name
            const lastName = $('#last_name').val().trim();
            if (lastName === '') {
                isValid = false;
                $('#last_name_error').text('{{ __("messages.Last name is required.") }}');
            } else if (!nameRegex.test(lastName)) {
                isValid = false;
                $('#last_name_error').text('{{ __("messages.Last name must not contain special characters.") }}');
            }

            // Validate Username
            const userName = $('#user_name').val().trim();
            if (userName === '') {
                isValid = false;
                $('#user_name_error').text('{{ __("messages.User name is required.") }}');
            }

            // Validate Email
            const email = $('#email').val().trim();
            if (email === '') {
                isValid = false;
                $('#email_error').text('{{ __('messages.Email is required.') }}');
            }

            // Validate Password
            const password = $('#password').val().trim();
            const passwordConfirmation = $('#password_confirmation').val().trim();
            if (password !== passwordConfirmation) {
                isValid = false;
                $('#password_confirmation_error').text('{{ __("messages.Passwords do not match.") }}');
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                e.preventDefault();
            }
        });
    });

    // Toggle Eye Password
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(`togglePasswordIcon-${fieldId}`);
        if (field.type === "password") {
            field.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            field.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }

</script>

