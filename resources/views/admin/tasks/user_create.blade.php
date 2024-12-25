
<div class="row layout-top-spacing">
    <div id="basic" class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">

            </div>
            <div class="widget-content widget-content-area">
                <form class="text-left" id="add_user" action="{{ route('admin.register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- First Name -->
                    <div class="field-wrapper input form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="first_name">{{ __('messages.Vorname') }}</label>
                            </div>
                            <div class="col-md-6">
                                <input id="first_name" name="first_name" type="text" class="form-control"
                                       placeholder="{{ __('messages.Vorname') }}">
                                <span class="text-danger error-message" id="first_name_error"></span>
                            </div>
                            <div class="col-md-1">
                                <button id="dismiss" class="dismiss" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="field-wrapper input form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="last_name">{{ __('messages.Nachname') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input id="last_name" name="last_name" type="text" class="form-control"
                                       placeholder="{{ __('messages.Nachname') }}">
                                <span class="text-danger error-message" id="last_name_error"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="field-wrapper input form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="user_name">{{ __('messages.Nutzername') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input id="user_name" name="user_name" type="text" class="form-control"
                                       placeholder="{{ __('messages.Nutzername') }}" autocomplete="off">
                                <span class="text-danger error-message" id="user_name_error"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="field-wrapper input form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="email">{{ __('messages.Email') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input id="email" name="email" type="email" class="form-control" placeholder="{{ __('messages.Email') }}">
                                <span class="text-danger error-message" id="email_error"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="field-wrapper input form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="password">{{ __('messages.Passwort') }}</label>
                            </div>
                            <div class="col-md-7 position-relative">
                                <input id="password" name="password" type="password" class="form-control"
                                       placeholder="{{ __('messages.Passwort') }}" autocomplete="off">
                                <span class="text-danger error-message" id="password_error"></span>
                                <!-- Eye Icon -->
                                <span class="toggle-password" onclick="togglePassword('password')">
                <i class="fa fa-eye" id="togglePasswordIcon-password"></i>
            </span>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="field-wrapper input form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="password_confirmation">{{ __('messages.confirm_Passwort') }}</label>
                            </div>
                            <div class="col-md-7 position-relative">
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                       class="form-control"
                                       placeholder="{{ __('messages.confirm_Passwort') }}" autocomplete="off">
                                <span class="text-danger error-message" id="password_confirmation_error"></span>
                                <!-- Eye Icon -->
                                <span class="toggle-password" onclick="togglePassword('password_confirmation')">
                <i class="fa fa-eye" id="togglePasswordIcon-password_confirmation"></i>
            </span>
                            </div>
                        </div>
                    </div>


                    <!-- Photo Upload -->
                    <div class="field-wrapper input form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="image">{{ __('messages.Foto_hochladen') }}</label>
                            </div>
                            <div class="col-md-7">
                                <input id="image" name="image" type="file" class="form-control" accept="image/*">
                                <span class="text-danger error-message" id="image_error"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary custom-btn btn_1" style="float: right;">
                                {{ __('messages.Speichern') }}
                            </button>
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
            if (e.which === 13) {
                e.preventDefault(); // Prevent default behavior
                $('#add_user').trigger('submit'); // Explicitly submit the form
            }
        });

        $(document).ready(function () {
            const nameRegex = /^[\p{L}\p{M}\s]+$/u;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Attach blur and input events for validation
            $('#first_name').on('blur input', handleFirstName);
            $('#last_name').on('blur input', handleLastName);
            $('#user_name').on('blur input', handleUserName);
            $('#email').on('blur input', handleEmail);
            $('#password, #password_confirmation').on('blur input', handlePassword);
            $('#image').on('blur input change', handleImage);

            $('#add_user').on('submit', function (e) {
                let isValid = true;

                if (!handleFirstName() || !handleLastName() || !handleUserName() ||
                    !handleEmail() || !handlePassword() || !handleImage()) {
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            function handleFirstName() {
                const firstName = $('#first_name').val().trim();
                if (firstName && nameRegex.test(firstName)) {
                    $('#first_name_error').text('');
                    $('#first_name').removeClass('is-invalid').addClass('is-valid');
                    return true;
                } else if (firstName) {
                    $('#first_name_error').text('{{ __("messages.First name must not contain special characters.") }}');
                    $('#first_name').removeClass('is-valid').addClass('is-invalid');
                    return false;
                } else {
                    $('#first_name_error').text('{{ __("messages.First name is required.") }}');
                    $('#first_name').removeClass('is-valid').addClass('is-invalid');
                    return false;
                }
            }

            function handleLastName() {
                const lastName = $('#last_name').val().trim();
                if (lastName && nameRegex.test(lastName)) {
                    $('#last_name_error').text('');
                    $('#last_name').removeClass('is-invalid').addClass('is-valid');
                    return true;
                } else if (lastName) {
                    $('#last_name_error').text('{{ __("messages.Last name must not contain special characters.") }}');
                    $('#last_name').removeClass('is-valid').addClass('is-invalid');
                    return false;
                } else {
                    $('#last_name_error').text('{{ __("messages.Last name is required.") }}');
                    $('#last_name').removeClass('is-valid').addClass('is-invalid');
                    return false;
                }
            }

            function handleUserName() {
                const userName = $('#user_name').val().trim();
                if (userName && nameRegex.test(userName)) {
                    $('#user_name_error').text('');
                    $('#user_name').removeClass('is-invalid').addClass('is-valid');
                    return true;
                } else if (userName) {
                    $('#user_name_error').text('{{ __("messages.User name must not contain special characters.") }}');
                    $('#user_name').removeClass('is-valid').addClass('is-invalid');
                    return false;
                } else {
                    $('#user_name_error').text('{{ __("messages.User name is required.") }}');
                    $('#user_name').removeClass('is-valid').addClass('is-invalid');
                    return false;
                }
            }

            function handleEmail() {
                const email = $('#email').val().trim();
                if (emailRegex.test(email)) {
                    $('#email_error').text('');
                    $('#email').removeClass('is-invalid').addClass('is-valid');
                    return true;
                } else {
                    $('#email_error').text('{{ __("messages.Enter a valid email address.") }}');
                    $('#email').removeClass('is-valid').addClass('is-invalid');
                    return false;
                }
            }

            function handlePassword() {
                const password = $('#password').val().trim();
                const confirmPassword = $('#password_confirmation').val().trim();
                if (password && confirmPassword && password === confirmPassword) {
                    $('#password_confirmation_error').text('');
                    $('#password_confirmation').removeClass('is-invalid').addClass('is-valid');
                    return true;
                } else {
                    $('#password_confirmation_error').text('{{ __("messages.Passwords do not match.") }}');
                    $('#password_confirmation').removeClass('is-valid').addClass('is-invalid');
                    return false;
                }
            }

            function handleImage() {
                const image = $('#image').val().trim();
                if (image) {
                    $('#image_error').text('');
                    $('#image').removeClass('is-invalid').addClass('is-valid');
                    return true;
                } else {
                    $('#image_error').text('{{ __("messages.Image upload is required.") }}');
                    $('#image').removeClass('is-valid').addClass('is-invalid');
                    return false;
                }
            }
        });
    });
</script>
