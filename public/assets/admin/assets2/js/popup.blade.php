<script>

    $(document).ready(function () {
        $(".txta").each(function () {
            this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
        }).on("input", function () {
            this.style.height = "auto";
            this.style.height = (this.scrollHeight) + "px";
        });


    });
</script>

<script>
    function auto_grow(element) {
        element.style.height = "5px";
        element.style.height = (element.scrollHeight) + "px";
    }
</script>
<script>
    function change_category(){
        alert('category_changed')
    }
</script>
<script>
    $('input[type="file"]').change(function () {
        var value = $("input[type='file']").val();
        $('.js-value').text(value);
    });
</script>
<script>
    $('.hiddenInput').datepicker({
        showOn: 'button',
        dateFormat: 'dd.mm.yy',
        firstDay: 1 ,
        buttonImage: 'https://pri-po.com/public/assets/images/calendar.png',
        buttonImageOnly: true,
        onSelect: function (selectedDate) {
            $(this).closest(".test").find('.calender label').text(selectedDate);

            var subtask_id = $(this).data("id");

            var date_val = selectedDate;
            $.ajax({
                type: "POST",
                url: '{{route('admin.subtasks.updatefielddd')}}', // need to create this post route
                data: {subtask_id: subtask_id, date_val: date_val, _token: '{{ csrf_token() }}'},
                cache: false,
                success: function (data) {
                    // console.log('done');

                },
                error: function (jqXHR, status, err) {
                },
            });


        },
        onClose: function (selectedDate) {
            $(this).next('.ui-datepicker-trigger').css("visibility", "hidden");
        }
    });

    $('.calender label').on('click', function () {
        console.log('test');
        $(this).next(".hiddenInput").datepicker("show");
    });


</script>

<link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
<script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}"></script>
<link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('public/assets/admin/assets2/css/theme-checkbox-radio.css')}}">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" ref="stylesheet">
<script src="{{asset('public/assets/admin/assets2/js/sweetalert.min.js')}}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />


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

    #select4,
    #select4_ajax {
        width: 350px;
        height: 50px;
    }

    .calender label {
        color: #777;
        font-size: 12px;
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

    /*start  Dropdown of  users */
    .todo .description {
        word-wrap: break-word;

    }

    #shuffle2 .desc {
        font-size: 12px;
    }

    /*Start  sub task selectbox */
    .dd-select {
        background: transparent !important;
        border: 0;

    }

    .dd-container {
        width: 0 !important;
    }

    .dd-selected {
        width: 28px !important;
        border-radius: 50%;
        border: 2px dashed #ccc;
        padding: 0px !important;
        text-align: center;

    }

    .dd-click-off-close {
        width: 63px !important;
        display: block;
        max-height: 213px;
        text-align: center;
    }

    .dd-click-off-close li a img {
        height: 37px;
        width: 37px;
        margin: 0 auto;
        border-radius: 50%;
    }

    .dd-select img {
        height: 100%;
        width: 100%;
        border-radius: 50%;
        /* margin: 0 auto; */
        /* padding-left: 6px; */
        padding: 3px;
    }

    .dd-select a.dd-select {
        overflow: hidden;
        display: block;
        padding: 10px;
        font-weight: bold;
        padding: 0 !important;
        text-align: center;
        border-radius: 50%;
        padding: 14px;
    }

    .dd-pointer-down {
        display: none;

    }

    .ui-datepicker-trigger {
        height: 20px;
    }

    /*
    .todo .task:hover > .btn-remove {
      visibility: visible;
      position: relative;
    }
    */


    .filupp > input[type=file] {
        position: absolute;

        width: 1px;
        height: 1px;

        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
    }

    .filupp {
        position: relative;
        background: #013c60;
        /* display: block; */
        padding: 5px;
        font-size: 13px;
        /* width: 43%; */
        /* float: left; */
        /* height: 35px; */
        color: #fff;
        /* cursor: pointer; */
        /* margin-right: 7px; */
        width: 49%;
        text-align: center;
        border-radius: 4px !important;

    }

    .submit_comment {
        border: 0;
        background-color: #ccc !important;
        font-size: 13px;
        border-radius: 0 !important;
        width: 49%;
        padding: 6px !important;
        border-radius: 4px !important;
    }

    .comments .comment img {
        height: 20px;
        width: 20px;
        border-radius: 50%;
    }

    .task .test {
        height: 20px;
    }

    .txta {
        width: 100%;
        max-width: 500px;
        min-height: 100px;
        font-size: 12px;
        overflow: hidden;
        line-height: 1.4;
        border: 1px solid #ced4da29;
        padding: 9px;
        margin-top: 5px !important;
    }

    .remove-task,
    .complete_task {
        font-size: 11px;
    }

    .sub_tasks3 h3 {
        color: #013c60;
        font-size: 13px;
        /* border: 1px solid #777; */
        padding: 11px;
        /* background-color: #fff; */
        max-width: 550px;
        border-radius: 3px;
    }

    .toggle-btn {
        width: 75px;
        height: 35px;
        margin: 10px;
        border-radius: 50px;
        display: inline-block;
        position: relative;
        background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAyklEQVQ4T42TaxHCQAyENw5wAhLACVUAUkABOCkSwEkdhNmbpHNckzv689L98toIAKjqGcAFwElEFr5ln6ruAMwA7iLyFBM/TPDuQSrxwf6fCKBoX2UMIYGYkg8BLOnVg2RiAEexGaQQq4w9e9klcxGLLAUwgDAcihlYAR1IvZA1sz/+AAaQjXhTQQVoe2Yo3E7UQiT2ijeQdojRtClOfVKvMVyVpU594kZK9zzySWTlcNqZY9tjCsUds00+A57z1e35xzlzJjee8xf0HYp+cOZQUQAAAABJRU5ErkJggg==") no-repeat 50px center #e74c3c;
        cursor: pointer;
        -webkit-transition: background-color 0.4s ease-in-out;
        -moz-transition: background-color 0.4s ease-in-out;
        -o-transition: background-color 0.4s ease-in-out;
        transition: background-color 0.4s ease-in-out;
        cursor: pointer;
    }

    .toggle-btn.active {
        background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAmUlEQVQ4T6WT0RWDMAhFeZs4ipu0mawZpaO4yevBc6hUIWLNd+4NeQDk5sE/PMkZwFvZywKSTxF5iUgH0C4JHGyF97IggFVSqyCFga0CvQSg70Mdwd8QSSr4sGBMcgavAgdvwQCtApvA2uKr1x7Pu++06ItrF5LXPB/CP4M0kKTwYRIDyRAOR9lJTuF0F0hOAJbKopVHOZN9ACS0UgowIx8ZAAAAAElFTkSuQmCC") no-repeat 10px center #2ecc71;
    }

    .toggle-btn.active .round-btn {
        left: 45px;
    }

    .toggle-btn .round-btn {
        width: 30px;
        height: 30px;
        background-color: #fff;
        border-radius: 50%;
        display: inline-block;
        position: absolute;
        left: 5px;
        top: 50%;
        margin-top: -15px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    .toggle-btn .cb-value {
        position: absolute;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        z-index: 9;
        cursor: pointer;
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    }

    .subtaskimage {
        height: 30px;
        width: 30px;
        border-radius: 50%;
        border: 2px solid #eee;
    }

    .slick {
        display: none;
    }

    .subtaskimage {
        height: 30px;
        width: 30px;
        border-radius: 50%;
        border: 2px solid #eee;
    }

    #select55 {
        width: 100%;
    }
    .select2-container--default .select2-selection--single
    {
        border: 1px solid #eee !important;
        font-size: 13px ;
        margin-bottom: 5px ;
    }

    #selectator_select55 {
        width: 100% !important;
        min-height: 30px !important;
        position: relative;
        margin-bottom: 25px;
    }

    .tagname {
        float: left;
        font-size: 12px;
        background-color: #eee;
        border-radius: 5px;
        padding: 3px;
        margin-right: 3px;
    }
    .tagname i{
        color: #013c60;
    }

    .subtask_dropdown {
        font-size: 17px;
    }

    .subtask_dropdown::after {
        display: none;
        display: none;
    }

    .subtask_dropdown:hover {
        color: #70baff;
        cursor: pointer;
    }

    .custom_dropdown_subtask {
        font-size: 13px;
    }

    .custom_dropdown_subtask i {
        font-size: 13px;
        color: #cccccc;
    }

    .custom_trash {
        visibility: visible !important;
        font-size: 13px !important;;
    }

    .custom_trash:hover {
        color: #e74c3c !important;
    }

    .btn-copy {
        visibility: visible !important;
        font-size: 13px !important;
        padding: 4px;
    }

    .btn-copy:hover {
        color: #485eff !important;
    }
    .likecomment
    {
        color: #0a53be;
        /* float: left; */
        font-size: 13px;
    }
    .select2-results
    {
        font-size: 13px ;
    }
