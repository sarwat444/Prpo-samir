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
    function change_category() {
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
    $(document).ready(function () {
        $('.hiddenInput').datepicker({
            showOn: 'button',
            dateFormat: 'dd.mm.yy',
            buttonImage: 'https://pri-po.com/public/assets/images/calendar.png',
            firstDay:1,
            buttonImageOnly: true,
            onSelect: function (selectedDate) {
                $(this).closest(".test").find('.calender label').text(selectedDate);
                let subtask_id = $(this).data("id");
                let date_val = selectedDate;
                $.ajax({
                    type: "POST",
                    url: '{{route('admin.subtasks.updatefielddd')}}', // need to create this post route
                    data: {subtask_id: subtask_id, date_val, _token: '{{ csrf_token() }}'},
                    cache: false,
                    success: function (data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: `${data.success}`,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }

                    },
                    error: function (jqXHR, status, err) {
                    },
                })
            },
            onClose: function (selectedDate) {
                $(this).next('.ui-datepicker-trigger').css("visibility", "hidden");
            }
        })

        $('.calender label').on('click', function () {
            $(this).next(".hiddenInput").datepicker("show");
        });
    })

</script>

<link href="{{asset('public/assets/admin/assets2/css/fm.selectator.jquery.css')}}" rel="stylesheet">
<script src="{{asset('public/assets/admin/assets2/js/fm.selectator.jquery.js')}}"></script>
<link href="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('public/assets/admin/plugins/flatpickr/flatpickr.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('public/assets/admin/assets2/css/theme-checkbox-radio.css')}}">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" ref="stylesheet">
<script src="{{asset('public/assets/admin/assets2/js/sweetalert.min.js')}}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
<link href="{{asset('public/assets/admin/assets2/css/dd.css')}}" rel="stylesheet">
<script src="{{asset('public/assets/admin/assets2/js/dd.min.js')}}"></script>
<style>
    .comment-box .controls
    {
        float: right;
        margin: 4px ;
    }
    .comment-box .controls .delete_comment:hover
    {
        color:#bb2d3b  !important;

    }
    .comment-box .controls .edit_replay:hover
    {
        color:#198754 !important;

    }
    .add_new_replay
    {
        display: none;
    }
    .add_replay
    {
        font-size: 11px;
        margin-top: 25px;
        font-weight: 500;
        color: #ec6630;
        margin-left: 13px;

    }
    .add_replay:hover
    {
        color: #777777;
        cursor: pointer;
    }
    .sub_tasks2 .ms-dd  ,
    .sub_tasks3 .ms-dd{
        width: 93px;
        font-size: 10px;
        background-color: transparent;
        border-radius: 0;
        margin-bottom: 7px;
        padding: -1px;
        font-size: 11px;
    }
    .selectator_element
    {
        min-height: 36px !important;
    }
    .completed_count
    {
        color: #0a53be;
        display: inline-block;
    }
    .uncompleted_count
    {
        color: #777777;
        display: inline-block;
    }
    .form-check
    {
        display: inline-block;
        margin-bottom: -8px;
        margin-left: 12px;
    }
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
    .dd-selected{
        height: 30px;
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
    #sidebarMenu
    {
        overflow-x: hidden;
        padding-bottom: 20px;
    }

    #sidebarMenu .todo .description {
        word-wrap: break-word;

    }

    #sidebarMenu #shuffle2 .desc {
        font-size: 12px;
    }


    #sidebarMenu .dd-pointer-down {
        display: none;

    }

    #sidebarMenu  .ui-datepicker-trigger {
        height: 20px;
    }

    #sidebarMenu .filupp > input[type=file] {
        position: absolute;

        width: 1px;
        height: 1px;

        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
    }

    #sidebarMenu .filupp {
        position: relative;
        background: #013c60;
        padding: 5px;
        font-size: 13px;
        color: #fff;
        width: 49%;
        text-align: center;
        border-radius: 4px !important;
    }

    #sidebarMenu .submit_comment {
        border: 0;
        background-color: #ccc !important;
        font-size: 13px;
        border-radius: 0 !important;
        width: 49%;
        padding: 6px !important;
        border-radius: 4px !important;
    }
    #sidebarMenu .comments .comment img {
        width: 35px !important;
        height: 35px !important ;
        margin-top: 2px;
        border: 1px solid #ccc;
    }
    .test .date_text
    {
        margin-top: 12px;
    }

    #sidebarMenu .txta {
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

    #sidebarMenu .remove-task,
    #sidebarMenu .complete_task {
        font-size: 11px;
    }

    #sidebarMenu .sub_tasks3 h3 {
        color: #013c60;
        font-size: 13px;
        /* border: 1px solid #777; */
        padding: 11px;
        /* background-color: #fff; */
        max-width: 550px;
        border-radius: 3px;
    }

    #sidebarMenu .toggle-btn {
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

    #sidebarMenu .toggle-btn.active {
        background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAmUlEQVQ4T6WT0RWDMAhFeZs4ipu0mawZpaO4yevBc6hUIWLNd+4NeQDk5sE/PMkZwFvZywKSTxF5iUgH0C4JHGyF97IggFVSqyCFga0CvQSg70Mdwd8QSSr4sGBMcgavAgdvwQCtApvA2uKr1x7Pu++06ItrF5LXPB/CP4M0kKTwYRIDyRAOR9lJTuF0F0hOAJbKopVHOZN9ACS0UgowIx8ZAAAAAElFTkSuQmCC") no-repeat 10px center #2ecc71;
    }

    #sidebarMenu .toggle-btn.active .round-btn {
        left: 45px;
    }

    #sidebarMenu .toggle-btn .round-btn {
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

    #sidebarMenu .toggle-btn .cb-value {
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

    #sidebarMenu .subtaskimage {
        height: 30px;
        width: 30px;
        border-radius: 50%;
        border: 2px solid #eee;
    }

    #sidebarMenu .slick {
        display: none;
    }

    #sidebarMenu .subtaskimage {
        height: 30px;
        width: 30px;
        border-radius: 50%;
        border: 2px solid #eee;
    }

    #sidebarMenu #select55 {
        width: 100%;
    }
    #sidebarMenu .tested
    {
        margin-left: 10px;
    }
    #sidebarMenu .select2-container--default .select2-selection--single {
        border: 1px solid #eee !important;
        font-size: 13px;
        margin-bottom: 5px;
    }

    #sidebarMenu #selectator_select55 {
        width: 100% !important;
        min-height: 30px !important;
        position: relative;
        margin-bottom: 25px;
    }

    #sidebarMenu .tagname {
        font-size: 11px;
        background-color: #eee;
        border-radius: 5px;
        padding: 3px;
        margin-right: 3px;
    }
    #sidebarMenu .tagname i{
        color: #013c60;
    }

    #sidebarMenu .subtask_dropdown {
        font-size: 17px;
    }

    #sidebarMenu .subtask_dropdown::after {
        display: none;
        display: none;
    }

    #sidebarMenu .subtask_dropdown:hover {
        color: #70baff;
        cursor: pointer;
    }

    #sidebarMenu .custom_dropdown_subtask {
        font-size: 13px;
    }

    #sidebarMenu .custom_dropdown_subtask i {
        font-size: 13px;
        color: #cccccc;
    }

    #sidebarMenu .custom_trash {
        visibility: visible !important;
        font-size: 13px !important;;
    }

    #sidebarMenu .custom_trash:hover {
        color: #e74c3c !important;
    }

    #sidebarMenu .btn-copy {
        visibility: visible !important;
        font-size: 13px !important;
        padding: 4px;
    }

    #sidebarMenu  .btn-copy:hover {
        color: #485eff !important;
    }
    .textsheck
    {
        margin-left: 5px ;
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
    @keyframes rotaion {
        0%
        {
            transform: rotate(360deg );
        }
        100%
        {
            transform: rotate(0deg);
        }
    }

    #sidebarMenu  .relodebutton
    {
        background-color: transparent;
        color: #00233a;
        font-size: 20px;
        font-weight: bold;
        border: 0;
        padding: 0px;
        font-size: 18px;
        font-weight: bold;
        margin-top: -7px;
        border-radius: 50%;
        height: 24px;
        width: 24px;

    }
    #sidebarMenu .relodebutton:hover
    {
        border-radius: 50%;
    }
    #sidebarMenu .relodebutton:hover .bi-arrow-clockwise::before
    {
        animation: rotaion 1s linear  infinite;
    }

    #sidebarMenu .ms-dd-header{
        min-height: 40px !important;
        text-align: right;
    }

    #sidebarMenu .ms-dd .ms-list-option.option-selected, .ms-dd .ms-optgroup ul .ms-list-option.option-selected
    {
        background-color: transparent !important ;
        border: 0 ;
    }
    #sidebarMenu .ms-dd .ms-dd-header
    {
        border: 0 ;
    }
    #sidebarMenu .ms-dd .ms-value-input
    {
        display: none;
    }
    #sidebarMenu  .ms-dd .ms-dd-arrow
    {
        height: 0;
        margin-top: -6px;
        position: absolute;
        right: 0px;
        top: 50%;
        width: 0;
    }
    #sidebarMenu  .ms-options
    {
        height: 200px ;
    }
    .sub_tasks3 .dd-select
    {
        background-color: transparent !important;
        height: 28px !important; ;
        border-radius: 50% !important;
        border: 0 !important;
        width: 100px !important;
        float: right;
    }
    .sub_tasks3 .desc{
        max-width: 62%;
    }
    .sub_tasks3  .dd-selected
    {
        height: 45px ;
    }
    .sub_tasks3 .dd-option-image, .dd-selected-image
    {
        height: 28px !important; ;
        border-radius: 50% !important;
    }
    .sub_tasks3 .dd-option
    {
        padding: 0 !important;
    }
    .sub_tasks3 .dd-options
    {
        width: 129px !important;
        height: 200px !important;
    }
    .sub_tasks3 .desc{
        width:100% !important ;
    }
    .sub_tasks3  .ui-datepicker-trigger
    {
        margin-top: -50px !important ;
    }
    .sub_tasks3 .dd-pointer-down
    {
        display: block !important;
        right: 0px !important ;
        top: 79% !important;
    }
    .subtasks_users
    {
        visibility: hidden ;
    }
    .tested
    {
        color: #eb6028;
    }
    /*Start  Comments Style */

    /** ====================
 * Lista de Comentarios
 =======================*/
    .comments-container {
        width: 100%;
    }

    .comments-container h1 {
        font-size: 36px;
        color: #283035;
        font-weight: 400;
    }

    .comments-container h1 a {
        font-size: 18px;
        font-weight: 700;
    }

    .comments-list {
        position: relative;
        padding: 0 ;
    }

    /**
     * Lineas / Detalles
     -----------------------*/
    .comments-list:before {
        content: '';
        width: 2px;
        height: 100%;
        background: #c7cacb;
        position: absolute;
        left: 16px;
        top: 0;
    }

    .comments-list:after {
        content: '';
        position: absolute;
        background: #c7cacb;
        bottom: 0;
        left: 27px;
        width: 7px;
        height: 7px;
        border: 3px solid #dee1e3;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
    }

    .reply-list:before, .reply-list:after {display: none;}
    .reply-list li:before {
        content: '';
        width: 67px;
        height: 2px;
        background: #c7cacb;
        position: absolute;
        top: 25px;
        left: -70px;
    }


    .comments-list li {
        margin-bottom: 15px;
        display: block;
        position: relative;
    }

    .comments-list li:after {
        content: '';
        display: block;
        clear: both;
        height: 0;
        width: 0;
    }

    .reply-list {
        padding-left: 88px;
        clear: both;
        margin-top: 15px;
        display: none;
    }
    .reply-list .comment-box
    {
        width: 83% !important;
    }
    /**
     * Avatar
     ---------------------------*/
    .comments-list .comment-avatar {
        width: 35px;
        height: 35px;
        position: relative;
        z-index: 99;
        float: left;
        border: 3px solid #FFF;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: 0 1px 2px rgb(0 0 0 / 20%);
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,0.2);
        box-shadow: 0 1px 2px rgb(0 0 0 / 20%);
        overflow: hidden;
    }

    .comments-list .comment-avatar img {
        width: 100%;
        height: 100%;
    }

    .reply-list .comment-avatar {
        width: 35px;
        height: 35px;
    }
    .comment-main-level
    {
        margin-bottom: 15px;
    }
    .comment-main-level:after {
        content: '';
        width: 0;
        height: 0;
        display: block;
        clear: both;
    }
    .replay_tags
    {
        width: 100%;
        margin-top: -5px;
    }
    /**
     * Caja del Comentario
     ---------------------------*/
    .comments-list .comment-box {
        width: 85%;
        float: left;
        margin-left: 16px;
        position: relative;
        -webkit-box-shadow: 0 1px 1px rgb(0 0 0 / 15%);
        -moz-box-shadow: 0 1px 1px rgba(0,0,0,0.15);
        box-shadow: 0 1px 1px rgb(0 0 0 / 15%);
        padding-bottom: 13px;
    }
    .comments-list .comment-box p{
        font-size: 11px;
        font-weight: 500;
    }
    .comments-list .comment-box:before, .comments-list .comment-box:after {
        content: '';
        height: 0;
        width: 0;
        position: absolute;
        display: block;
        border-width: 10px 12px 10px 0;
        border-style: solid;
        border-color: transparent #FCFCFC;
        top: 8px;
        left: -11px;
    }

    .comments-list .comment-box:before {
        border-width: 11px 13px 11px 0;
        border-color: transparent rgba(0,0,0,0.05);
        left: -12px;
    }

    .reply-list .comment-box .comment-content{
        font-size: 10px;
        padding: 5px;
        margin-bottom: 20px;
    }
    .comment-box .comment-head {
        /* background: #FCFCFC; */
        padding: 4px 5px;
        border-bottom: 1px solid #E5E5E5;
        overflow: hidden;
        -webkit-border-radius: 4px 4px 0 0;
        -moz-border-radius: 4px 4px 0 0;
        border-radius: 4px 4px 0 0;
    }

    .comment-box .comment-head i {
        float: right;
        margin-left: 14px;
        position: relative;
        top: 2px;
        color: #A6A6A6;
        cursor: pointer;
        -webkit-transition: color 0.3s ease;
        -o-transition: color 0.3s ease;
        transition: color 0.3s ease;
    }

    .comment-box .comment-head i:hover {
        color: #03658c;
    }

    .comment-box .comment-name {
        color: #283035;
        font-size: 14px;
        font-weight: 700;
        float: left;
        margin-right: 10px;
    }

    .comment-box .comment-name a {
        color: #283035;
        font-size: 12px ;
    }

    .comment-box .comment-head span {
        float: left;
        color: #999;
        font-size: 11px;
        position: relative;
        top: 1px;
    }

    .comment-box .comment-content {
        padding: 12px;
        font-size: 15px;
        color: #595959;
        -webkit-border-radius: 0 0 4px 4px;
        -moz-border-radius: 0 0 4px 4px;
        border-radius: 0 0 4px 4px;
        background-color: none  !important;
    }

    .comment-box .comment-name.by-author, .comment-box .comment-name.by-author a {color: #03658c;}
    .comment-box .comment-name.by-author:after {
        content: 'Author';
        background: #03658c;
        color: #FFF;
        font-size: 10px;
        padding: 3px 5px;
        font-weight: 700;
        margin-left: 10px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
    .replaystyle
    {
        width: 100%;
        margin-left: 23px;
        font-size: 11px;
    }
    .send_replay
    {
        padding: 2px 12px;
        font-size: 16px;
        background-color: #03658c;
        float: left;
        border: 0;
        margin-top: 10px;
        margin-top: 1px;
        padding: 5px 16px;
        margin-bottom: 17px;
    }
    .replayes_count
    {
        float: left;
        margin-left: 49px;
        font-size: 10px;
        margin-top: 7px;
        font-weight: 500;
        color: #03658c;
        /* border-bottom: 1px solid #03658c; */
        /* border: 1px solid #eee; */
        padding: 4px;
    }
    .replayes_count p
    {
        margin-bottom: 5px ;
    }
    .replayes_count p span
    {
        background-color: #ec6630;
        color: #fff;
        border-radius: 4px;
        padding: 5px;
        font-size: 8px;
        height: 25px;
    }
    .replayes_count p:hover
    {
        color:  #ec6630;
        cursor: pointer;
    }
    .replaynewcomment
    {
        float: right;
        font-size: 13px;
        color: #03658c;
        font-weight: bold;
    }
    .replaynewcomment:hover
    {
        cursor: pointer;

    }
    #commentbox {
        font-size: 13px !important;
        margin-left: 32px;
    }
    .tags_footer
    {
        margin-top:10px ;
    }
    .tags_footer .tagname
    {
        color: #017ac7;
        font-size: 11px;
        margin-bottom: 5px ;
    }
    .destorybutton
    {
        display: none;
    }
    /** =====================
     * Responsive
     ========================*/
    @media only screen and (max-width: 766px) {
        .comments-container {
            width: 480px;
        }

        .comments-list .comment-box {
            width: 390px;
        }

        .reply-list .comment-box {
            width: 320px;
        }
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
                                <lable class="control-label">{{__('messages.responsible')}}</lable>
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

                        <div class="row">
                            <div class="col-md-2">
                                <lable class="control-label">{{__('messages.team_members')}}</lable>
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
                                                    useSearch: true,
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
                                                    useSearch: true,
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

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <lable class="control-label">{{__('messages.dead_line')}}</lable>
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
                                    <lable class="control-label">{{__('messages.department')}}</lable>
                                </div>
                                <div class="col-md-7">

                                    <select name="task_category_id"
                                            class="custom-select form-control target Fachbereich"
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
                                    <lable class="control-label">{{__('messages.department')}}2</lable>
                                </div>
                                <div class="col-md-7">

                                    <select name="task_category_id_two" class="custom-select form-control target Fachbereich2"  data-name="task_category_id_two">
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
                                    <lablel class="control-label">{{__('messages.under_category')}}</lable>
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
                                    <lable class="control-label">{{__('messages.desc')}}</lable>
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
                            <div class="col-md-2">
                                <i class="bi bi-calendar2-plus"></i> {{__('messages.subtasks')}}
                            </div>
                            <div class="col-md-3">
                                <div class="uncompleted_count">{{$task->subtasks->count() - $task->completed_subtasks->count() }}</div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input cb-value " type="checkbox">
                                </div>
                                <div class="completed_count">{{$task->completed_subtasks->count()}} / <span class="tested">{{$task->testedtasks->count()}}</span> </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm btn-primary relodebutton" onclick="rebuild_popup({{$task->id}})">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="sub_tasks2">
                            <div class="sub_tasks_header">

                            </div>

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
                                                                        class="bi bi-trash "></i> {{__('messages.delete')}}</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item btn-copy copy_task"
                                                               data-id="{{$subtask->id}}"
                                                               href="#"><i class="bi bi-file-break-fill"></i>
                                                                {{__('messages.copy')}}</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item btn-copy cut_task"
                                                               data-id="{{$subtask->id}}"
                                                               href="#"><i class="bi bi-file-break-fill"></i>
                                                                {{__('messages.cut')}}</a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item btn-copy post_task"
                                                               data-id="{{$subtask->id}}"
                                                               href="#"><i class="bi bi-file-break-fill"></i>
                                                                Post-it</a>
                                                        </li>
                                                    </ul>

                                                    @if(!empty($subtask->added_by->image))
                                                        <img
                                                                src="https://pri-po.com/public/assets/images/users/{{$subtask->added_by->image}}"
                                                                class="subtaskimage"/>
                                                    @endif

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
                                                            <label>
                                                                @if(  !empty($subtask->subtask_due_date) &&  date('d.m.Y', strtotime($subtask->subtask_due_date)) !='01.01.1970' )
                                                                    <script>
                                                                        $(document).ready(function(){
                                                                            $("#subtask{{$subtask->id}} .ui-datepicker-trigger").css('visibility', 'hidden');
                                                                        });
                                                                    </script>
                                                                    <p class="date_text">  {{date('d.m.Y', strtotime($subtask->subtask_due_date))}}</p>

                                                                @else
                                                                    <script>
                                                                        $(document).ready(function(){
                                                                            $("#subtask{{$subtask->id}} .ui-datepicker-trigger").css('visibility', 'visible');
                                                                        });
                                                                    </script>
                                                                @endif

                                                            </label>
                                                            <input type="hidden" class="hiddenInput date dte"
                                                                   data-id="{{$subtask->id}}"
                                                                   value="{{$subtask->subtask_due_date}}"/>

                                                        </div>
                                                    </div>

                                                    <!--New Select Box -->
                                                    <select style="" name="TaskResponsiple" class="subtasks_users" is="ms-dropdown"  data-enable-auto-filter="true"  data-id="{{$subtask->id}}">
                                                        <option > Select </option>
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}"  data-image="{{asset('public/assets/images/users/'.$user->image)}}"
                                                                    @if($subtask->subtask_user_id == $user->id ) selected="selected" @endif

                                                            >{{$user->user_name}}</option>
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
                                        <input class="new-task" contenteditable="true" placeholder="{{__('messages.subtasks')}}">
                                    </li>
                                    <li class="bottom"></li>
                                </ul>
                            </div>

                        </div>
                    </div>

                    <!-- Start Completed Tasks -->
                    <div class="col-md-10">
                        <div class="sub_tasks3" style="display:none;">

                            <div class="container">
                                <ul class="todo box-shadow">
                                    <li class="title">
                                        <span class="percentage"></span>
                                    </li>
                                    <div class="task-container" id="shuffle2">
                                        @if(!empty($task->completed_subtasks))
                                            @foreach($task->completed_subtasks as $subtask)

                                                <li @if($subtask->subtask_status != 0)

                                                    class="task  ui-state-default completed"

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
                                                        <li><a class="dropdown-item btn-copy copy_task"
                                                               data-id="{{$subtask->id}}"
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


                                                    <input class="taskched change_status" data-id="{{$subtask->id}}" type="checkbox" @if($subtask->subtask_status != 0) checked @else  ' '  @endif>
                                                    <input class="textsheck " data-id="{{$subtask->id}}" type="checkbox" {{($subtask->tested)?'checked':''}} >
                                                    <span @if($subtask->tested === 1) style="color: #eb6028 !important;"   @endif  class="description desc" data-id="{{$subtask->id}}"
                                                          contenteditable="true">{!!$subtask->subtask_title!!}</span>
                                                <!-- <input type="date" class="date dte" data-id="{{$subtask->id}}" value="{{$subtask->subtask_due_date}}"> -->


                                                    <div class="test">
                                                        <div class="calender">
                                                            <label>@if(  !empty($subtask->subtask_due_date) &&  date('d.m.Y', strtotime($subtask->subtask_due_date)) !='01.01.1970' )

                                                                    <p class="date_text">  {{date('d.m.Y', strtotime($subtask->subtask_due_date))}}</p>
                                                                    <script>
                                                                        $(document).ready(function() {
                                                                            $("#subtask{{$subtask->id}} .ui-datepicker-trigger").css('visibility', 'hidden');
                                                                        });
                                                                    </script>
                                                                @else
                                                                    <script>
                                                                        $(document).ready(function() {
                                                                            $("#subtask{{$subtask->id}} .ui-datepicker-trigger").css('visibility', 'visible');
                                                                        });
                                                                    </script>
                                                                @endif

                                                            </label>
                                                            <input type="hidden" class="hiddenInput date dte"
                                                                   data-id="{{$subtask->id}}"
                                                                   value="{{$subtask->subtask_due_date}}"/>

                                                        </div>
                                                    </div>


                                                    <select class="slick{{$subtask->id}} task_resp" is="ms-dropdown"  data-enable-auto-filter="true"  data-id="{{$subtask->id}}"
                                                            name="TaskResponsiple"
                                                            style="height: 30px ; width:89px !important; " data-enable-auto-filter="true"
                                                    >
                                                        <option
                                                                data-imagesrc="{{asset('public/assets/images/person.png')}}"></option>
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}"

                                                                    data-imagesrc="{{asset('public/assets/images/users/'.$user->image)}}"
                                                                    @if($subtask->subtask_user_id == $user->id ) selected="selected" @endif> {{$user->user_name}}</option>
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
                        <!--Tags  -->
                        <div class="row">
                            <div class="col-md-2 text-center">
                                <lable class="control-label taglabel"> {{__('messages.notice')}} <i
                                            class="bi bi-people-fill"></i></lable>
                            </div>
                            <div class="col-md-7">
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

                                            } else {
                                                $select55.selectator('destroy');
                                                $activate_selectator55.val('activate55');

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
                        <!--End Tags-->


                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-md-9">
                                <textarea id="commentbox" rows="5" class="form-control" placeholder="{{__('messages.enter_comment')}}..."></textarea>
                                <div id="commentoutput" style="display: none"></div>
                                <button type="button" id="add_comment" class="send-comment send-comment2 pull-right"><i
                                            class="fas fa-paper-plane"></i></button>
                            </div>
                        </div>

                        <div class="col-md-10">
                            <div class="comments2">
                                @foreach($task->comments as $comment)
                                    <div class="comments-container">
                                        <ul id="comments-list" class="comments-list{{$comment->id}} comments-list" data-author="{{$comment->comment_added_by}}">
                                            <li>
                                                <div class="comment-main-level">
                                                    <!-- Avatar -->
                                                    <div class="comment-avatar">
                                                        <img src="{{asset('public/assets/images/users/'.$comment->user->image)}}" alt="test" />
                                                    </div>
                                                    <!-- Contenedor del Comentario -->
                                                    <div class="comment-box">
                                                        <div class="comment-head">
                                                            <h6 class="comment-name by-author"><a href="{{asset('public/assets/images/users/'.$comment->user->image)}}">{{ $comment->user->user_name }}</a></h6>
                                                            <span> {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans()}} </span>
                                                            <div class="comment_header_control">
                                                                @if(auth()->user()->role != 1 && auth()->user()->id  == $comment->comment_added_by )
                                                                    <i class="fa fa-edit edit_comment" data-id="{{$comment->id}}"></i>
                                                                    <i class="fa fa-trash del_comment" data-id="{{$comment->id}}"></i>
                                                                @endif
                                                                @if(auth()->user()->role == 1 )
                                                                    <i class="fa fa-edit edit_comment" data-id="{{$comment->id}}"></i>
                                                                    <i class="fa fa-trash del_comment" data-id="{{$comment->id}}"></i>
                                                                @endif
                                                            </div>


                                                        </div>
                                                        <div class="comment-content">
                                                            @if(!empty($comment->comment))
                                                                <p contenteditable="false" id="comment_name{{$comment->id}}"
                                                                   data-id="{{$comment->id}}"
                                                                   class="comment-content"> {!!$comment->comment!!}</p>
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



                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="replayes_count{{$comment->id}} replayes_count" data-list="{{$comment->id}}" data-id="{{$comment->comment_added_by}}"><p><span>{{$comment->replays->count()}}</span> Antwortet </p> </div>
                                                <div class="add_replay" data-id="{{$comment->id}}"> <i class="bi bi-plus"></i>  Antwort hinzufügen
                                                </div>

                                                <ul class="comments-list reply-list{{$comment->id}} reply-list commentautor" >
                                                    @foreach($comment->replays as $replay)
                                                        <li>
                                                            <!-- Avatar -->
                                                            <div class="comment-avatar">
                                                                @if(isset($replay->user->image))
                                                                    <img src="{{asset('public/assets/images/users/'.$replay->user->image)}}" alt="">
                                                                @endif
                                                            </div>
                                                            <!-- Contenedor del Comentario -->
                                                            <div class="comment-box comment-box{{$replay->id}}" >
                                                                <div class="comment-head">
                                                                    <h6 class="comment-name"><a href="{{asset('public/assets/images/users/'.$replay->user->image)}}">{{$replay->user->user_name}}</a></h6>
                                                                    <span>{{ \Carbon\Carbon::parse($replay->created_at)->diffForHumans()}}</span>
                                                                    <div class="controls">
                                                                        <span class="delete-replay    delete-replay{{$replay->id}}" data-id="{{$replay->id}}"><i class="fa fa-trash"></i></span>
                                                                        <span class="edit-replay "><i class="fa fa-edit"></i></span>
                                                                    </div>
                                                                </div>
                                                                <div class="comment-content">
                                                                    {{$replay->replay}}
                                                                    <div class="tags_footer">
                                                                        @php
                                                                            if(!empty($replay->tags)) {

                                                                               $readusers =  json_decode($replay->is_read) ;

                                                                                   $tags = explode(',', $replay->tags);

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

                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </li>

                                                    @endforeach
                                                </ul>

                                            </li>
                                        </ul>
                                        <div class="add_new_replay  add_new_replay{{$comment->id}}">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <textarea rows="2" class="replay_comment{{$comment->id}} form-control replaystyle" placeholder="hat dein Kommentar beantwortet ... "></textarea>
                                                    <div id="commentoutput{{$comment->id}}"></div>
                                                    <!--Replay Tags -->
                                                    <script type="text/javascript">
                                                        $(function () {
                                                            var $activate_selectator{{$comment->id}} = $('#activate_selectator{{$comment->id}}');

                                                            $activate_selectator{{$comment->id}}.click(function () {
                                                                var $select{{$comment->id}} = $('#select{{$comment->id}}');

                                                                if ($select{{$comment->id}}.data('selectator') === undefined) {
                                                                    $select{{$comment->id}}.selectator({
                                                                        showAllOptionsOnFocus: true,
                                                                        useDimmer: true,
                                                                        searchFields: 'value text subtitle right'
                                                                    });
                                                                    $activate_selectator{{$comment->id}}.val('destroy');
                                                                } else {
                                                                    $select{{$comment->id}}.selectator('destroy');
                                                                    $activate_selectator{{$comment->id}}.val('activate{{$comment->id}}');

                                                                }

                                                            });
                                                            $activate_selectator{{$comment->id}}.trigger('click');

                                                        });
                                                    </script>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="select{{$comment->id}}" name="tags[]" class="target replay_tags" multiple data-name="tags[]" style="width: 100%; height: 50px !important;  " data-id="{{$comment->id}}">
                                                        @php
                                                            $users_gests = \App\Models\User::get();
                                                        @endphp
                                                        @foreach($users_gests as $user)
                                                            <option id="{{$user->id}}" value="{{$user->id}}"
                                                                    data-left="{{asset('public/assets/images/users/'.$user->image)}}"> {{$user->first_name}}</option>
                                                        @endforeach
                                                    </select>

                                                    <input value="activate{{$comment->id}}" id="activate_selectator{{$comment->id}}" type="hidden">
                                                </div>
                                                <div class="col-md-2">
                                                    <!--End Replay Tags -->
                                                    <button type="button"  class="btn btn-primary send_replay" data-id="{{$comment->id}}" ><i class="bi bi-reply"></i></button>
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
                                <span class="filupp-file-name js-value">{{__('messages.upload_photo')}} <i class="fa fa-file"></i>  </span>
                                <input type="file" name="comment_image" id="custom-file-upload"/>
                            </label>
                            <button type="submit"
                                    style="background-color:#3bebff;color:#fff;padding:8px;border-radius:5px;"
                                    class="submit_comment">{{__('messages.upload_photo')}}</button>
                        </form>
                    </div>
                    <div class="col-md-5">
                        <div class="action_buttons">
                            @if($task->task_status == 0 || $task->task_status == 1)
                                <button class="remove-task btnn-remove btn btn-danger"><i class="fa fa-trash"></i> {{__('messages.delete')}}
                                </button>
                            @else
                                <button class="unremove-task  btnn-remove btn btn-danger"><i class="fa fa-trash"></i>
                                    {{__('messages.restore')}}
                                </button>
                            @endif

                            @if($task->task_status == 0 || $task->task_status == 2)
                                <button class="complete_task btn-complete btn btn-success"><i
                                            class="fa fa-check-circle"></i> {{__('messages.mark_complete')}}
                                </button>
                            @else
                                <button class="uncomplete_task btn-complete btn btn-success"><i
                                            class="fa fa-check-circle"></i> {{__('messages.mark_un_complete')}}
                            @endif
                        </div>
                    </div>

                    <script>
                        $(document).ready(function(){
                            $('.replayes_count').each(function () {
                                $(this).on('click' , function (){

                                    var list_id  = $(this).data('list') ;

                                    $('.reply-list'+list_id).toggle();

                                });
                            }) ;

                        });
                    </script>
                    <script>
                        // In your Javascript (external .js resource or <script> tag)
                        $(document).ready(function () {
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

                            $('.copy_task').click(function () {

                                const id = $(this).data('id');
                                $(document).on('change', '#categories_select', function () {

                                    const cat_id = $('#categories_select').val();
                                    $.ajax({
                                        type: "POST",
                                        url: '{{route('categories.ajax')}}',   // need to create this post route
                                        cache: false,
                                        data: {id: id, cat_id: cat_id, _token: '{{csrf_token()}}'},
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
                                    data: {id: id, _token: '{{csrf_token()}}'},
                                    success: function (data) {
                                        $('#copy_subtask_modal_body').html(data.html);
                                        $('#copy_subtask_modal').modal('show');
                                    },
                                    error: function (jqXHR, status, err) {
                                    },
                                });

                            });

                            $('.post_task').click(async function () {
                                const id = $(this).data('id');
                                const inputOptions = new Promise((resolve) => {
                                    setTimeout(() => {
                                        resolve({
                                            'pd': 'Post-it & delete',
                                            'ponly': 'Post-it Only',
                                        })
                                    }, 200)
                                })

                                const {value: color} = await Swal.fire({
                                    title: 'Sind Sie sicher, dass Sie es posten möchten?',
                                    icon: 'warning',
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
                                    let subtask_delete = false;
                                    if (color == 'pd') {
                                        subtask_delete = true;
                                    }
                                    if (color == 'ponly') {
                                        subtask_delete = false;
                                    }

                                    $.ajax({
                                        type: "POST",
                                        url: '{{route('categories.ajax.post')}}',   // need to create this post route
                                        cache: false,
                                        data: {id: id, subtask_delete},
                                        success: function (data) {
                                            if (data.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: `${data.success}`,
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                })
                                            }
                                        },
                                        error: function (jqXHR, status, err) {

                                            if (err.error) {
                                                swal(`${err.error}`, {
                                                    icon: "error",

                                                });
                                            }
                                        },
                                    });

                                }


                            });

                            $('.cut_task').click(function () {

                                const id = $(this).data('id');
                                $(document).on('change', '#categories_select', function () {
                                    const cat_id = $('#categories_select').val();
                                    $.ajax({
                                        type: "POST",
                                        url: '{{route('categories.ajax.cut')}}',   // need to create this post route
                                        cache: false,
                                        data: {id: id, cat_id: cat_id},
                                        success: function (data) {

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
                                    data: {id: id},
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

                        function rebuild_popup(id) {

                            var type = '1';
                            $.ajax({
                                type: "post",
                                url: "{{route('admin.get.task_data')}}", // need to create this post route
                                data: {id: id, type: type, _token: '{{ csrf_token() }}'},
                                cache: false,
                                success: function (data) {
                                    $('#tasks').modal('show');
                                    $('.overlay').css('display', 'block');
                                    $(".sidebar-model").html(data);
                                    $(".sidebar-model").css({'width': '50%'});
                                    /*Start  Plugin */


                                }
                            });
                        }

                        $(".subtasks_users").each(function () {
                            $(this).on('change', function () {

                                resp_val = $(this).val();
                                subtask_id = $(this).data('id') ;
                                $.ajax({
                                    type: "POST",
                                    url: '{{route('admin.subtasks.updatefielddd')}}', // need to create this post route
                                    data: {
                                        subtask_id: subtask_id,
                                        resp_val: resp_val,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    cache: false,
                                    success: function (data) {
                                    },
                                    error: function (jqXHR, status, err) {
                                    },
                                });

                            });
                        });




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
                        $(document).ready(function () {
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

                                // Test Responsible





                                let responsiple = document.createElement("select");
                                responsiple.setAttribute('data-id', (xx + ic));
                                responsiple.setAttribute('is', 'ms-dropdown');
                                responsiple.setAttribute('data-enable-auto-filter', 'true');
                                responsiple.className = "subtasks_users";
                                responsiple.name = "TaskResponsiple";



                                let users2 = new Array();
                                users2.push("<?php  echo " <option> Select </option>"?>");
                                <?php
                                $url = url('/');
                                $ld = $last_subtask_id + $SD;
                                foreach($users as $user){ ?>
                                users2.push("<?php  echo "<option value='$user->id' data-description='$ld'   data-image= '$url/public/assets/images/users/$user->image'> $user->user_name</option>" ?>");
                                <?php } ?>
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


                                task.appendChild(deleteicones);
                                task.appendChild(dropdown);
                                task.appendChild(dragBtn);
                                task.appendChild(checkBox);
                                task.appendChild(descr);
                                task.appendChild(date);
                                task.appendChild(responsiple);
                                task.appendChild(resinput);

                                new MsDropdown('.subtasks_users');



                                $(".subtasks_users").each(function () {
                                    $(this).on('change', function () {

                                        resp_val = $(this).val();
                                        subtask_id = $(this).data('id') ;
                                        $.ajax({
                                            type: "POST",
                                            url: '{{route('admin.subtasks.updatefielddd')}}', // need to create this post route
                                            data: {
                                                subtask_id: subtask_id,
                                                resp_val: resp_val,
                                                _token: '{{ csrf_token() }}'
                                            },
                                            cache: false,
                                            success: function (data) {
                                            },
                                            error: function (jqXHR, status, err) {
                                            },
                                        });
                                    });
                                });



















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
                                                data: {
                                                    subtask_id: subtask_id,
                                                    date_val: date_val,
                                                    _token: '{{ csrf_token() }}'
                                                },
                                                cache: false,
                                                success: function (data) {

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

                                    onSelect: function (selectedData) {
                                        let xxx = task.children[POS_CHECKBOX].getAttribute('data-id');
                                        let resp_val = selectedData.selectedData.value;
                                        let subtask_id = xxx - 1;
                                        $.ajax({
                                            type: "POST",
                                            url: '{{route('admin.subtasks.updatefielddd')}}', // need to create this post route
                                            data: {subtask_id: subtask_id, resp_val: resp_val, _token: '{{ csrf_token() }}'},
                                            cache: false,
                                            success: function (data) {
                                                if (data.success) {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: `${data.success}`,
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    })
                                                }
                                            },
                                            error: function (jqXHR, status, err) {
                                            },
                                        });


                                    }

                                });

                                $('.dd-click-off-close').css('display', 'none');


                                ic++;
                                xv++;

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
                        })
                    </script>


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



        let wrapper = document.querySelector('.wrapper');
        let newtodo = document.querySelector('.todo_name');
        let todo_date = document.querySelector('.todo_date');
        let todo_responsible = document.querySelector('.todo_responsible');
        let addtodo = document.querySelector('.add_todo');
        let todo = [];


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



        $("#add_comment").on('click', function () {

            $('#commentoutput').html($('#commentbox').val().replace(/\n/g, "<br>"));
            var comment = $('#commentoutput').html() ;
            var task_id = $("#task_id").val();
            var tags = $("#select55").val();
            var tagstring = tags.toString();

            $.ajax({
                type: "post",
                url: "{{route('admin.subtasks.store_comment')}}", // need to create this post route
                data: {comment: comment, tags: tagstring, task_id: task_id, _token: '{{ csrf_token() }}'},
                cache: false,
                success: function (data) {
                    /* swal(" Successfuly!", " Comment Added Successfuly ! ", "success");*/

                    var comments_container = document.createElement('div') ;
                    comments_container.className = "comments-container" ;

                    var comments_list = document.createElement('div') ;
                    comments_list.setAttribute('id' ,"comments_list") ;
                    comments_list.className = "comments-list"+data['last_comment_id']+"  comments-list" ;
                    comments_list.setAttribute('data-author' ,data['comment_author']) ;



                    comments_container.appendChild(comments_list) ;


                    var liel = document.createElement('li') ;
                    comments_list.appendChild(liel) ;


                    var comment_main_level  =  document.createElement('div') ;
                    comment_main_level.className = "comment-main-level" ;
                    liel.appendChild(comment_main_level) ;



                    var comment_avatar =  document.createElement('div') ;
                    comment_avatar.className = "comment-avatar" ;
                    comment_main_level.appendChild(comment_avatar) ;



                    var commimage  =  document.createElement('img') ;
                    commimage.setAttribute('src' ,"{{asset('public/assets/images/users/'.auth::user()->image)}}") ;
                    comment_avatar.appendChild(commimage);




                    var comment_box =  document.createElement('div') ;
                    comment_box.className = "comment-box" ;
                    comment_main_level.appendChild(comment_box) ;



                    var comment_head =  document.createElement('div') ;
                    comment_head.className = "comment-head" ;
                    comment_box.appendChild(comment_head) ;



                    var comment_name =  document.createElement('h6') ;
                    comment_name.className = "comment-name by-author" ;
                    comment_head.appendChild(comment_name) ;



                    var hyperlink  =  document.createElement('a') ;
                    hyperlink.innerText = "{{auth::user()->first_name}}" ;
                    comment_name.appendChild(hyperlink) ;





                    var commentspan  =  document.createElement('span') ;
                    commentspan.innerText = "Now" ;
                    comment_head.appendChild(commentspan) ;








                    var comment_content =  document.createElement('div') ;
                    comment_content.className = "comment-content" ;
                    comment_box.appendChild(comment_content) ;



                    var comment_p =  document.createElement('p') ;
                    comment_p.setAttribute('contenteditable' ,"false") ;
                    comment_p.setAttribute('id' ,"comment_name") ;
                    comment_content.className = "comment-content" ;
                    comment_p.setAttribute('data-id' , data['last_comment_id']) ;
                    comment_p.innerText = $('#commentbox').val() ;


                    comment_content.appendChild(comment_p) ;





                    var icon1  =  document.createElement('i') ;
                    icon1.className = "fa fa-edit edit_comment" ;
                    icon1.setAttribute('data-id' , data['last_comment_id']) ;

                    var icon2  =  document.createElement('i') ;
                    icon2.className = "fa fa-trash del_comment" ;
                    icon2.setAttribute('data-id' , data['last_comment_id']) ;


                    comment_content.appendChild(icon1) ;
                    comment_content.appendChild(icon2) ;



                    var comments_list =  document.createElement('ul') ;
                    comments_list.className = "comments-list reply-list"+data['last_comment_id']+" reply-list" ;
                    liel.appendChild(comments_list) ;



                    var rows =  document.createElement('div') ;
                    rows.className = "row" ;
                    liel.appendChild(rows) ;


                    var cols =  document.createElement('div') ;
                    cols.className = "col-md-7" ;
                    rows.appendChild(cols) ;


                    var replayinput =  document.createElement('input') ;
                    replayinput.className = "replay_comment"+data['last_comment_id']+" form-control replaystyle" ;
                    replayinput.setAttribute('type' ,'text ');
                    replayinput.setAttribute('placeholder' ,'Write Your Replay ...  ');

                    cols.appendChild(replayinput) ;


                    var cols2 =  document.createElement('div') ;
                    cols2.className = "col-md-3" ;

                    var selecttags = document.createElement('select') ;
                    selecttags.setAttribute('id' , 'select'+data['last_comment_id']);
                    selecttags.setAttribute('name' , 'tags[]');
                    selecttags.className="target replay_tags selectator" ;
                    selecttags.setAttribute('data-name' , 'tags[]');
                    selecttags.setAttribute("multiple", "");
                    selecttags.setAttribute('data-id' , data['last_comment_id'] );
                    cols2.appendChild(selecttags) ;

                    var activate  = document.createElement('input') ;
                    activate.className="destorybutton";
                    activate.setAttribute('value' , 'activate');
                    activate.setAttribute('id' , 'activate_selectator'+data['last_comment_id']);
                    activate.setAttribute('type' , 'button');
                    cols2.appendChild(activate) ;


                    let users2 = new Array();
                    users2.push("<?php  echo " <option> Select User </option>"?>");
                    <?php
                    $url = url('/');
                    foreach($users as $user){ ?>
                    users2.push("<?php  echo "<option value='$user->id'  id='$user->id'  data-left= '$url/public/assets/images/users/$user->image'> $user->user_name</option>" ?>");
                    <?php } ?>
                        selecttags.innerHTML = users2;




                    $(function () {
                        var $activate_selectator = $('#activate_selectator'+data['last_comment_id']);

                        $activate_selectator.click(function () {
                            var $select = $('#select'+data['last_comment_id']);

                            if ($select.data('selectator') === undefined) {
                                $select.selectator({
                                    showAllOptionsOnFocus: true,
                                    useDimmer: true,
                                    searchFields: 'value text subtitle right'
                                });
                                $activate_selectator.val('destroy');

                            } else {
                                $select.selectator('destroy');
                                $activate_selectator.val('activate55');

                            }

                        });
                        $activate_selectator.trigger('click');
                    });



                    rows.appendChild(cols2) ;

                    var cols3 =  document.createElement('div') ;
                    cols3.className = "col-md-2" ;

                    var replaybutton =  document.createElement('button') ;
                    replaybutton.className = "btn btn-primary send_replay" ;
                    replaybutton.setAttribute('type' ,'button');
                    replaybutton.setAttribute('data-id' ,data['last_comment_id']);
                    cols3.appendChild(replaybutton) ;


                    var replayicon  =  document.createElement('i') ;
                    replayicon.className = "bi bi-reply" ;

                    replaybutton.appendChild(replayicon) ;

                    rows.appendChild(cols3) ;

                    liel.appendChild(rows) ;


                    //Man Append to comments
                    $('.comments2').prepend(comments_container);
                    /*add Replay*/

                    $('.send_replay').each(function() {
                        $(this).on('click' , function (){
                            var addedby = "{{Auth::user()->first_name}}" ;
                            var comment_id =$(this).data('id') ;
                            $('#commentoutput'+comment_id).html($('.replay_comment'+comment_id).val().replace(/\n/g, "<br>"));
                            var  replay_comment = $('#commentoutput'+comment_id).html() ;
                            var task_id = $("#task_id").val();
                            var comment_author =  $('.comments-list'+comment_id).data('author') ;
                            var tagsc =  $('#select'+comment_id).val() ;
                            var tagstring = tagsc.toString();

                            $.ajax({
                                url: '{{route('admin.subtasks.store_replay')}}',
                                method: "POST",
                                data: {tags:tagstring , addedby : addedby ,comment_id : comment_id ,replay_comment : replay_comment , task_id:task_id , comment_author:comment_author , _token: '{{ csrf_token() }}'},
                                success: function (response) {

                                    var li_elem = document.createElement('li') ;

                                    var image  =  document.createElement('div') ;
                                    image.className = "comment-avatar" ;

                                    var innerimage = document.createElement('img') ;
                                    innerimage.setAttribute('src' ,"{{asset('public/assets/images/users/'.auth::user()->image)}}") ;
                                    image.appendChild(innerimage) ;



                                    var comment_box  =  document.createElement('div') ;
                                    comment_box.className = "comment-box" ;

                                    var comment_head =  document.createElement('div') ;
                                    comment_head.className = "comment-head" ;
                                    comment_box.appendChild(comment_head) ;

                                    var comment_name =  document.createElement('h6') ;
                                    comment_name.className = "comment-name" ;
                                    comment_head.appendChild(comment_name) ;

                                    var spantime  =  document.createElement('span') ;
                                    spantime.innerText = 'Now';
                                    comment_head.appendChild(spantime) ;

                                    var hyperlink  =  document.createElement('a') ;
                                    hyperlink.innerText = "{{auth::user()->first_name}}" ;
                                    comment_name.appendChild(hyperlink) ;





                                    var content  =  document.createElement('div') ;
                                    content.className = "comment-content" ;
                                    content.innerText = replay_comment ;


                                    var  tags_footer =  document.createElement('div') ;
                                    tags_footer.className="tags_footer" ;

                                    for(var i = 0 ; i < tagsc.length ; i++ ) {
                                        <?php
                                        $tagusers = \App\Models\User::where(['id'=>$user])->first() ;
                                        ?>
                                        var tag_name = document.createElement('span');
                                        tag_name.className = "tagname";
                                        tags_footer.appendChild(tag_name);
                                    }




                                    content.appendChild(tags_footer);
                                    comment_box.appendChild(content) ;
                                    li_elem.appendChild(image) ;


                                    li_elem.appendChild(comment_box) ;

                                    $('.reply-list'+comment_id).append(li_elem);

                                    $('.reply-list'+comment_id).css({'display': 'block'});



                                },
                                error:function ()
                                {
                                    /*$('.reply-list'+comment_id).append('test comment')*/
                                }

                            });


                        });
                    });


                },
                error: function (jqXHR, status, err) {
                },
            });

        });

        $('.send_replay').each(function() {
            $(this).on('click' , function (){
                var addedby = "{{Auth::user()->first_name}}" ;
                var comment_id =$(this).data('id') ;
                var  replay_comment = $('.replay_comment'+comment_id).val() ;
                var comment_author =  $('.comments-list'+comment_id).data('author') ;
                var task_id = $("#task_id").val();
                var tagsc =  $('#select'+comment_id).val() ;
                var tagstring = tagsc.toString();




                $.ajax({
                    url: '{{route('admin.subtasks.store_replay')}}',
                    method: "POST",
                    data: {tags:tagstring , addedby : addedby ,comment_id : comment_id ,replay_comment : replay_comment , task_id:task_id , comment_author :comment_author ,   _token: '{{ csrf_token() }}'},
                    success: function (response) {
                        $(".replayes_count"+comment_id+" p span").text(response);
                        var li_elem = document.createElement('li') ;
                        var image  =  document.createElement('div') ;
                        image.className = "comment-avatar" ;

                        var innerimage = document.createElement('img') ;
                        innerimage.setAttribute('src' ,"{{asset('public/assets/images/users/'.auth::user()->image)}}") ;
                        image.appendChild(innerimage) ;





                        var comment_box  =  document.createElement('div') ;
                        comment_box.className = "comment-box" ;

                        var comment_head =  document.createElement('div') ;
                        comment_head.className = "comment-head" ;
                        comment_box.appendChild(comment_head) ;

                        var comment_name =  document.createElement('h6') ;
                        comment_name.className = "comment-name" ;
                        comment_head.appendChild(comment_name) ;

                        var spantime  =  document.createElement('span') ;
                        spantime.innerText = 'Now';
                        comment_head.appendChild(spantime) ;

                        var hyperlink  =  document.createElement('a') ;
                        hyperlink.innerText = "{{auth::user()->first_name}}" ;
                        comment_name.appendChild(hyperlink) ;





                        var content  =  document.createElement('div') ;
                        content.className = "comment-content" ;
                        content.innerText = replay_comment ;

                        var  tags_footer =  document.createElement('div') ;
                        tags_footer.className="tags_footer" ;

        
                        $('#selectator_select'+comment_id+' .selectator_selected_items').children('.selectator_selected_item').each(function (){
                            var tag_name = document.createElement('span');
                            tag_name.className = "tagname";
                            tag_name.innerText = '@' + $(this).find('.selectator_selected_item_title').text();
                            tags_footer.appendChild(tag_name);
                        });


                        content.appendChild(tags_footer);
                        comment_box.appendChild(content) ;


                        li_elem.appendChild(image) ;
                        li_elem.appendChild(comment_box) ;

                        $('.reply-list'+comment_id).append(li_elem);

                        $('.reply-list'+comment_id).css({'display': 'block'});

                        var  height  =  $('.reply-list'+comment_id).height() ;
                        $('.replay_comment'+comment_id).val(' ') ;


                    },
                    error:function ()
                    {
                        /*$('.reply-list'+comment_id).append('test comment')*/
                    }

                });


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
    $(document).ready(function () {
        var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
            enableTime: true,
            dateFormat: "d.m.Y  H:i",
        });


        $('.add_replay').each(function()
        {
            $(this).on('click' , function(){
                var replay_id  =  $(this).data('id') ;

                $('.add_new_replay'+replay_id).css("display" , "block") ;

            });
        })
        /* Replay  Tags */
        $('.replay_tags').each(function (){
            $(this).on('change' , function(){
                var replay_id = $(this).data('id') ;
                var tagsc =  $(this).val() ;
                var tagstring = tagsc.toString();
                $.ajax({
                    url:'{{route('admin.comments.savetags')}}' ,
                    type:'post' ,
                    data:{replay_id: replay_id , tags: tagstring  , _token: '{{ csrf_token() }}'} ,
                    cache: false,
                    success:function (data)
                    {

                    } ,
                    error:function ()
                    {

                    }



                })
            }) ;

        });
        /*End Replays Tags*/

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

        $('.comment-content').each(function () {
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



        $('.delete-replay').each(function () {
            $(this).on("click", function () {
                var id = $(this).data('id');
                swal({
                    title: "Sind Sie sicher, dass Sie Replay löschen möchten ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: '{{route('admin.comments.delete_replay')}}',
                                method: "POST",
                                data: {_token: '{{ csrf_token() }}', id: id},
                                success: function (response) {
                                    $(".comment-box"+id).parent('li').css('display', 'none');
                                }
                            });
                            swal("Deleted!", {
                                icon: "success",
                            });

                        }

                    });

            });
        });



    });


</script>

