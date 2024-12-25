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
                <form class="text-left" id="add_user" action="{{route('admin.invite.store')}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf


                    <div id="username-field" class="field-wrapper input form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Email</label>
                            </div>
                            <div class="col-md-6">
                                <input id="email" name="email" type="email" class="form-control" placeholder="Email">
                                <span class="text-danger error-message" id="email_name_error"></span>
                            </div>
                            <div class="col-md-1">
                                <button id="dismiss" class="dismiss" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary custom-btn btn_1 "
                                    style="float: right"> {{__('messages.Speichern')}} </button>
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
        $('#add_user').on('submit' , function (e) {
            let isValid = true;

            // Clear previous error messages
            $('.error-message').text('');

            // Validate First Name
            const email = $('#email').val().trim();
            if (email === '') {
                isValid = false;
                $('#email_name_error').text('{{ __('messages.Email is required.') }}');
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                e.preventDefault();
            }
        });
    });

</script>