</style>


<!--Main Navigation-->
<header>
    <!-- Sidebar -->

    <div id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <form id="edit_subtask" action="{{route('admin.tasks.update',$task->id)}}" method="POST"
              enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="task_id" value="{{$task->id}}" id="task_id">
            <div class="position-sticky">

                <div class="main-tasks">

                    <div class="task-details">

                        <div class="row">
                            <div class="col-md-9">
                                <div class="main_tasks_header">
                                    <input type="text" name="task_title" value="{!!$task->task_title!!}"
                                           data-name="task_title" class="target form-control popup_title">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button id="dismiss" class="dismiss" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>





                        <div class="row">
                            <div class="col-md-2">
                                <lable class="control-label">Verantwortlich</lable>
                            </div>

                            <div class="col-md-7">
                                <select name="task_responsible" data-name="task_responsible"
                                        class="form-control custom-select target task_responsible ">
                                    @foreach ($users as $key => $user)
                                        <option value="{{$user->id}}"
                                                @if($task->task_responsible == $user->id ) selected='selected' @endif > {{$user->user_name }} </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>




                       <!--Start  Users Auto Serach -->
                        <div class="row">
                            <div class="col-md-2">
                                <lable class="control-label">Beteiligt</lable>
                            </div>

                            <div class="col-md-7">
                                <select id="select3" name="teams_id[]" class="target" multiple data-name="teams_id">

                                    @php
                                        $team_ids = \App\Models\TaskTeam::where('task_id' , $task->id)->pluck('user_id');
                                        $team_ids2 = json_decode($team_ids);
                                    @endphp
                                    @if(!empty($users3))
                                        @foreach ($users3 as $key => $user3)
                                            <option id="{{$key}}" value="{{$user3->id}}" name="teams_id[]"
                                                    data-left="{{asset('public/assets/images/users/'.$user3->image)}}"
                                                    @if(in_array($user3->id , $team_ids2)) selected @endif >    {{$user3->user_name}}</option>
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


                        <!--End Usesrs  Auto search -->



                        <!--Multi select  22 -->
                        <div class="row">
                            <div class="col-md-2">
                                <lable class="control-label">Besucher</lable>
                            </div>

                            <div class="col-md-7">
                                <select id="select5" name="guests_id[]" class="target" multiple data-name="guests_id">


                                    @php
                                        $guest_ids = \App\Models\TaskGuest::where('task_id' , $task->id)->pluck('user_id');
                                        $guest_ids2 = json_decode($guest_ids);
                                    @endphp
                                    @if(!empty($users2))
                                        @foreach ($users2 as $key => $user2)
                                            <option id="{{$key}}" value="{{$user2->id}}"
                                                    data-left="{{asset('public/assets/images/users/'.$user2->image)}}"
                                                    @if(in_array($user2->id , $guest_ids2)) selected @endif >    {{$user2->user_name}}</option>
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
                        <!--End Multi Select  22 -->


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <lable class="control-label">Termin</lable>
                                </div>

                                <div class="col-md-7">

                                    <div class="datepicker">
                                        <input type="text" value="{{date('d.m.Y', strtotime($task->task_due_date))}}"
                                               class="dateTimeFlatpickr form-control flatpickr flatpickr-input target"
                                               data-name="task_due_date" name="task_due_date" placeholder="DeadLine">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <lable class="control-label">Fachbereich1</lable>
                                </div>
                                <div class="col-md-7">

                                    <select name="task_category_id" class="custom-select form-control target Fachbereich"
                                            data-name="task_category_id">
                                        @foreach ($cats as $key => $cat)
                                            <option value="{{$cat->id}}"
                                                    @if($task->task_category_id == $cat->id ) selected @endif > {{$cat->category_name }} </option>
                                        @endforeach
                                    </select>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <lable class="control-label">Fachbereich2</lable>
                                </div>
                                <div class="col-md-7">

                                    <select name="task_category_id_two" class="custom-select form-control target"
                                            data-name="task_category_id_two">
                                        <option value=""> Fachbereich2 wählen</option>
                                        @foreach ($cats as $key => $cat)
                                            <option value="{{$cat->id}}"
                                                    @if($task->task_category_id_two == $cat->id ) selected @endif > {{$cat->category_name }} </option>
                                        @endforeach
                                    </select>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <lablel class="control-label">Unter Kategorie</lable>
                                </div>
                                <div class="col-md-7">


                                    <select id="select6" name="tags_id[]" class="target" multiple data-name="tags_id">

                                        @php
                                            $tag_ids = \App\Models\TaskTag::where('task_id' , $task->id)->pluck('tag_id');
                                            $tags_ids2 = json_decode($tag_ids);
                                        @endphp
                                        @if(!empty($tags))
                                            @foreach ($tags as $key => $tag)
                                                @php $tagg = \App\Models\Tag::where('tag_name' , $tag->tag_name)->first();  @endphp
                                                <option id="{{$key}}" value="{{$tagg->id}}"
                                                        @if(in_array($tagg->id , $tags_ids2)) selected @endif >    {{$tag->tag_name}}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    <input value="activate6" id="activate_selectator6" type="hidden">
                                    <script type="text/javascript">
                                        $(function () {
                                            var $activate_selectator6 = $('#activate_selectator6');

                                            $activate_selectator6.click(function () {
                                                var $select6 = $('#select6');
                                                if ($select6.data('selectator') === undefined) {
                                                    $select6.selectator({
                                                        showAllOptionsOnFocus: true,
                                                        useDimmer: true,
                                                        searchFields: 'value text subtitle right'
                                                    });
                                                    $activate_selectator6.val('destroy');
                                                } else {
                                                    $select6.selectator('destroy');
                                                    $activate_selectator6.val('activate6');
                                                }
                                            });
                                            $activate_selectator6.trigger('click');
                                        });
                                    </script>


                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <lable class="control-label">Beschreibung</lable>
                                </div>
                                <div class="col-md-7">
                                    <textarea class="form-control target txta" data-name="task_desc"
                                              style="margin-top:5px !important;">{{$task->task_desc}}</textarea>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="subtasks-header">
                        <div class="row">
                            <div class="col-md-2"><i class="bi bi-calendar2-plus"></i> Unteraufgaben</div>
                            <div class="col-md-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input cb-value " type="checkbox">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="sub_tasks2">
                        <div class="sub_tasks_header">

                        </div>
                        <div class="col-md-10">
                            <div class="container">
                                <ul class="todo box-shadow">
                                    <li class="title">

                                        <span class="percentage"></span>
                                    </li>
                                    <div class="task-container" id="shuffle2">
                                        @if(!empty($task->un_completed_subtasks))
                                            @foreach($task->un_completed_subtasks as $subtask)
                                                <li @if($subtask->subtask_status != 0) class="task  ui-state-default completed"
                                                    @else class="task  ui-state-default"
                                                    @endif  data-id="{{$subtask->id}}" id="subtask{{$subtask->id}}">
                                                    <i class="bi bi-three-dots-vertical subtask_dropdown dropdown-toggle"
                                                       id="custom_dropdown_subtask" data-bs-toggle="dropdown"
                                                       aria-expanded="false"></i>
                                                    <ul class="dropdown-menu" aria-labelledby="custom_dropdown_subtask">
                                                        <li>
                                                            <a class="dropdown-item btn-remove unselectable custom_trash"
                                                               data-id="{{$subtask->id}}" href="#"><i
                                                                    class="bi bi-trash "></i> löschen</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item btn-copy copy_task"
                                                               data-id="{{$subtask->id}}"
                                                               href="#"><i class="bi bi-file-break-fill"></i>
                                                                kopieren</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item btn-copy cut_task"
                                                               data-id="{{$subtask->id}}"
                                                               href="#"><i class="bi bi-file-break-fill"></i>
                                                                Verschieben</a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item btn-copy post_task"
                                                               data-id="{{$subtask->id}}"
                                                               href="#"><i class="bi bi-file-break-fill"></i>
                                                                Post-it</a>
                                                        </li>
                                                    </ul>
                                                    <img
                                                        src="https://gtek.pri-po.com/public/assets/images/users/{{$subtask->added_by->image}}"
                                                        class="subtaskimage"/>
                                                    <i class="material-icons unselectable btn-drag">drag_indicator</i>

                                                    <input class="taskched change_status" data-id="{{$subtask->id}}"
                                                           type="checkbox"
                                                           @if($subtask->subtask_status != 0) checked @else  ' '  @endif
                                                    >
                                                    <span class="description desc" data-id="{{$subtask->id}}"
                                                          contenteditable="true">{!!$subtask->subtask_title!!}</span>
                                                <!-- <input type="date" class="date dte" data-id="{{$subtask->id}}" value="{{$subtask->subtask_due_date}}"> -->


                                                    <div class="test">
                                                        <div class="calender">
                                                            <label>@if(  !empty($subtask->subtask_due_date) &&  date('d.m.Y', strtotime($subtask->subtask_due_date)) !='01.01.1970' )

                                                                    <script>
                                                                        $("#subtask{{$subtask->id}} .ui-datepicker-trigger").css('visibility', 'hidden');
                                                                    </script>
                                                                    <p class="date_text">  {{date('d.m.Y', strtotime($subtask->subtask_due_date))}}</p>

                                                                @else
                                                                    <script>
                                                                        $("#subtask{{$subtask->id}} .ui-datepicker-trigger").css('visibility', 'visible');
                                                                    </script>
                                                                @endif

                                                            </label>
                                                            <input type="hidden" class="hiddenInput date dte"
                                                                   data-id="{{$subtask->id}}"
                                                                   value="{{$subtask->subtask_due_date}}"/>
                                                            </label>
                                                        </div>
                                                    </div>


                                                    <select class="slick{{$subtask->id}}" data-id="{{$subtask->id}}"
                                                            name="TaskResponsiple">
                                                        <option
                                                            data-imagesrc="{{asset('public/assets/images/person.png')}}"></option>
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}"
                                                                    data-description="{{$subtask->id}}"
                                                                    data-imagesrc="{{asset('public/assets/images/users/'.$user->image)}}"
                                                                    @if($subtask->subtask_user_id == $user->id ) selected="selected" @endif></option>
                                                        @endforeach
                                                    </select>

                                                    <input type="hidden" value="{{$subtask->id}}" class="testinput"
                                                           data-id="{{$subtask->id}}"/>


                                                </li>
                                            @endforeach
                                        @endif
                                    </div>
                                    <li class="create">
                                        <i class="material-icons unselectable">add</i>
                                        <input class="new-task" contenteditable="true" placeholder="Unteraufgabe">
                                    </li>
                                    <li class="bottom"></li>
                                </ul>
                            </div>

                        </div>
                    </div>


                    <!-- Start Completed Tasks -->

                    <div class="sub_tasks3" style="display:none;">
                        <div class="col-md-10">
                            <div class="container">
                                <ul class="todo box-shadow">
                                    <li class="title">

                                        <span class="percentage"></span>
                                    </li>
                                    <div class="task-container" id="shuffle2">
                                        @if(!empty($task->completed_subtasks))
                                            @foreach($task->completed_subtasks as $subtask)

                                                <li @if($subtask->subtask_status != 0) class="task  ui-state-default completed"
                                                    @else class="task  ui-state-default"
                                                    @endif  data-id="{{$subtask->id}}" id="subtask{{$subtask->id}}">

                                                    <i class="bi bi-three-dots-vertical subtask_dropdown dropdown-toggle"
                                                       id="custom_dropdown_subtask" data-bs-toggle="dropdown"
                                                       aria-expanded="false"></i>
                                                    <ul class="dropdown-menu" aria-labelledby="custom_dropdown_subtask">
                                                        <li>
                                                            <a class="dropdown-item btn-remove unselectable custom_trash"
                                                               data-id="{{$subtask->id}}" href="#"><i
                                                                    class="bi bi-trash "></i> löschen</a></li>
                                                        <li><a class="dropdown-item btn-copy copy_task" data-id="{{$subtask->id}}"
                                                               href="#">
                                                                <i class="bi bi-file-break-fill"></i>
                                                                kopieren </a></li>
                                                        <li>
                                                            <a class="dropdown-item btn-cut cut_task"
                                                               data-id="{{$subtask->id}}"
                                                               href="#"><i class="bi bi-file-break-fill"></i>
                                                                schneiden</a>
                                                        </li>
                                                    </ul>
                                                    <i class="material-icons unselectable btn-drag">drag_indicator</i>

                                                    <input class="taskched change_status" data-id="{{$subtask->id}}"
                                                           type="checkbox"
                                                           @if($subtask->subtask_status != 0) checked @else  ' '  @endif
                                                    >
                                                    <span class="description desc" data-id="{{$subtask->id}}"
                                                          contenteditable="true">{!!$subtask->subtask_title!!}</span>
                                                <!-- <input type="date" class="date dte" data-id="{{$subtask->id}}" value="{{$subtask->subtask_due_date}}"> -->


                                                    <div class="test">
                                                        <div class="calender">
                                                            <label>@if(  !empty($subtask->subtask_due_date) &&  date('d.m.Y', strtotime($subtask->subtask_due_date)) !='01.01.1970' )

                                                                    <script>
                                                                        $("#subtask{{$subtask->id}} .ui-datepicker-trigger").css('visibility', 'hidden');
                                                                    </script>
                                                                    <p class="date_text">  {{date('d.m.Y', strtotime($subtask->subtask_due_date))}}</p>

                                                                @else
                                                                    <script>
                                                                        $("#subtask{{$subtask->id}} .ui-datepicker-trigger").css('visibility', 'visible');
                                                                    </script>
                                                                @endif

                                                            </label>
                                                            <input type="hidden" class="hiddenInput date dte"
                                                                   data-id="{{$subtask->id}}"
                                                                   value="{{$subtask->subtask_due_date}}"/>
                                                            </label>
                                                        </div>
                                                    </div>


                                                    <select class="slick{{$subtask->id}}" data-id="{{$subtask->id}}"
                                                            name="TaskResponsiple">
                                                        <option
                                                            data-imagesrc="{{asset('public/assets/images/person.png')}}"></option>
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}"
                                                                    data-description="{{$subtask->id}}"
                                                                    data-imagesrc="{{asset('public/assets/images/users/'.$user->image)}}"
                                                                    @if($subtask->subtask_user_id == $user->id ) selected="selected" @endif></option>
                                                        @endforeach
                                                    </select>

                                                    <input type="hidden" value="{{$subtask->id}}" class="testinput"
                                                           data-id="{{$subtask->id}}"/>


                                                </li>
                                            @endforeach
                                        @endif
                                    </div>

                                    <li class="bottom"></li>
                                </ul>
                            </div>

                        </div>
                    </div>

                    <!-- End Completed Tasks -->
                    <!--Start  Comments -->
                    <div class="comments">
                        <!--Multi select  22 -->
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <lable class="control-label taglabel">Benachrichtigung an <i
                                        class="bi bi-people-fill"></i></lable>
                            </div>
                            <div class="col-md-6">
                                <select id="select55" name="tags[]" class="target userTags" multiple data-name="tags[]">
                                    @foreach($users_gests as $user)
                                        <option id="{{$user->id}}" value="{{$user->id}}"
                                                data-left="{{asset('public/assets/images/users/'.$user->image)}}"> {{$user->first_name}}</option>
                                    @endforeach

                                </select>
                                <input value="activate55" id="activate_selectator55" type="hidden">
                                <script type="text/javascript">
                                    $(function () {
                                        var $activate_selectator55 = $('#activate_selectator55');

                                        $activate_selectator55.click(function () {
                                            var $select55 = $('#select55');

                                            if ($select55.data('selectator') === undefined) {
                                                $select55.selectator({
                                                    showAllOptionsOnFocus: true,
                                                    useDimmer: true,
                                                    searchFields: 'value text subtitle right'
                                                });
                                                $activate_selectator55.val('destroy');
                                                console.log('1' + $select55.data('selectator'));
                                            } else {
                                                $select55.selectator('destroy');
                                                $activate_selectator55.val('activate55');
                                                console.log('2' + $select55.data('selectator'));
                                            }

                                        });
                                        $activate_selectator55.trigger('click');
                                        /* Append Comments values to  comment box */
                                        /*
                                        $('#select55').on('change' ,function () {
                                                var x = document.querySelectorAll("[class='selectator_selected_items']");
                                                for (var i=0;i<x.length;i++) {
                                                     $('#commentbox').val(x[i].innerText) ;
                                                }
                                           });*/

                                    });
                                </script>
                            </div>
                        </div>
                        <!--End Multi Select  22 -->
                        <div class="row" style="margin-bottom:30px;">
                            <form method="post">
                                <div class="col-md-9">
                                    <textarea id="commentbox" rows="5" class="form-control"
                                              placeholder="Kommentar einfügen ..."></textarea>
                                    <button id="add_comment" class="send-comment send-comment2 pull-right"><i
                                            class="fas fa-paper-plane"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="comments2">
                            @foreach($task->comments as $comment)
                                <div class="col-md-9">
                                    <div class="comment" id="com_dta{{$comment->id}}">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <img class="comment_maker"
                                                     src="{{asset('public/assets/images/users/'.$comment->user->image)}}"
                                                     alt="test" style="width: 40px;height:40px;"/>
                                            </div>
                                            <div class="col-md-11">
                                                <h5>{{ $comment->user->user_name }} <span
                                                        class="comment-date">  {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}  </span>
                                                </h5>
                                                @if(!empty($comment->comment))
                                                    <p contenteditable="false" id="comment_name{{$comment->id}}"
                                                       data-id="{{$comment->id}}"
                                                       class="commentt_name"> {!!$comment->comment!!}</p>
                                                            @php
                                                                if(!empty($comment->tags)) {

                                                                   $readusers =  json_decode($comment->readby) ;
                                                                   $tags = explode(',', $comment->tags);

                                                                    foreach($tags as  $user)
                                                                    {


                                                                             $tagusers = \App\Models\User::where(['id'=>$user])->first() ;
                                                                             if(!empty($tagusers)){
                                                                                echo "<span class='tagname'>@".$tagusers->first_name." " ;
                                                                                  if(!empty($readusers)){
                                                                                             if(in_array( $tagusers->id , $readusers)) {
                                                                                             echo "<i class=' fa-solid  fa-thumbs-up'></i>" ;
                                                                                             }
                                                                                   }
                                                                                   echo "</span>";
                                                                              }
                                                                     }
                                                                }

                                                            @endphp
                                                @endif
                                                @if(!empty($comment->comment_image))
                                                    <p>
                                                        <a href="{{asset('public/assets/images/comments/'.$comment->comment_image)}}"
                                                           target="_blank"><img
                                                                src="{{asset('public/assets/images/comments/'.$comment->comment_image)}}"
                                                                style"width:30px;height:30px;"></a></p>
                                                @endif


                                                @if(!empty($comment->comment_pdf))

                                                    <p>
                                                        <a href="{{asset('public/assets/images/comments/'.$comment->comment_pdf)}}"
                                                           target="_blank"> Open a PDF file. </a></p>
                                                @endif
                                                @if(auth()->user()->role != 1 && auth()->user()->id  == $comment->comment_added_by )
                                                    <i class="fa fa-edit edit_comment" data-id="{{$comment->id}}"></i>test
                                                    <i class="fa fa-trash del_comment" data-id="{{$comment->id}}"></i>
                                                @endif
                                                @if(auth()->user()->role == 1 )
                                                    <i class="fa fa-edit edit_comment" data-id="{{$comment->id}}"></i>
                                                    <i class="fa fa-trash del_comment" data-id="{{$comment->id}}"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <form id="dataup" class="form" method="POST" action="{{route('admin.subtasks.store_comment')}}"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="image">
                        <input type="hidden" name="task_id" value="{{$task->id}}">
                        <label for="custom-file-upload" class="filupp">
                            <span class="filupp-file-name js-value">Bild hochladen <i class="fa fa-file"></i>  </span>
                            <input type="file" name="comment_image" id="custom-file-upload"/>
                        </label>
                        <input type="submit" value="Bild hochladen"
                               style="background-color:#3bebff;color:#fff;padding:8px;border-radius:5px;"
                               class="submit_comment">
                    </form>
                </div>
                <div class="col-md-5">
                    <div class="action_buttons">
                        @if($task->task_status == 0 || $task->task_status == 1)
                            <button class="remove-task btnn-remove btn btn-danger"><i class="fa fa-trash"></i> Löschen
                            </button>
                        @else
                            <button class="unremove-task  btnn-remove btn btn-danger"><i class="fa fa-trash"></i>
                                Wiederherstellen
                            </button>
                        @endif

                        @if($task->task_status == 0 || $task->task_status == 2)
                            <button class="complete_task btn-complete btn btn-success"><i
                                    class="fa fa-check-circle"></i> Aufgabe erledigt
                            </button>
                        @else
                            <button class="uncomplete_task btn-complete btn btn-success"><i
                                    class="fa fa-check-circle"></i> Aufgabe nicht erledigt
                            </button>
                        @endif
                    </div>
                </div>
            </div>

