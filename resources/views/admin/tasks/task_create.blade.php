@php use App\Models\Tag; @endphp
<link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
<script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}"></script>
<link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>

<style>
    #select1,
    #select1_ajax {
        width: 250px;
    }

    #select2,
    #select2_ajax,
    #select3,
    #select3_ajax,
    #select5,
    #select5_ajax,
    #select6 {
        width: 100%;
        height: 36px;
    }

    #selectator_select6 {
        width: 100% !important;
        margin-bottom: 5px;
    }

    #select4,
    #select4_ajax {
        width: 350px;
        height: 50px;
    }

    .option_one,
    .option_two,
    .option_three,
    .option_four,
    .option_five,
    .option_six,
    .option_seven,
    .option_eight,
    .option_nine,
    .option_ten,
    .option_eleven,
    .option_twelve,
    .option_thirteen,
    .option_fourteen {
    }

    .group_one,
    .group_two,
    .group_three {
    }

    #selectator_select3,
    #selectator_select5 {
        width: 100% !important;
        margin-bottom: 5px;
    }
#task_category_id ,
#task_responsible
{
    font-size: 12px;
    color: #757c85;
    margin-bottom: 12px;
}
    .multiple .selectator_selected_items .selectator_selected_item .selectator_selected_item_left img {
        height: 18px;
        border-radius: 2px;
        width: 18px;
        border-radius: 50%;
    }

</style>