<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.task_responsible').select2();
        $('.Fachbereich').select2();
        $('.Fachbereich2').select2();



    });
</script>
            <script>

                $(document).ready(function () {

                    $(document).on('keyup', '.desc', function () {
                        var subtask_id = $(this).data('id');
                        var desc_val = $(this).text();
                        //	  alert(desc_val);
                        $.ajax({
                            type: "POST",
                            url: '{{route('admin.subtasks.updatefielddd')}}', // need to create this post route
                            data: {subtask_id: subtask_id, desc_val: desc_val, _token: '{{ csrf_token() }}'},
                            cache: false,
                            success: function (data) {

                            },
                            error: function (jqXHR, status, err) {
                            },
                        });

                    });

                    // open popup for copy task

                   $('.copy_task').click(function (){

                       const id = $(this).data('id');
                       $(document).on('change','#categories_select',function(){

                         const cat_id = $('#categories_select').val();
                           $.ajax({
                               type: "POST",
                               url: '{{route('categories.ajax')}}',   // need to create this post route
                               cache: false,
                               data:{id:id,cat_id:cat_id,_token:'{{csrf_token()}}'},
                               success: function (data) {
                                   $('#copy_subtask_modal_body').html(data.html);

                               },
                               error: function (jqXHR, status, err) {
                               },
                           });
                       });
                       $.ajax({
                           type: "POST",
                           url: '{{route('categories.ajax')}}',   // need to create this post route
                           cache: false,
                           data:{id:id,_token:'{{csrf_token()}}'},
                           success: function (data) {
                               $('#copy_subtask_modal_body').html(data.html);
                               $('#copy_subtask_modal').modal('show');
                           },
                           error: function (jqXHR, status, err) {
                           },
                       });

                   });

                    $('.post_task').click(async function (){
                        const id = $(this).data('id');
                        const inputOptions = new Promise((resolve) => {
                            setTimeout(() => {
                                resolve({
                                    'pd': 'Post-it & delete',
                                    'ponly': 'Post-it Only',
                                })
                            }, 200)
                        })

                        const { value: color } = await Swal.fire({
                            title: 'Sind Sie sicher, dass Sie es posten möchten?',
                            icon:'warning',
                            input: 'radio',
                            showCloseButton: true,
                            showCancelButton: true,
                            inputOptions: inputOptions,
                            inputValidator: (value) => {
                                if (!value) {
                                    return 'You need to choose something!'
                                }
                            }
                        })

                        if (color) {
                            let subtask_delete= false;
                            if(color =='pd'){
                                subtask_delete = true ;
                            }
                            if (color =='ponly'){
                                subtask_delete = false;
                            }

                       $.ajax({
                            type: "POST",
                            url: '{{route('categories.ajax.post')}}',   // need to create this post route
                            cache: false,
                            data:{id:id,subtask_delete},
                            success: function (data) {
                            if(data.success){
                                Swal.fire({
                                    icon: 'success',
                                    title: `${data.success}`,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                            },
                            error: function (jqXHR, status, err) {

                             if(err.error){
                                 swal(`${err.error}`, {
                                     icon: "error",

                                 });
                             }
                            },
                        });

                        }


                    });

                    $('.cut_task').click(function (){

                        const id = $(this).data('id');
                        $(document).on('change','#categories_select',function(){
                            const cat_id = $('#categories_select').val();
                            $.ajax({
                                type: "POST",
                                url: '{{route('categories.ajax.cut')}}',   // need to create this post route
                                cache: false,
                                data:{id:id,cat_id:cat_id},
                                success: function (data) {
                                    console.log(data)
                                    $('#copy_subtask_modal_body').html(data.html);

                                },
                                error: function (jqXHR, status, err) {
                                },
                            });
                        });
                        $.ajax({
                            type: "POST",
                            url: '{{route('categories.ajax.cut')}}',   // need to create this post route
                            cache: false,
                            data:{id:id},
                            success: function (data) {
                                $('#copy_subtask_modal_body').html(data.html);
                                $('#copy_subtask_modal').modal('show');
                            },
                            error: function (jqXHR, status, err) {
                            },
                        });

                    });
                    $('.taskched').each(function () {
                        $(this).on('change', function (event) {

                            if (jQuery(this).prop("checked")) {
                                jQuery(this).parents('li').addClass('completed');
                                var id = $(this).data('id');
                                var dta = $(this).text();

                                var task_id = $("#task_id").val();
                                //
                                $.ajax({

                                    type: 'POST',
                                    url: '{{ route('admin.subtasks.update_status') }}',
                                    data: {id: id, task_id: task_id, _token: '{{ csrf_token() }}'},
                                    success: function (data) {
                                        $('#task' + task_id).html('');
                                        $('#task' + task_id).html(data.options);
                                    }
                                });
                            } else {
                                jQuery(this).parents('li').removeClass('completed');
                                var id = $(this).data('id');
                                var dta = $(this).text();
                                //alert(dta);
                                var task_id = $("#task_id").val();
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ route('admin.subtasks.update_status') }}',
                                    data: {id: id, task_id: task_id, _token: '{{ csrf_token() }}'},
                                    success: function (data) {
                                        $('#task' + task_id).html('');
                                        $('#task' + task_id).html(data.options);
                                    }
                                });
                            }
                        });
                    });
                });
            </script>


            <script>


                var CLS_MATERIAL_ICONS = "material-icons";
                var CLS_DESCRIPTION = "description";
                var CLS_BTN_REMOVE = "btn-remove";
                var CLS_TASK = "task";
                var CLS_UNSELECTABLE = "unselectable";
                var CLS_CHECKBOX = "checkbox";
                var CLS_BTN_DRAG = "btn-drag";

                // KC - KeyCode
                var KC_BACKSPACE = 8;
                var KC_ENTER = 13;
                var KC_UP = 38;
                var KC_DOWN = 40;
                var KS_LEFT = 37;
                var KS_RIGHT = 39;

                var POS_DESCR = 4;
                var POS_CHECKBOX = 1;
                var POS_DATE = 3;
                var POST_SELECT = 4;

                var taskList = document.querySelector(".todo .task-container");
                var percentage = document.querySelector(".todo .percentage");
                var newTask = document.querySelector(".todo .new-task");

                function load() {
                    /*
                    var aTasks = [];
                    var loadedString = localStorage.getItem("tasks");

                    if (loadedString != null) {

                      aTasks = JSON.parse(loadedString);
                      for (let i = 0; i < aTasks.length; i++) {
                          var descr = aTasks[i].description;
                          var isComplete = aTasks[i].isComplete;
                          var task = createNewTask(descr, isComplete);
                          taskList.appendChild(task);
                      }
                    }
                    */
                }

                function save() {

                    var aTasks = [];

                    for (let i = 0; i < taskList.children.length; i++) {
                        aTasks[i] = {
                            isComplete: taskList.children[i].children[POS_CHECKBOX].state,
                            description: taskList.children[i].children[POS_DESCR].innerHTML,
                            date: taskList.children[i].children[POS_DATE].value,
                            resposiple: taskList.children[i].children[POST_SELECT].value
                        };

                    }

//  for (let i = 0; i < aTasks.length; i++) {
//         console.log(aTasks[i]);
//   }

                    $(document).ready(function () {
                        var task_id = $("#task_id").val();
                        if (aTasks[aTasks.length - 1].date == 'on') {
                            aTasks[aTasks.length - 1].date = null;
                        }

                        $.ajax({
                            type: "POST",
                            url: '{{route('admin.subtasks.store')}}',   // need to create this post route
                            data: {
                                subtask_title: aTasks[aTasks.length - 1].description,
                                subtask_due_date: aTasks[aTasks.length - 1].date,
                                task_id: task_id,
                                _token: '{{ csrf_token() }}'
                            },
                            cache: false,
                            success: function (data) {
                                $('#task' + task_id).html('');
                                $('#task' + task_id).html(data.options);
                            },
                            error: function (jqXHR, status, err) {


                            },
                        });

                    });

                    localStorage.setItem("tasks", JSON.stringify(aTasks));


                }

                function updatePercentage() {
                    var taskCount = taskList.children.length;
                    var completedTaskCount = 0;

                    for (let i = 0; i < taskCount; i++) {
                        var cb = taskList.children[i].children[POS_CHECKBOX];
                        completedTaskCount += cb.state;
                    }

                    if (taskCount == 0) {
                        percentage.innerHTML = "";
                    } else {
                        percentage.innerHTML = Math.round((completedTaskCount / taskCount) * 100) + "%";
                    }
                }

                function setCheckBoxState(checkBox, isDone) {
                    checkBox.state = isDone;
                    if (isDone) {
                        checkBox.innerHTML = "check_box";
                    } else {
                        checkBox.innerHTML = "check_box_outline_blank";
                    }
                }


                function updateStyle(task) {
                    if (task.children[POS_CHECKBOX].state) {
                        task.classList.add("completed");
                    } else {
                        task.classList.remove("completed");
                    }
                }

                function getCheckBoxState(checkBox) {
                    return checkBox.state;
                }

                function removeTask(task) {
                    console.log(task);
                    task.parentElement.removeChild(task);
                    updatePercentage();
                }

                /* Function from stackoverflow */
                function moveCursorToEnd(el) {
                    el.focus();
                    if (typeof window.getSelection != "undefined"
                        && typeof document.createRange != "undefined") {
                        var range = document.createRange();
                        range.selectNodeContents(el);
                        range.collapse(false);
                        var sel = window.getSelection();
                        sel.removeAllRanges();
                        sel.addRange(range);
                    } else if (typeof document.body.createTextRange != "undefined") {
                        var textRange = document.body.createTextRange();
                        textRange.moveToElementText(el);
                        textRange.collapse(false);
                        textRange.select();
                    }
                }

                function focusOnLastDescr(taskList) {
                    if (taskList.children.length > 0) {
                        var lastDescr = taskList.lastChild.children[POS_DESCR];
                        moveCursorToEnd(lastDescr);
                    }
                }

                function focusOnPrevDescr(task) {
                    if (task.previousSibling !== null) {
                        var prev = task.previousSibling.children[POS_DESCR];
                        moveCursorToEnd(prev);
                    }
                }

                var ic = 1;
                var xv = 1;
                var xx = Number('{{$last_subtask_id}}');

                <?php $SD = 1; ?>
                function createNewTask(text, isComplete) {


                    var task = document.createElement("li");
                    task.className = CLS_TASK;

                    var dragBtn = document.createElement("i");
                    dragBtn.className = CLS_MATERIAL_ICONS + " " + CLS_UNSELECTABLE + " " + CLS_BTN_DRAG;
                    dragBtn.innerHTML = "drag_indicator";


                    var checkBox = document.createElement("input");
                    checkBox.type = "checkbox";
                    checkBox.className = "change_status taskched";
                    checkBox.setAttribute('data-id', (xx + ic));

                    var descr = document.createElement("span");
                    descr.className = CLS_DESCRIPTION;
                    descr.innerHTML = text;
                    descr.setAttribute('data-id', (xx + ic));
                    descr.setAttribute("contenteditable", "true");

                    descr.onkeydown = function (e) {
                        if ((e.keyCode === KC_BACKSPACE) && ((e.target.innerHTML === "<br>") || (e.target.innerText.length === 0))) {
                            if (task.previousSibling !== null) {
                                focusOnPrevDescr(task);
                                removeTask(task);
                            }
                            /* Do not delete last character from selected task */
                            return false;
                        }

                        if ((e.keyCode === KC_ENTER) & (e.shiftKey === false)) {

                            <?php

                            $SD = $SD + 1;
                            ?>
                            save();
                            let t = createNewTask("", false);
                            task.after(t);
                            t.getElementsByClassName(CLS_DESCRIPTION)[0].focus();
                            updatePercentage();

                            /*var num = task.getElementsByClassName('hiddenInput')[0].getAttribute('data-id') ;*/


                            //$(".sub_tasks2").html('ttttt');
                            var task_id = $("#task_id").val();

                            return false;
                        }

                        if ((task.previousSibling !== null) && (e.keyCode === KC_UP) && (e.shiftKey === false)) {
                            task.previousSibling.children[POS_DESCR].focus();
                            return false;
                        }

                        if ((task.nextSibling !== null) && (e.keyCode === KC_DOWN) && (e.shiftKey === false)) {
                            task.nextSibling.children[POS_DESCR].focus();
                            return false;
                        }
                    }


                    /*
                    var  date  = document.createElement("input") ;
                    date.type ="date" ;
                    date.className = "date" ;
                    date.setAttribute('data-id' , (xx+ic));
                    */

                    var date = document.createElement("div");
                    date.className = "test";

                    var calender = document.createElement("div");
                    calender.className = "calender";
                    var label = document.createElement("label");
                    var newcalendar = date.appendChild(calender);
                    calender.appendChild(label);


                    var input = document.createElement("input");
                    input.type = "hidden";
                    input.className = "hiddenInput";
                    input.setAttribute('data-id', (xx + ic));
                    newcalendar.appendChild(input);


                    var responsiple = document.createElement("select");
                    responsiple.setAttribute('id', (xx + ic));
                    responsiple.className = "slick";
                    responsiple.name = "TaskResponsiple";
                    var users2 = new Array();
                    users2.push("<?php  echo " <option  data-imagesrc='https://pri-po.com/public/assets/images/person.png'> </option>";  ?>");
                    <?php
                    $url = url('/');
                    $ld = $last_subtask_id + $SD;
                    foreach($users as $user){ ?>
                    users2.push("<?php  echo "<option value='$user->id' data-description='$ld'  data-imagesrc= '$url/public/assets/images/users/$user->image'></option>";  ?>");
                    <?php }
                        ?>
                        responsiple.innerHTML = users2;


                    var resinput = document.createElement("input");
                    resinput.type = "hidden";
                    resinput.className = "testinput";
                    resinput.setAttribute('value', (xx + ic));


                    var deleteicones = document.createElement("i");
                    deleteicones.className = "bi bi-three-dots-vertical subtask_dropdown dropdown-toggle";
                    deleteicones.id = "custom_dropdown_subtask";
                    deleteicones.setAttribute('data-bs-toggle', 'dropdown');
                    deleteicones.setAttribute('aria-expanded', false);

                    var dropdown = document.createElement("ul");
                    dropdown.className = "dropdown-menu";
                    dropdown.setAttribute('aria-labelledby', 'custom_dropdown_subtask');

                    var lielment = document.createElement("li");
                    dropdown.appendChild(lielment);

                    var hyperlink = document.createElement("a");
                    hyperlink.className = "dropdown-item btn-remove unselectable custom_trash";
                    hyperlink.setAttribute('data-id', (xx + ic));
                    var trashicon = document.createElement("i");
                    trashicon.className = "bi bi-trash";
                    hyperlink.appendChild(trashicon);
                    hyperlink.innerHTML = 'löschen';
                    lielment.appendChild(hyperlink);


                    /*
                     var removeBtn = document.createElement("i");
                     removeBtn.className = CLS_MATERIAL_ICONS + " " + CLS_BTN_REMOVE + " " + CLS_UNSELECTABLE;
                     removeBtn.innerHTML = "remove_circle";
                     removeBtn.setAttribute('data-id' , (xx+ic));
                     removeBtn.onclick = function() {
                         removeTask(task);
                     };
                     */


                    /*Set TaskMaker */
                    /*
                    var subtaskimage  = document.createElement("img");
                    subtaskimage.className="subtaskimage";
                    subtaskimage.src = "http://pripo.germaniatek.co/public/assets/images/users/{{auth()->user()->image}}";
*/


                    task.appendChild(deleteicones);
                    task.appendChild(dropdown);
                    task.appendChild(dragBtn);
                    task.appendChild(checkBox);
                    task.appendChild(descr);
                    task.appendChild(date);
                    task.appendChild(responsiple);
                    task.appendChild(resinput);


                    updateStyle(task);

                    /*start  date plugin */
                    $('.hiddenInput').each(function () {
                        $(this).datepicker({
                            showOn: 'button',
                            dateFormat: 'dd.mm.yy',
                            buttonImage: 'https://pri-po.com/public/assets/images/calendar.png',
                            buttonImageOnly: true,
                            onSelect: function (selectedDate) {
                                $(this).closest(".test").find('.calender label').text(selectedDate);

                                var subtask_id = $(this).data("id");
                                var date_val = selectedDate;
                                $.ajax({
                                    type: "POST",
                                    url: '{{route('admin.subtasks.updatefielddd')}}', // need to create this post route
                                    data: {subtask_id: subtask_id, date_val: date_val, _token: '{{ csrf_token() }}'},
                                    cache: false,
                                    success: function (data) {
                                        // console.log('done');
                                    },
                                    error: function (jqXHR, status, err) {
                                    },
                                });


                            },

                            onClose: function (selectedDate) {
                                $(this).next('.ui-datepicker-trigger').css("visibility", "hidden");
                            }

                        });
                    });

                    $('.calender label').on('click', function () {
                        $(this).next(".hiddenInput").datepicker("show");
                    });

                    /*satrt select plugin */


// set select plugin after enter
                    $('.dd-click-off-close').css('display', 'none');

                    $('.slick').ddslick({


                        onSelected: function (selectedData) {
                            var xxx = task.children[POS_CHECKBOX].getAttribute('data-id');
                            var resp_val = selectedData.selectedData.value;
                            var subtask_id = xxx - 1;

                            $.ajax({
                                type: "POST",
                                url: '{{route('admin.subtasks.updatefielddd')}}', // need to create this post route
                                data: {subtask_id: subtask_id, resp_val: resp_val, _token: '{{ csrf_token() }}'},
                                cache: false,
                                success: function (data) {
                                    // console.log('done');

                                },
                                error: function (jqXHR, status, err) {
                                },
                            });


                        }

                    });
                    $('.dd-click-off-close').css('display', 'none');


                    ic++;
                    xv++;

                    console.log('{{$SD}}');

                    return task;

                }

                newTask.onkeydown = function (e) {
// Enter, Shift, Backspace, Up etc
                    var keyCodeIsSpecial = e.keyCode <= 47 | e.keyCode === 91 | e.keyCode === 144 | e.keyCode === 145;

                    if ((e.keyCode === KC_BACKSPACE) && (e.target.value === "")) {
                        return false;
                    } else if (!keyCodeIsSpecial) {

                        let task = createNewTask("", false);
                        if (taskList.children.length === 0) {
                            taskList.appendChild(task);
                        } else {
                            taskList.lastChild.after(task);

                        }
                        task.children[POS_DESCR].focus();
                        updatePercentage();
                    }
                }


                var firstStart =
                    (localStorage.getItem("first_start") === null) ||
                    (localStorage.getItem("first_start") === "true");

                if (firstStart) {


                    save();
                    localStorage.setItem("first_start", "false");
                } else {
                    load();
                }


                updatePercentage();

                var sortable = Sortable.create(taskList, {
                    handle: ".btn-drag",
                    animation: 100,
                    chosenClass: "todo-chosen-task",
                    ghostClass: "todo-ghost-task",
                    onUpdate: function () {
                        var list = new Array();
                        $('#shuffle2').find('.ui-state-default').each(function () {
                            var id = $(this).attr('data-id');
                            list.push(id);
                        });
                        console.log(list);

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: 'admin/subtasks/save_perority',
                            method: "POST",
                            data: {list: list},

                            success: function (data) {
                                // alert(data);
                            }
                        });
                    }
                });

            </script>


    </div>
    </div>
    </form>
    </div>


    </div>
    <!-- Sidebar -->
</header>
<!--Main Navigation-->

<!--Main layout-->
<main style="margin-top: 58px;">
    <div class="container pt-4"></div>
</main>
<!--Main layout-->
<!--End Sidebar -->


<script>

    $(document).ready(function () {

// $(document).on('change', '.taskched', function (event) {
// 	                            if(jQuery(this).prop("checked")){
// 	                             jQuery(this).parents('li').addClass('completed');
// 	                            }else
// 	                            {
// 	                             jQuery(this).parents('li').removeClass('completed');
// 	                            }
// 	                        });

        $(document).on('click', '.btn-remove', function (event) {
            $(this).closest('.task').remove();

            var id = $(this).data('id');
            var task_id = $("#task_id").val();
            //	 alert(task_id);

            $.ajax({


                type: 'POST',
                url: '{{ route('admin.subtasks.delete') }}',
                data: {id: id, task_id: task_id, _token: '{{ csrf_token() }}'},
                success: function (data) {
                    $('#task' + task_id).html('');
                    $('#task' + task_id).html(data.options);
                }
            });

        });


        "use strict";

        /* Start  ToDo Addition */
        let wrapper = document.querySelector('.wrapper');
        let newtodo = document.querySelector('.todo_name');
        let todo_date = document.querySelector('.todo_date');
        let todo_responsible = document.querySelector('.todo_responsible');
        let addtodo = document.querySelector('.add_todo');
        let todo = [];

// addtodo.addEventListener('click'  , ()=>{
//  if( newtodo.value !=''){
//   //   console.log('not empty');
//
//  //alert(todo_date.value);
//      todo.push([newtodo.value , todo_date.value  , todo_responsible.value ] ) ;
//
//  //Append Values
//
//  let newtodolist = document.createElement('div')  ;
//   newtodolist.className = 'item' ;
//         for(let i=0; i<todo.length;i++)
//         {
//              newtodolist.innerHTML = '<p>'+newtodo.value +'</p>'+ '<ul>'+'<li>'+todo_date.value + '</li><li>'  +  todo_responsible.value +'</li></ul>';
//              wrapper.appendChild(newtodolist) ;
//
//         }
//
//       if(todo.length > 0 )
//       {
//
//                  let item =  document.querySelectorAll('.item') ;
//                  let checkicone = document.createElement('i');
//                   checkicone.className = 'bi bi-check-circle' ;
//
//
//                  let trush = document.createElement('i');
//                   trush.className = 'bi bi-trash  trash' ;
//
//
//              for(let  j=0 ; j<item.length ; j++ )
//               {
//
//                    item[j].appendChild(checkicone) ;
//                    item[j].appendChild(trush) ;
//
//
//                   trush.addEventListener('click',  ()=>{
//
//                       trush.parentNode.remove();
//
//                   })
//               }
//       }
//
//
//       }
//
// });


// $('.trash').on('click',function(){
//     // alert($(this).closest('.item').data('id'));
//     // $(this).closest('.item').remove();
//
//
// });

        $('.trash').on('click', function () {

            if (!confirm("Are You Sure You Will Delete This Record")) {
                e.preventDefault();
                return false;
            }

            var id = $(this).closest('.item').data('id');
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.subtasks.delete') }}',
                data: {id: id, _token: '{{ csrf_token() }}'},
                success: function (data) {
                    $(this).closest('.item').remove();
                }
            });
            $(this).closest('.item').remove();
        });