<div class="row layout-top-spacing">
    <div id="basic" class="col-lg-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">

            </div>
            <div class="widget-content widget-content-area">
                <form id="create-category" action="{{route('admin.tasks.store')}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{__('messages.Titel')}}</label>
                            </div>
                            <div class="col-md-6">
                                <input id="task_title" type="text" name="task_title" class="form-control" placeholder="{{__('messages.Titel')}}">
                                <span class="text-danger error-message" id="task_title_error"></span>
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
                                <label>{{__('messages.Beschreibung')}} </label>
                            </div>
                            <div class="col-md-7">
                                <textarea type="text" name="task_desc" class="form-control" placeholder="{{__('messages.Beschreibung')}}"></textarea>
                                <span class="text-danger error-message" id="task_desc_error"></span>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">

                                <label>{{__('messages.Fachbereich')}} 1 </label>
                            </div>
                            <div class="col-md-7">
                                <select class="form-control" id="task_category_id" name="task_category_id" data-size="5">
                                    <option disabled selected> {{__('messages.Fachbereich_wählen')}} 1</option>
                                    @foreach ($categories as $key => $category)
                                        <option value="{{$category->id}}"
                                                @if(!empty(session()->get('catt_id'))) @if(session()->get('catt_id') == $category->id) selected @endif  @endif> {{$category->category_name }} </option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-message" id="task_category_id_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{__('messages.Fachbereich')}} 2 </label>
                            </div>
                            <div class="col-md-7">
                                <select class="selectpicker form-control" id="task_category_id_two"
                                        name="task_category_id_two" data-size="5">
                                    <option value="">{{__('messages.Fachbereich_wählen')}} 2</option>
                                    @foreach ($categories as $key => $category)
                                        <option value="{{$category->id}}"> {{$category->category_name }} </option>
                                    @endforeach

                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-3">
                                <label class="control-label">{{__('messages.Unter_Kategorie')}} </lable>
                            </div>
                            <div class="col-md-7">
                                @if(!empty($tags))
                                    <select id="categoryselect" name="tags_id[]" class="target " multiple data-name="tags_id[]" style="width: 100% !important;">
                                        @if(!empty($tags))
                                            @foreach ($tags as $key => $tag)
                                                @php $tagg = Tag::where('tag_name' , $tag->tag_name)->first();  @endphp
                                                <option id="{{$key}}" value="{{$tagg->id}}"
                                                        @if(!empty(session()->get('tagg_id'))) @if(session()->get('tagg_id') == $tagg->id) selected @endif  @endif>    {{$tag->tag_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                @else
                                    <alert class="alert-danger">Keine Tags</alert>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label> {{__('messages.responsible')}} </label>
                            </div>
                            <div class="col-md-7">
                                <select class="form-control" id="task_responsible" name="task_responsible"
                                        data-size="5">
                                    <option selected disabled>{{__('messages.responsible')}}</option>
                                    @foreach ($users as $key => $user)
                                        <option value="{{$user->id}}"> {{$user->user_name }} </option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-message" id="task_responsible_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">  {{__('messages.team_members')}} </lable>
                            </div>
                            <div class="col-md-7">
                                <select id="select3" name="teams_id[]" class="target" multiple data-name="teams_id">
                                    @if(!empty($users))
                                        @foreach ($users as $key => $user)
                                            <option id="{{$key}}" value="{{$user->id}}" name="teams_id[]"
                                                    class="option_one"
                                                    data-left="{{asset('public/assets/images/users/'.$user->image)}}">    {{$user->user_name}}</option>
                                        @endforeach
                                    @endif
                                </select>

                                <input value="activate" id="activate_selectator4" type="button">
                                <script type="text/javascript">
                                    $(function () {
                                        var $activate_selectator = $('#activate_selectator4');
                                        $activate_selectator.click(function () {
                                            var $select = $('#select3');
                                            if ($select.data('selectator') === undefined) {
                                                $select.selectator({
                                                    showAllOptionsOnFocus: true,
                                                    useDimmer: true,
                                                    searchFields: 'value text subtitle right'
                                                });
                                                $activate_selectator.val('destroy');
                                            } else {
                                                $select.selectator('destroy');
                                                $activate_selectator.val('activate');
                                            }
                                        });
                                        $activate_selectator.trigger('click');
                                    });
                                </script>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label">{{__('messages.Besucher')}} </lable>
                            </div>
                            <div class="col-md-7">
                                <select id="select5" name="guests_id[]" class="target" multiple data-name="guests_id[]">

                                    @if(!empty($users2))
                                        @foreach ($users2 as $key => $user2)
                                            <option id="{{$key}}" value="{{$user2->id}}"
                                                    data-left="{{asset('public/assets/images/users/'.$user2->image)}}">    {{$user2->user_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input value="activate5" id="activate_selectator5" type="hidden">
                                <script type="text/javascript">
                                    $(function () {
                                        var $activate_selectator5 = $('#activate_selectator5');

                                        $activate_selectator5.click(function () {
                                            var $select5 = $('#select5');
                                            if ($select5.data('selectator') === undefined) {
                                                $select5.selectator({
                                                    showAllOptionsOnFocus: true,
                                                    useDimmer: true,
                                                    searchFields: 'value text subtitle right'
                                                });
                                                $activate_selectator5.val('destroy');
                                            } else {
                                                $select5.selectator('destroy');
                                                $activate_selectator5.val('activate5');
                                            }
                                        });
                                        $activate_selectator5.trigger('click');
                                    });
                                </script>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label> {{__('messages.Falligkeitsdatum')}}  </label>
                            </div>
                            <div class="col-md-7">
                                <div class="datepicker" data-type="date_filter" data-gender="list">
                                    <input  type="text"  class="start_due_date dateTimeFlatpickr form-control flatpickr flatpickr-input target" data-name="task_due_date"  name="task_due_date"  placeholder="{{__('messages.Falligkeitsdatum')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-primary save_task custom-btn btn_1 pull-right"
                                        style="float: right"> {{__('messages.Speichern')}}</button>
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
<script type="text/javascript">
    $(document).ready(function () {
        // Validation regex
        const htmlTagRegex = /<[^>]*>/g;

        // Real-time validation for Task Title and Description
        $('#task_title').on('keyup', function () {
            handleTaskTitle();  // Trigger validation as the user types
        });
        $('textarea[name="task_desc"]').on('keyup', handleTaskDescription);

        // Validation reset for select boxes
        $('#task_category_id, #task_responsible').on('change', function () {
            const selector = $(this);
            const errorSelector = '#' + selector.attr('id') + '_error';
            if (selector.val() && selector.val().trim() !== '') {
                clearError(selector, errorSelector);
            }
        });

        // Trigger validation on 'focusout' or 'blur' (when user presses Tab or clicks away)
        $('#task_category_id, #task_responsible').on('focusout blur', function () {
            validateSelectBox('#task_category_id', '#task_category_id_error', '{{ __("messages.Please select a category.") }}');
            validateSelectBox('#task_responsible', '#task_responsible_error', '{{ __("messages.Please select a responsible person.") }}');
        });

        // Final validation on form submission
        $('#create-category').on('submit', function (e) {
            let isValid = true;

            // Clear previous error messages
            $('.error-message').text('');

            // Validate Task Title
            if (!handleTaskTitle()) {
                isValid = false;
            }

            // Validate Description
            if (!handleTaskDescription()) {
                isValid = false;
            }

            // Validate Select Boxes
            if (!validateSelectBox('#task_category_id', '#task_category_id_error', '{{ __("messages.Please select a category.") }}')) {
                isValid = false;
            }

            if (!validateSelectBox('#task_responsible', '#task_responsible_error', '{{ __("messages.Please select a responsible person.") }}')) {
                isValid = false;
            }

            // Prevent form submission if any validation fails
            if (!isValid) {
                e.preventDefault();
            }
        });

        // Handle Task Title validation
        function handleTaskTitle() {
            const taskTitle = $('#task_title').val().trim();
            if (taskTitle === '') {
                setError('#task_title', '#task_title_error', '{{ __("messages.Task Title is required.") }}');
                return false;
            } else if (taskTitle.length > 60) {
                setError('#task_title', '#task_title_error', '{{ __("messages.Task Title must not exceed 60 characters.") }}');
                return false;
            } else if (htmlTagRegex.test(taskTitle)) {
                setError('#task_title', '#task_title_error', '{{ __("messages.Task Title must not contain HTML tags.") }}');
                return false;
            } else {
                clearError('#task_title', '#task_title_error');
                return true;
            }
        }

        // Handle Task Description validation
        function handleTaskDescription() {
            const taskDesc = $('textarea[name="task_desc"]').val().trim();
            if (taskDesc === '') {
                setError('textarea[name="task_desc"]', '#task_desc_error', '{{ __("messages.Description is required.") }}');
                return false;
            } else if (taskDesc.length > 500) {
                setError('textarea[name="task_desc"]', '#task_desc_error', '{{ __("messages.Description must not exceed 500 characters.") }}');
                return false;
            } else if (htmlTagRegex.test(taskDesc)) {
                setError('textarea[name="task_desc"]', '#task_desc_error', '{{ __("messages.Description must not contain HTML tags.") }}');
                return false;
            } else {
                clearError('textarea[name="task_desc"]', '#task_desc_error');
                return true;
            }
        }

        // Validate Select Boxes
        function validateSelectBox(selector, errorSelector, message) {
            const value = $(selector).val();
            if (!value || value.trim() === '') {
                setError(selector, errorSelector, message);
                return false;
            } else {
                clearError(selector, errorSelector);
                return true;
            }
        }

        // Set error message and styles
        function setError(selector, errorSelector, message) {
            $(errorSelector).text(message);
            $(selector).removeClass('is-valid').addClass('is-invalid');
        }

        // Clear error message and styles
        function clearError(selector, errorSelector) {
            $(errorSelector).text('');
            $(selector).removeClass('is-invalid').addClass('is-valid');
        }
    });
</script>




<script type="text/javascript">


    $(function () {

        // Initialize date picker
        var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
            dateFormat: "d.m.Y",
            minDate: "today",
            defaultDate: new Date(),
        });


        var $activate_selectator = $('#activate_selectator4');
        $activate_selectator.click(function () {
            var $select = $('#select3');
            if ($select.data('selectator') === undefined) {
                $select.selectator({
                    showAllOptionsOnFocus: true,
                    useDimmer: true,
                    searchFields: 'value text subtitle right'
                });
                $activate_selectator.val('destroy');
            } else {
                $select.selectator('destroy');
                $activate_selectator.val('activate');
            }
        });
        $activate_selectator.trigger('click');
    });
</script>

<script>
    $(document).ready(function () {
        $('#categoryselect').selectize();
    });
</script>