// add subtask
        $('#add_subtask').on('click', function () {
            //  alert('hello');
            event.preventDefault();
            var subtask_title = $("#subtask_title").val();
            var subtask_user_id = $("#subtask_user_id").find(':selected').attr('data-id');
            var subtask_start_date = $("#subtask_start_date").val();
            var subtask_due_date = $("#subtask_due_date").val();
            var task_id = $("#task_id").val();
            //  alert(subtask_title  + '  '+subtask_user_id  + '  '+subtask_start_date  + '  '+subtask_due_date  + '  '+ task_id  + '  ');
            $.ajax({

                type: "post",
                url: "{{route('admin.subtasks.store')}}", // need to create this post route
                data: {
                    subtask_title: subtask_title,
                    subtask_user_id: subtask_user_id,
                    subtask_start_date: subtask_start_date,
                    subtask_due_date: subtask_due_date,
                    task_id: task_id,
                    _token: '{{ csrf_token() }}'
                },
                cache: false,
                success: function (data) {
                    //console.log('done');
                    $('.wrapper').html(data.options);

                },
                error: function (jqXHR, status, err) {
                },
            });

        });


        $('#edit_subtask .target').on('change', function () {

            //  alert('changed!');
            var task_id = $('#task_id').val();
            var field_name = $(this).data('name');
            var field_val = $(this).val();
            $.ajax({
                type: "post",
                url: "{{route('admin.tasks.update_field')}}", // need to create this post route
                data: {task_id: task_id, field_name: field_name, field_val: field_val, _token: '{{ csrf_token() }}'},
                cache: false,
                success: function (data) {
                    //  console.log('done');
                    //  $('.wrapper').html(data.options);
                    if (data.options == 'no') {
                        $('#task' + task_id).html('');
                        $('#task' + task_id).html(data.options2);
                    } else {
                        $('#task' + task_id).html('');
                        $('#task' + task_id).html(data.options);
                    }

                },
                error: function (jqXHR, status, err) {
                },
            });

        });


// add comment

        $('#commentbox').on('keyup', function (event) {
            if (event.keyCode === 13) {
                $(this).val($(this).val() + '</br>');
                console.log($(this).val);

            }
        });

        $("#add_comment").on('click', function () {

            // alert('hello'); admin.subtasks.store_comment
            event.preventDefault();
            var comment = $("#commentbox").val();
            var task_id = $("#task_id").val();

            var tags = $("#select55").val();
            var tagstring = tags.toString();

            $.ajax({

                type: "post",
                url: "{{route('admin.subtasks.store_comment')}}", // need to create this post route
                data: {comment: comment, tags: tagstring, task_id: task_id, _token: '{{ csrf_token() }}'},
                cache: false,
                success: function (data) {
                    //console.log('done');
                    //$('.wrapper').html(data.options);
                    $('#commentbox').html('');
                    $('.comments2').html(data.options);
                    $("#commentbox").val('');


                },
                error: function (jqXHR, status, err) {
                },
            });

        });


        $(".remove-task").click(function (e) {
            var task_id = $("#task_id").val();
            e.preventDefault();
            swal({
                title: "Are you sure sweet?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: '{{route('admin.tasks.delete')}}',
                            method: "POST",
                            data: {_token: '{{ csrf_token() }}', task_id: task_id},
                            success: function (response) {

                            }
                        });
                        swal("Poof! Your imaginary file has been deleted!", {
                            icon: "success",

                        });
                        //window.location.reload();
                        $('.sidebar').css({'width': '0'});
                        $('.sidebar-model').css({'width': '0'});
                        $('.overlay').css('display', 'none');
                        $('#task' + task_id).css('display', 'none');
                    } else {
                        //swal("Your imaginary file is safe!");
                    }
                });

            // var ele = $(this);
            // if(confirm("Are you sure")) {
            //     $.ajax({
            //         url: '{{url('admin.tasks.delete')}}',
            //         method: "DELETE",
            //         data: {_token: '{{ csrf_token() }}', task_id: task_id},
            //         success: function (response) {
            //             window.location.reload();
            //         }
            //     });
            // }

        });


        $(".unremove-task").click(function (e) {
            var task_id = $("#task_id").val();
            e.preventDefault();
            swal({
                title: "Are you sure sweet?",
                text: "restore the Task!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            url: '{{route('admin.tasks.undelete')}}',
                            method: "POST",
                            data: {_token: '{{ csrf_token() }}', task_id: task_id},
                            success: function (response) {

                            }
                        });
                        swal("Poof! Your imaginary file has been deleted!", {
                            icon: "success",

                        });
                        //  window.location.reload();
                        $('.sidebar').css({'width': '0'});
                        $('.sidebar-model').css({'width': '0'});
                        $('.overlay').css('display', 'none');
                        $('#task' + task_id).css('display', 'none');
                    } else {
                        //swal("Your imaginary file is safe!");
                    }
                });

            // var ele = $(this);
            // if(confirm("Are you sure")) {
            //     $.ajax({
            //         url: '{{url('admin.tasks.delete')}}',
            //         method: "DELETE",
            //         data: {_token: '{{ csrf_token() }}', task_id: task_id},
            //         success: function (response) {
            //             window.location.reload();
            //         }
            //     });
            // }

        });


        $(".complete_task").click(function (e) {
            var task_id = $("#task_id").val();
            $.ajax({
                url: '{{route('admin.tasks.mark_complete')}}',
                method: "POST",
                data: {_token: '{{ csrf_token() }}', task_id: task_id},
                success: function (response) {
                    //window.location.reload();
                    $('.sidebar').css({'width': '0'});
                    $('.sidebar-model').css({'width': '0'});
                    $('.overlay').css('display', 'none');
                    $('#task' + task_id).css('display', 'none');
                }
            });


        });

        $(".uncomplete_task").click(function (e) {
            var task_id = $("#task_id").val();
            $.ajax({
                url: '{{route('admin.tasks.mark_uncomplete')}}',
                method: "POST",
                data: {_token: '{{ csrf_token() }}', task_id: task_id},
                success: function (response) {
                    // window.location.reload();
                    $('.sidebar').css({'width': '0'});
                    $('.sidebar-model').css({'width': '0'});
                    $('.overlay').css('display', 'none');
                    $('#task' + task_id).css('display', 'none');
                }
            });


        });


        $(document).on('submit', '.form', function (e) {


            e.preventDefault();

            var formData = new FormData($("#dataup")[0]);
            //  alert(formData[0]);
            var url = $(this).attr("action");

            $.ajax({
                type: "post",
                url: url, // need to create this post route
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {

                    $('#commentbox').html('');
                    $('.comments2').html(data.options);
                    $(".filupp-file-name").text("Bild hochladen");

                },
                error: function (jqXHR, status, err) {


                },
                complete: function () {
                    scrollToBottomFunc();
                }
            });


        });


        $(document).on('submit', '.form2', function (e) {


            e.preventDefault();

            var formData = new FormData($("#dataup2")[0]);

            //   alert(formData);

            var url = $(this).attr("action");
            $.ajax({
                type: "post",
                url: url, // need to create this post route
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {

                    $('#commentbox').html('');
                    $('.comments2').html(data.options);
                },
                error: function (jqXHR, status, err) {


                },
                complete: function () {
                    scrollToBottomFunc();
                }
            })

        });


    });


</script>
<script>

    var show = true;

    function showCheckboxes() {
        var checkboxes =
            document.getElementById("checkBoxes");

        if (show) {
            checkboxes.style.display = "block";
            show = false;
        } else {
            checkboxes.style.display = "none";
            show = true;
        }
    }
</script>
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

<script>
    /*
                var counter = 1; //limits amount of transactions
                       function addElements() {
                           if (counter < 5) //only allows 4 additional transactions
                           {

                               let todo_wrap =  document.getElementById('todo_wrap') ;

                               let row = document.createElement('div');
                               row.id = 'row';
                               row.className = 'row';
                               todo_wrap.appendChild(row);


                               let cols = document.createElement('div');
                               cols.className= 'col-md-5 subtaskform';
                               row.appendChild(cols);


                               let label = document.createElement('label');
                               label.className ='new-control new-checkbox new-checkbox-rounded checkbox-success' ;
                               cols.appendChild(label);



                               let checkbox = document.createElement('input');
                               checkbox.id='subtask_title'+counter;
                               checkbox.type = 'checkbox ';
                               checkbox.className ='new-control-input' ;
                               label.appendChild(checkbox);


                               let span = document.createElement('span');
                               span.className ='new-control-indicatort' ;
                               label.appendChild(span);


                               let input = document.createElement('input');
                               input.id='subtask_title'+counter;
                               input.type = 'text ';
                               input.name= 'subtask_title';
                               input.className ='subtask_title' ;
                               cols.appendChild(input);





                              let cols2 = document.createElement('div');
                               cols2.className= 'col-md-3 subtaskform';
                               row.appendChild(cols2);

                               let date = document.createElement('input');
                               date.type = 'text';
                               date.name= 'subtask_due_date';

                               date.className ='dateTimeFlatpickr form-control flatpickr flatpickr-input' ;
                               cols2.appendChild(date);


                           }

                           counter++
                           if (counter >= 6) {
                               alert("You have reached the maximum transactions.")
                           }
                       }
                */
</script>


<script>
    $(document).ready(function () {
        var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
            enableTime: true,
            dateFormat: "d.m.Y  H:i",
        });


        $('.cb-value').click(function () {
            if ($(this).is(':checked')) {

                $('.sub_tasks2').css('display', 'none');
                $('.sub_tasks3').css('display', 'block');
            } else {
                $('.sub_tasks2').css('display', 'block');
                $('.sub_tasks3').css('display', 'none');
            }
        });

        $('.edit_comment').each(function () {
            $(this).on("click", function () {
                var cmid = $(this).data('id');
                $("#comment_name" + cmid).attr("contenteditable", "true");
                $("#comment_name" + cmid).css("border", "1px solid #ccc");
            });
        });

        $('.commentt_name').each(function () {
            $(this).on("keyup", function () {
                var id = $(this).data('id');
                var comment_name = $(this).text();

                $.ajax({
                    type: "POST",
                    url: '{{route('admin.comments.update')}}', // need to create this post route
                    data: {id: id, comment_name: comment_name, _token: '{{ csrf_token() }}'},
                    cache: false,
                    success: function (data) {
                        // console.log('done');
                    },
                    error: function (jqXHR, status, err) {
                    },
                });
            });
        });

        $('.del_comment').each(function () {
            $(this).on("click", function () {
                var id = $(this).data('id');

                swal({
                    title: "Are you sure sweet?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {

                            $.ajax({
                                url: '{{route('admin.comments.delete')}}',
                                method: "POST",
                                data: {_token: '{{ csrf_token() }}', id: id},
                                success: function (response) {

                                }

                            });
                            swal("Poof! Your imaginary file has been deleted!", {
                                icon: "success",

                            });
                            //window.location.reload();
                            $("#com_dta" + id).css('display', 'none');
                        } else {
                            //swal("Your imaginary file is safe!");
                        }
                    });

            });
        });

    });

</script>


});
