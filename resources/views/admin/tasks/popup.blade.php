
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
            firstDay: 1,
            buttonImageOnly: true,
            onSelect: function (selectedDate) {
                $(this).next('.ui-datepicker-trigger').css("visibility", "hidden");
                $(this).closest(".test").find('.calender label').text(selectedDate);
                let subtask_id = $(this).data("id");
                let date_val = selectedDate;

                $.ajax({
                    type: "POST",
                    url: '{{route('admin.subtasks.updatefielddd')}}', // need to create this post route
                    data: {subtask_id: subtask_id, date_val, _token: '{{ csrf_token() }}'},
                    cache: false,
                    success: function (data) {

                    },
                    error: function (jqXHR, status, err) {
                    },
                })
            },

        })

        $('.calender label').on('click', function () {
            $(this).next(".hiddenInput").datepicker("show");
        });
    })

</script>

<script src="{{asset('public/assets/admin/assets2/js/sweetalert.min.js')}}"></script>
<style>
    .task_comments_count{
        visibility: visible;
        background-color: transparent;
        color: #0d4263;
        font-size: 17px;
    }
    .custom_comments_count
    {
        visibility: hidden;
        background-color: transparent;
        color: #0d4263;
        font-size: 12px;
        border: 0 !important; ;
    }
    #drop-zone {
        border: 1px dashed;
        width: 100%;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .select-files {
        cursor: pointer;
        background: #000;
        padding: 5px;
        display: inline-block;
        color: #fff
    }

    /* images that are previewed prior to form submission*/

    .drop-zone__thumb {
        width: 100px;
        height: auto;
        display: block;
    }

    #remove-x {
        width: 1rem;
        height: 1rem;
        cursor: pointer;
    }

    #show-selected-images {
        display: flex;
    }
    .task_comments_count
    {
        font-size: 12px;
        padding: 5px;
        border: 0;
        border-radius: 4px;
    }
    .select2-results__options li span img {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        border: 1px solid #eee;
    }

    #upload_image {
        float: left;
        width: 100%;
        margin-bottom: 20px;
    }

    .btn_upload_images {
        margin-bottom: 20px;
        float: left;
    }

    .btn_upload_images label {
        display: table-cell;
        vertical-align: middle;
    }

    .mySelect2 {
        width: 150px;
    }

    .fileContainer {
        float: left;
        width: auto;
        overflow: hidden;
        position: relative;
    }

    .fileContainer [type=file] {
        cursor: inherit;
        display: block;
        filter: alpha(opacity=0);
        min-height: 100%;
        opacity: 0;
        position: absolute;
        right: 0;
        text-align: right;
        top: 0;
    }

    .fileContainer:hover label {
        background-color: #eee;
        cursor: pointer;
    }

    #image-preview {
        width: 150px;
        height: 150px;
        float: left;
        position: relative;
    }

    #image-preview img {
        height: 100%;
    }

    .image-preview {
        margin-right: 14px !important;
        display: none;
    }

    .image-preview-hover {
        width: 100%;
        height: 100%;
        position: absolute;
        transition: all .5s ease;
        background-color: #0000;
    }

    #image-preview:hover > .image-preview-hover {
        background-color: #0006;
    }

    .remove-image-privew {
        visibility: hidden;
        background: none;
        border: none;
        color: #c5c5c5;
        position: absolute;
        right: 5px;
        top: 5px;
    }

    .remove-image-privew:hover {
        color: #fff;
    }

    .image-preview-hover:hover > .remove-image-privew {
        visibility: visible;
    }

    .image-preview {
        width: 130px;
        height: 48px;
        float: left;
        position: relative;
        object-fit: cover;
        width: 100;
        margin-left: 14px;
        border-radius: 6px;
    }

    .image-preview .fa {
        color: #f00;
    }

    .image-preview img {
        height: 100%;
    }

    .image-preview-hover {
        width: 100%;
        height: 100%;
        position: absolute;
        transition: all .5s ease;
        background-color: #0000;
    }


    .image-preview:hover > .image-preview-hover {
        background-color: #0006;
    }


    .white-button {
        background-color: #fff;
        padding: 0px 20px 0px 20px;
        border-radius: 4px;
        border: 1px solid #dddfe2;
        height: 45px;
        vertical-align: middle;
        transition: all .2s ease;
        display: table;
        color: #013c60 !important;
        font-size: 11px;
    }

    .white-button span {
        display: table-cell;
        vertical-align: middle;
    }

    .white-button:hover {
        color: #105386;
        background-color: #eee;
        cursor: pointer;
    }

    .white-button {
        font-size: 12px !important;
        padding: 14px !important;
    }

    .swal2-styled.swal2-confirm {
        background-color: #105386 !important;
        font-size: 13px;
        padding: 5px 21px !important;
    }

    .swal2-title {
        margin-top: -27px;
    }

    .swal2-styled.swal2-cancel {
        font-size: 13px;
        padding: 5px 21px !important;
    }

    .sub_tasks3 .ms-dd-header {
        margin-top: 3px;
    }

    #sidebarMenu .testing {
        margin-left: 10px;
    }

    #sidebarMenu .testing .form-checkbox-field:checked ~ .form-checkbox-button {
        color: #ec6731 !important;
    }

    #sidebarMenu .testing .form-checkbox-button::before, .testing .form-checkbox-button::after {
        background-color: #ec6731 !important;
    }

    #sidebarMenu .testing .form-checkbox-label:hover i,
    #sidebarMenu .testing .form-radio-label:hover i {
        color: #ec6731 !important;
    }

    .select2 .task-details li img {
        height: 20px;
        width: 20px;
    }

    #sidebarMenu .task-details li span {
        border: 0;
        height: 30px;
    }

    .maincommenttask {
        text-align: center;
        font-size: 20px;
        font-weight: 500;
        margin-top: 19px;
        color: #03658c;
    }

    .taskcomments {
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .taskcomments svg {
        color: #ccc;
    }

    .taskcomments svg:hover {
        color: #ff5722;
        cursor: pointer;
    }

    .taskcomments h6 {
        color: #ff5722;
        font-weight: 500;
        font-size: 15px;
        margin-top: 0;
    }

    .selectator_element {
        border: 1px solid #777777 !important;
    }

    .ui-icon-circle-triangle-e,
    .ui-icon-circle-triangle-w {
        background-position: 0 !important;
    }

    .sub_tasks3 .ui-datepicker-trigger {
        margin: 0 !important;
        width: 24px;
        margin-right: 68px !important;
        margin-bottom: -27px !important;
    }

    .sub_tasks3 .ms-dd .ms-dd-header {
        margin-top: 0;
    }

    .sub_tasks3 .date_text {
        height: 0;
    }

    .subtask_details {
        font-size: 11px;
        margin-top: 7px;
        padding: 5px;
        border-radius: 7px;
        color: #03658c !important;
        margin-left: 1px;
        font-weight: 600;
    }

    .subtask_details span {
        color: #5e5d5d;
        margin-right: 5px;
        font-size: 11px;
        font-weight: 600px;
    }

    .add-comment {
        font-size: 13px;
    }

    .comments {
        display: none;
    }

    .comment_updated {
        float: right;
        color: #00b700;
        font-size: 18px;
        display: none;
    }

    .update_comment_btn {
        font-size: 9px;
        margin: 6px;
        margin: 0;
        border: 0;
        border-radius: 4px;
        margin-bottom: 7px;
        background-color: #013c60 !important;
        color: #ffffff;
        display: none;
    }

    .update_comment_btn:hover {
        background-image: linear-gradient(to right, #013c60, #0478e0);
        color: #ffffff;
    }

    .ergmodal textarea {
        font-size: 12px;
    }

    .ergmodal .modal-header {
        border-bottom: 0;
    }

    .ergmodal .modal-footer {
        border-top: 0;
    }

    .replayalert {
        color: #198754;
        font-size: 11px;
        font-weight: 500;
        text-align: left;
    }

    .ergmodal alert {
        display: block;
        font-size: 13px;
        background-color: transparent;
        padding: 0;
        border: 0;
        color: #f00;
        margin-bottom: 0;
    }

    .comment-content {
        word-break: break-word;
    }

    .ergtext {
        font-size: 15px;
        margin-bottom: 25px;
        color: #013c60;
    }

    .ergbutton {
        border: 0;
        background-color: #00609b;
        box-shadow: 3px 3px 0px 0px #ccc;
        font-size: 13px;
    }

    .ergbutton:hover {
        border: 0;
        background-color: #ffff;
        color: #00609b;
        box-shadow: 3px 3px 0px 0px #ccc;
        font-size: 13px;
    }

    .modal-backdrop {
        z-index: 12 !important;
    }

    .view_comment {
        float: right;
        margin: 4px;
        font-size: 10px;
        color: #fff;
        font-weight: 500;
        background-color: #013c60;
        text-align: center;
        border-radius: 16px;
        padding: 3px;
        margin: 0;
        margin-right: 9px;
        padding: 4px 10px;
    }

    .view_comment:hover {
        background-image: linear-gradient(to right, #013c60, #0478e0);
    }

    .view_comment .form-checkbox-button {
        visibility: hidden;
    }

    .comment-content img {
        height: auto;
        width: 103px;
        border: 1px solid #eee;
        margin: 0 auto;
        object-fit: cover;
        margin-top: 11px;
        margin-bottom: 10px;
    }

    .comment-content a {
        color: #ec9157;
        text-decoration: none;
        font-size: 13px;
        line-height: 20px;
        font-weight: 500;
    }

    .comment-content .update_comment_btn {
        color: #ffff;
        font-size: 10px;
        /* line-height: 20px; */
        /* font-weight: 500; */
        margin-right: 7px;
    }

    .comment-content a:hover {
        color: #ec4509;
    }

    .comment-box .controls {
        float: right;
        margin: 4px;
    }

    .comment-box .controls .delete_comment:hover {
        color: #bb2d3b !important;

    }

    .comment-box .controls .edit_replay:hover {
        color: #198754 !important;

    }

    .add_new_replay {
        display: none;
        margin-bottom: 10px;
    }

    .add_replay {
        font-size: 11px;
        font-weight: 500;
        color: #ec6630;
        margin-left: 13px;

    }

    .add_replay:hover {
        color: #777777;
        cursor: pointer;
    }

    .aadd_replay {
        font-size: 11px;
        font-weight: 500;
        color: #ec6630;
        margin-left: 13px;

    }

    .aadd_replay:hover {
        color: #777777;
        cursor: pointer;
    }


    .sub_tasks2 .ms-dd,
    .sub_tasks3 .ms-dd {
        width: 93px;
        font-size: 10px;
        background-color: transparent;
        border-radius: 0;
        margin-bottom: 7px;
        padding: -1px;
        font-size: 11px;
    }

    .selectator_element {
        min-height: 36px !important;
    }

    .completed_count {
        color: #0a53be;
        display: inline-block;
    }

    .uncompleted_count {
        color: #777777;
        display: inline-block;
    }

    .form-check {
        display: inline-block;
        margin-bottom: -8px;
        margin-left: 12px;
    }

    .selected-image {
        width: 30px;
        height: 30px;
        margin-right: 5px;
    }

    /*start  Dropdown of  users */
    #sidebarMenu {
        overflow-x: hidden;
        padding-bottom: 20px;
    }

    #sidebarMenu .todo .description {
        word-wrap: break-word;
        font-size: 11px;
        min-width:332px

    }

    #sidebarMenu #shuffle2 .desc {
        font-size: 12px;
        min-width: 300px;
    }


    #sidebarMenu .dd-pointer-down {
        display: none;

    }

    .select2-selection__rendered img {
        height: 20px;
        width: 20px;
        border-radius: 50%;
    }

    #sidebarMenu .ui-datepicker-trigger {
        height: 20px;
        margin-right: 25px;
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
        background: #ffff;
        padding: 5px;
        font-size: 11px;
        color: #fff;
        text-align: center;
        border-radius: 4px !important;
        padding: 5px 12px;
        border: 1px solid #ccc;
        color: #333;
        margin-left: 19px;
    }

    #sidebarMenu .filupp:hover {
        cursor: pointer;
        background-color: #cccccc;
        color: #03658c;
    }

    #sidebarMenu .submit_comment {
        background-color: #013c60;
        color: #ffffff;
        color: #fff;
        border: 0;
        padding: 5px;
        font-size: 11px;
        border-radius: 4px;
    }

    #sidebarMenu .submit_comment:hover {
        background-image: linear-gradient(to right, #013c60, #0478e0);
    }

    #sidebarMenu .comments .comment img {
        width: 35px !important;
        height: 35px !important;
        margin-top: 2px;
        border: 1px solid #ccc;
    }

    .test .date_text {
        margin-top: 12px;
    }

    #sidebarMenu .txta {
        width: 100%;
        max-width: 525px;
        min-height: 100px;
        font-size: 12px;
        overflow: hidden;
        line-height: 1.4;
        border: 1px solid #eee  !important;
        padding: 9px;
        margin-top: 5px !important;
    }

    #sidebarMenu .remove-task {
        background-color: #ffffff;
        color: #000000;
        box-shadow: none;

    }

    #sidebarMenu .btnn-remove {
        border: 0;
    }

    #sidebarMenu .btnn-remove:hover {
        color: #ff0000;

    }

    #sidebarMenu .remove-task,
    #sidebarMenu .complete_task {
        font-size: 11px;
        background-color: #3333;
        font-size: 12px;
        border: 0;
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

    #sidebarMenu .tested {
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

    #sidebarMenu .tagname i {
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

    #sidebarMenu .btn-copy:hover {
        color: #485eff !important;
    }

    .textsheck {
        margin-left: 5px;
    }

    .likecomment {
        color: #0a53be;
        /* float: left; */
        font-size: 13px;
    }

    .select2-results {
        font-size: 13px;
    }

    @keyframes rotaion {
        0% {
            transform: rotate(360deg);
        }
        100% {
            transform: rotate(0deg);
        }
    }

    #sidebarMenu .relodebutton {
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

    #sidebarMenu .relodebutton:hover {
        border-radius: 50%;
    }

    #sidebarMenu .relodebutton:hover .bi-arrow-clockwise::before {
        animation: rotaion 1s linear infinite;
    }

    #sidebarMenu .ms-dd-header {
        min-height: 40px !important;
        text-align: right;
    }

    #sidebarMenu .ms-dd .ms-list-option.option-selected, .ms-dd .ms-optgroup ul .ms-list-option.option-selected {
        background-color: transparent !important;
        border: 0;
    }

    #sidebarMenu .ms-dd .ms-dd-header {
        border: 0;
    }

    #sidebarMenu .ms-dd .ms-value-input {
        display: none;
    }

    #sidebarMenu .ms-dd .ms-dd-arrow {
        height: 0;
        margin-top: -6px;
        position: absolute;
        right: 0px;
        top: 50%;
        width: 0;
    }

    #sidebarMenu .ms-options {
        height: 200px;
    }

    .sub_tasks3 .dd-select {
        background-color: transparent !important;
        height: 28px !important;;
        border-radius: 50% !important;
        border: 0 !important;
        width: 100px !important;
        float: right;
    }

    .sub_tasks3 .desc {
        max-width: 62%;
    }

    .sub_tasks3 .dd-selected {
        height: 45px;
    }

    .sub_tasks3 .dd-option-image, .dd-selected-image {
        height: 28px !important;;
        border-radius: 50% !important;
    }

    .sub_tasks3 .dd-option {
        padding: 0 !important;
    }

    .sub_tasks3 .dd-options {
        width: 129px !important;
        height: 200px !important;
    }

    .sub_tasks3 .desc {
        width: 100% !important;
    }

    .sub_tasks3 .ui-datepicker-trigger {
        margin-top: -50px !important;
    }

    .sub_tasks3 .dd-pointer-down {
        display: block !important;
        right: 0px !important;
        top: 79% !important;
    }

    .subtasks_users {
        visibility: hidden;
    }
    subtasks_users
    .tested {
        color: #eb6028;
    }

    /*Start  Comments Style */

    /** ====================
    * Lista de Comentarios
    =======================*/
    .comments-container {
        width: 100%;
    }


    .comments-container h1 a {
        font-size: 18px;
        font-weight: 700;
    }

    .comments-list {
        position: relative;
        padding: 0;
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
        bottom: -3px;
        left: 14px;
        width: 7px;
        height: 4px;
        border: 3px solid #dee1e3;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
    }

    .reply-list:before, .reply-list:after {
        display: none;
    }

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

    .reply-list .comment-box {
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
        -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
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

    .comment-main-level {
        margin-bottom: 15px;
    }

    .comment-main-level:after {
        content: '';
        width: 0;
        height: 0;
        display: block;
        clear: both;
    }

    .replay_tags {
        width: 100%;
        margin-top: -5px;
    }

    /**
     * Caja del Comentario
     ---------------------------*/
    .comments-list .comment-box {
        width: 91%;
        float: left;
        margin-left: 13px;
        position: relative;
        -webkit-box-shadow: 0 1px 1px rgb(0 0 0 / 15%);
        -moz-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);
        box-shadow: 0 1px 1px rgb(0 0 0 / 15%);
    }

    .btn-success {
        background-color: #2778c4 !important;
    }

    .btn-success:hover {
        color: #ffffff;
    }

    .comments-list .comment-box p {
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
        border-color: transparent rgba(0, 0, 0, 0.05);
        left: -12px;
    }

    .reply-list .comment-box .comment-content {
        font-size: 10px;
        padding: 3px;
        margin-bottom: 20px;
        margin: 0;
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


    .comment-box .comment-name {
        color: #283035;
        font-size: 14px;
        font-weight: 700;
        float: left;
        margin-right: 10px;
    }

    .comment-box .comment-name a {
        color: #283035;
        font-size: 12px;
    }

    .comment-box .comment-head span {
        float: left;
        color: #999;
        font-size: 11px;
        position: relative;
        top: 1px;
        margin-left: 10px;
    }

    .comment-box .comment-content {
        padding: 3px;
        margin: 0;
        font-size: 15px;
        color: #595959;
        -webkit-border-radius: 0 0 4px 4px;
        -moz-border-radius: 0 0 4px 4px;
        border-radius: 0 0 4px 4px;
        background-color: none !important;
    }

    .comment-box .comment-name.by-author, .comment-box .comment-name.by-author a {
        color: #03658c;
    }

    .replaystyle {
        width: 100%;
        margin-left: 45px;
        font-size: 11px;
    }

    .replaystyle {
        width: 100%;
        margin-left: 23px;
        font-size: 11px;
    }

    .replaystylee {
        width: 100%;
        margin-left: 23px;
        font-size: 11px;
    }

    .send_replay {
        font-family: inherit;
        font-size: 16px;
        background: #017ac7;
        color: white;
        padding: 0.7em 1em;
        padding-left: 0.9em;
        display: flex;
        align-items: center;
        border: none;
        border-radius: 5px;
        overflow: hidden;
        transition: all 0.2s;
    }

    .send_replay .fas {
        display: block;
        transform-origin: center center;
        transition: transform 0.3s ease-in-out;
    }

    .send_replay:hover .fas {
        transform: rotate(45deg) scale(1.1);
    }

    .send_replay:hover .svg-wrapper {
        animation: fly-1 0.6s ease-in-out infinite alternate;
    }

    .send_replay:active {
        transform: scale(0.95);
    }

    .send_replay {
        color: #fff;
        background-color: #013c60 !important;
        border-color: #013c60 !important;
        font-size: 12px;
    }

    @keyframes fly-1 {
        from {
            transform: translateY(0.1em);
        }

        to {
            transform: translateY(-0.1em);
        }
    }


    .replayes_count {
        float: left;
        margin-left: 49px;
        margin-top: 7px;
        font-weight: 500;
        color: #03658c;
        padding: 4px;
        margin-top: -5px;
        font-size: 10px;
    }

    .replayes_count p {
        background-color: #ec6630;
        height: 19px;
        width: 20px;
        /* border-radius: 50%; */
        text-align: center;
        border-radius: 50%;
        padding: 1px;
    }

    .replayes_count p:hover {
        background-color: #03658c;
    }

    .replayes_count p span {
        color: #fff;
        font-size: 12px;

    }

    .replayes_count p:hover {
        color: #ec6630;
        cursor: pointer;
    }

    .replaynewcomment {
        float: right;
        font-size: 13px;
        color: #03658c;
        font-weight: bold;
    }

    .replaynewcomment:hover {
        cursor: pointer;

    }

    #commentbox {
        font-size: 13px !important;
    }

    .tags_footer {
        margin-top: 10px;
    }

    .tags_footer .tagname {
        color: #017ac7;
        font-size: 11px;
        margin-bottom: 5px;
    }

    .destorybutton {
        display: none;
    }

    .completed_comments {
        display: none;
    }

    .ergmodal .modal-body p {
        color: #00609b;
        margin-top: 21px;
        margin-bottom: 0;
        font-size: 13px;
    }

    .ergmodal .modal-body p span {
        margin-right: 5px;
        color: #ec6630;
        font-size: 12px;
        float: none;
    }

    .main-tasks .main_tasks_header input {

        font-size: 20px;
    }

    .main-tasks .btn-complete {
        border-radius: 4px;
        border: 1px solid #eee;
        font-size: 11px;
        margin-bottom: 18px;
        float: left;
        margin-right: 12px;
    }

    .main-tasks .btn-complete:hover {
        background-color: #19875463;
        color: #0ba360;
        border: #19875463;
    }

    #sidebarMenu
    .btnn-remove {
        border-radius: 4px;
        border: 1px solid #eee;
        font-size: 11px;
        margin-bottom: 18px;
        float: left;
        margin-right: 12px;
    }

    .main_tasks_header input {
        transition: border .4s ease-out;
        border: 1px solid transparent !important;
        font-size: 18px;
        margin-bottom: 11px;

    }

    .main_tasks_header input:focus {
        border: 1px solid #212529 !important;
        box-shadow: none;
    }

    .main_tasks_header input:hover {
        border: 1px solid #212529 !important;
        cursor: pointer;
    }

    #sidebarMenu .select2-container--default .select2-selection--single {
        border: 1px solid transparent !important;
    }

    #sidebarMenu .select2-container--default .select2-selection--single:focus {

    }

    #sidebarMenu .select2-container--default .select2-selection--single:hover {
        cursor: pointer;
    }

    #sidebarMenu .select2-container--default .select2-selection--single .select2-selection__arrow b {
        visibility: hidden;
    }

    .add_new_replay .selectator_element.multiple {
        border: 1px solid #6c757d !important;
    }


    #sidebarMenu .selectator_element:focus {
        border: 1px solid #212529 !important;
        box-shadow: none;
    }

    #sidebarMenu .selectator_element:after {
        visibility: hidden;
    }

    #sidebarMenu .flatpickr-input[readonly] {
        border: 0;
    }

    #sidebarMenu .flatpickr-input[readonly]:hover {
        border: 1px solid #000;
    }

    #sidebarMenu textarea {
        box-shadow: none;
        border: 0 !important;
    }

    #sidebarMenu textarea:focus {
        border: 1px solid #000;
    }

    #sidebarMenu textarea:hover {
        border: 1px solid #000 !important;
    }

    #sidebarMenu textarea:focus {
        border: 1px solid #000 !important;
    }

    #sidebarMenu #commentbox {
        border: 1px solid #eeeeee !important;
    }


    #sidebarMenu .send-comment,
    #sidebarMenu .view_comment {
        border-radius: 4px !important;
    }

    #sidebarMenu #selectator_select55 {
        border: 1px solid #eeeeee !important;
        width: 95% !important;
    }

    .main-tasks .task-data .selectator_element {
        border: 1px solid transparent !important;
    }

    #sidebarMenu #edit_subtask .selectator_element:hover {
        border: 1px solid #212529;
        cursor: pointer;
    }

    .selectator_input {
        width: auto !important;;
    }

    .ui-state-active {
        background-color: #ec6630 !important;
        text-align: center;
        color: #fff;
        border-radius: 4px;
    }

    #sidebarMenu .selectator_element:after {
        visibility: initial !important;
    }

    .upload_post_image {
        background-color: #013c60;
        border: 0;
        padding: 14px 15px 13px;
        margin-left: 8px;
        display: none;
    }

    /* Team Members Style */
    .select2-selection {
        font-size: 12px;
    }



    #sidebarMenu .selectator_select6, #sidebarMenu .select2-container {
        width: 100% !important;
    }

    .select2-container .select2-selection--multiple .select2-selection__rendered {
        display: block;
    }
    .user_selection_plugin .select2-selection__choice
    {
        color: #000 !important;
        border: 1px solid #eee !important;
        font-size: 13px !important;
    }
    .user_selection_plugin .select2-selection__choice__remove
    {
        border-right:0 !important;
    }
    .select2-container--default.select2-container--open.select2-container--below .select2-selection--single, .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple
    {
        border: solid #eee 1px !important;
    }
    .user_selection_plugin .select2-container--default.select2-container--focus .select2-selection--multiple{
        border: solid #ccc 1px !important;
    }

    .user_selection_plugin .select2-selection img {

        height: 20px!important;
        width: 20px !important;
        border-radius: 50% !important;
        border: 2px solid #ccc;
    }
    .selected-image  {
        height: 20px!important;
        width: 20px !important;
        border-radius: 50% !important;
        border: 1px solid #ccc;
    }
    .userguest_plugin .select2-selection__choice
    {
        color: #000 !important;
        border: 1px solid #eee !important;
        font-size: 13px !important;
    }
    .userguest_plugin .select2-selection__choice__remove
    {
        border-right:0 !important;
    }
    .userguest_plugin .select2-container--default.select2-container--open.select2-container--below .select2-selection--single,
    .userguest_plugin .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple
    {
        border: solid #eee 1px !important;
    }
    .userguest_plugin .select2-container--default.select2-container--focus .select2-selection--multiple{
        border: solid #ccc 1px !important;
    }

    .userguest_plugin .select2-selection img {
        height: 20px!important;
        width: 20px !important;
        border-radius: 50%!important;
        border: 2px solid #ccc;
    }
     .task-container .desc
     {
         padding: 0 !important;
         margin: 0 !important;
         margin-left: 10px !important;
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
        <div id="edit_subtask">
            @csrf
            <input type="hidden" name="task_id" value="{{$task->id}}" id="task_id">
            <div class="position-sticky">
                <div id="tabcomments"></div>
                <div class="main-tasks">
                    <div class="task-data">
                        <div class="task-details">
                            <div class="row">
                                <div class="col-md-9">
                                    <!--Check That Not Idea Post -->
                                        @if($task->task_status == 0 || $task->task_status == 2)
                                            <a class="complete_task btn-complete btn btn-default"><i
                                                    class="fa fa-check-circle"></i> {{__('messages.mark_complete')}}
                                            </a>
                                        @else
                                            <a class="uncomplete_task btn-complete btn btn-success"><i
                                                    class="fa fa-check-circle"></i> {{__('messages.mark_un_complete')}}
                                            </a>
                                        @endif
                                        <div class="action_buttons">
                                            @if($task->task_status == 0 || $task->task_status == 1)
                                                <button class="remove-task btnn-remove btn btn-danger"><i
                                                        class="fa fa-trash"></i> {{__('messages.delete')}}
                                                </button>
                                            @else
                                                <button class="unremove-task  btnn-remove btn btn-danger"><i
                                                        class="fa fa-trash"></i>
                                                    {{__('messages.restore')}}
                                                </button>
                                            @endif

                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <button id="dismiss" class="dismiss" type="button">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="main_tasks_header">
                                        <input type="text" name="task_title" value="{!! $task->task_title !!}"
                                               data-name="task_title" class="target form-control popup_title">
                                    </div>
                                </div>
                            </div>

                            <!--Check That Not Idea Post -->

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label">{{__('messages.responsible')}}</label>
                                </div>

                                <div class="col-md-7">
                                    <select name="task_responsible" data-name="task_responsible" style="width:100%"
                                            class="form-control  target task_responsible ">
                                        @foreach ($users as $key => $user)
                                            <option value="{{$user->id}}" @if($task->task_responsible == $user->id ) selected @endif > {{$user->user_name }} </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <!--Start Team Memers -->
                            <div class="row mb-2" >
                                <div class="col-md-2">
                                    <lable class="control-label">{{__('messages.team_members')}}</lable>
                                </div>
                                <div class="col-md-7 user_selection_plugin">
                                    <!-- Create a select element with the "select2" class -->
                                    @php
                                        $team_ids = \App\Models\TaskTeam::where('task_id', $task->id)->pluck('user_id');
                                        $team_ids2 = json_decode($team_ids);
                                    @endphp

                                    <select id="userSelect"  class="target form-control" multiple name="teams_id[]" data-name="teams_id">
                                        @if (!empty($users3))
                                            @foreach ($users3 as $key => $user3)
                                                <option value="{{ $user3->id }}"
                                                        @if (!empty($user3->image))
                                                            data-image="{{ asset('public/assets/images/users/'.$user3->image) }}"
                                                        @else
                                                            data-image="https://pri-po.com/public/assets/images/default.png"
                                                        @endif
                                                        @if (in_array($user3->id , $team_ids2)) selected @endif
                                                >
                                                    {{ $user3->user_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!--End Team Memers -->

                            <!--Start Visitor-->
                            <div class="row">
                                <div class="col-md-2">
                                    <lable class="control-label">{{__('messages.Besucher')}}</lable>
                                </div>
                                <div class="col-md-7 userguest_plugin">
                                    <select id="userguest"  name="guests_id[]" class="target userSelect form-control" multiple data-name="guests_id">
                                        @php
                                            $guest_ids = \App\Models\TaskGuest::where('task_id' , $task->id)->pluck('user_id');
                                            $guest_ids2 = json_decode($guest_ids);
                                        @endphp
                                        @if(!empty($users2))
                                            @foreach ($users2 as $key => $user2)
                                                <option id="{{$key}}" value="{{$user2->id}}"
                                                        @if(!empty($user2->image))
                                                            data-image="{{asset('public/assets/images/users/'.$user2->image)}}"
                                                        @else
                                                            data-image="{{asset('public/assets/images/default.png')}}"
                                                        @endif

                                                        @if(in_array($user2->id , $guest_ids2)) selected @endif >    {{$user2->user_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                            </div>
                            <!--Start Visitor-->

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
                            <div class="row">
                                <div class="col-md-2">
                                    <lable class="control-label">{{__('messages.department')}}</lable>
                                </div>
                                <div class="col-md-7">
                                    <select name="task_category_id" id="task_category_one" data-task-id="{{$task->id}}"
                                            class=" form-control target Fachbereich" data-name="task_category_id" >
                                        @foreach ($cats as $key => $cat)
                                            <option value="{{$cat->id}}"
                                                    @if($task->task_category_id == $cat->id ) selected @endif > {{$cat->category_name }} </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-2">
                                    <lable class="control-label">{{__('messages.department')}}2</lable>
                                </div>
                                <div class="col-md-7">
                                    <select name="task_category_id_two" id="task_category_two"
                                            class=" form-control target Fachbereich2"
                                            data-name="task_category_id_two"
                                            placeholder="{{__('messages.department')}}">
                                        <option value=""> Fachbereich2 wählen</option>
                                        @foreach ($cats as $key => $cat)
                                            <option value="{{$cat->id}}"
                                                    @if($task->task_category_id_two == $cat->id ) selected @endif > {{$cat->category_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" style="font-size: 12px !important;
                                                                         color: #000 !important;
                                                                         font-weight: initial  !important;
                                                                         ">{{__('messages.under_category')}}</label>
                                </div>
                                <div class="col-md-7">
                                    <select id="categoryselect" name="tags_id[]" class="target" multiple data-name="tags_id">
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
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <lable class="control-label">{{__('messages.desc')}}</lable>
                                </div>
                                <div class="col-md-7">
                                   <textarea class="form-control target txta" data-name="task_desc" style="margin-top:5px !important;">{{$task->task_desc}}</textarea>
                                </div>





                            </div>
                            <!-- Upload Post Image -->
                            <div class="form-group mt-3">
                                <form method="POST" action="{{ route('tasks.upload_post_image') }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-2">
                                            <lable class="control-label">{{__('messages.post image')}}</lable>
                                        </div>
                                        <div class="col-md-7">
                                            <div class=" fileContainer" style="margin:0;">
                                                <input type="file" id="imageUpload-1" name="image" class="image-upload"
                                                       required>
                                                <label for="imageUpload-1" class="white-button"><span><i
                                                            class="far fa-image"></i> Upload Image</span></label>
                                            </div>
                                            <input type="hidden" name="task_id" value="{{$task->id}}">
                                            <div id="imageUpload-1-preview" class="image-preview"
                                                 @if(!empty($task->image))
                                                     style="
                                                                   background-image:url({{asset('uploads/images/compressed/'.$task->image)}}) ;
                                                                   display: block !important;
                                                                   background-size: cover;
                                                                   background-position: center center;
                                                                  "
                                                @endif
                                            >
                                                <div class="image-preview-hover">
                                                    <button type="button" class="remove-image-privew"
                                                            data-id="{{$task->id}}"><i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm upload_post_image"><i
                                                    class="fa fa-upload"></i> {{__('messages.upload')}}</button>
                                        </div>

                                    </div>

                                </form>
                            </div>
                            <!--End Upload  Post Image -->

                            <div class="subtasks-header">
                                <div class="row">
                                    <div class="col-md-3">
                                        <i class="bi bi-calendar2-plus"></i> {{__('messages.subtasks')}}
                                    </div>
                                    <div class="col-md-3">
                                        <div
                                            class="uncompleted_count">{{$task->subtasks->count() - $task->completed_subtasks->count() }}</div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input cb-value " type="checkbox">
                                        </div>
                                        <div class="completed_count">{{$task->completed_subtasks->count()}} / <span
                                                class="tested">{{$task->testedtasks->count()}}</span></div>
                                    </div>
                                    <div class="col-md-1">
                                        <!--
                                                <button type="button" class="btn btn-sm btn-primary relodebutton" onclick="rebuild_popup({{$task->id}})">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                                -->
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
                                                            @endif  data-id="{{$subtask->id}}"
                                                            id="subtask{{$subtask->id}}">
                                                            <i class="fa fa-ellipsis-v subtask_dropdown dropdown-toggle"
                                                               id="custom_dropdown_subtask" data-bs-toggle="dropdown"
                                                               aria-expanded="false"></i>
                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="custom_dropdown_subtask">
                                                                <li>
                                                                    <a class="dropdown-item btn-remove unselectable custom_trash"
                                                                       data-id="{{$subtask->id}}" href="#"><i
                                                                            class="bi bi-trash "></i> {{__('messages.delete')}}
                                                                    </a>
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
                                                                <li>
                                                                    <a class="dropdown-item btn-copy add-comment"
                                                                       data-id="{{$subtask->id}}"
                                                                       href="#"><i class="bi bi-file-break-fill"></i>
                                                                        {{__('messages.comment')}}</a>
                                                                </li>

                                                            </ul>

                                                            @if(!empty($subtask->added_by->image))
                                                                <img
                                                                    src="https://pri-po.com/public/assets/images/users/{{$subtask->added_by->image}}"
                                                                    class="subtaskimage"/>
                                                            @else
                                                                <img
                                                                    src="https://pri-po.com/public/assets/images/users/default.png"
                                                                    class="subtaskimage"/>
                                                            @endif


                                                            <i class="material-icons unselectable btn-drag">drag_indicator</i>

                                                            <input class="taskched" data-id="{{$subtask->id}}"
                                                                   type="checkbox"
                                                                   @if($subtask->subtask_status != 0) checked @else
                                                                ' '
                                                            @endif
                                                            >
                                                            <span class="description desc" data-id="{{$subtask->id}}"
                                                                  contenteditable="true">
                                                                    {{ strip_tags($subtask->subtask_title) }}
                                                                </span>
                                                            <!-- <input type="date" class="date dte" data-id="{{$subtask->id}}" value="{{$subtask->subtask_due_date}}"> -->


                                                            <div class="test">
                                                                <div class="calender">
                                                                    <label>
                                                                        @if(  !empty($subtask->subtask_due_date) &&  date('d.m.Y', strtotime($subtask->subtask_due_date)) !='01.01.1970' )
                                                                            <script>
                                                                                $(document).ready(function () {
                                                                                    $("#subtask{{$subtask->id}} .ui-datepicker-trigger").css('visibility', 'hidden');
                                                                                });
                                                                            </script>
                                                                            <p class="date_text">  {{date('d.m.Y', strtotime($subtask->subtask_due_date))}}</p>

                                                                        @else
                                                                            <script>
                                                                                $(document).ready(function () {
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
                                                            <!--New Select Box v2 -->
                                                            <select class="mySelect2 subtasks_users"
                                                                    style="width: 300px;" name="TaskResponsiple"
                                                                    data-id="{{$subtask->id}}">
                                                                <option value="">Select an option</option>
                                                                @foreach($users as $user)
                                                                    <option value="{{$user->id}}"
                                                                            @if(!empty($user->image))
                                                                                data-image="{{asset('public/assets/images/users/'.$user->image)}}"
                                                                            @else
                                                                                data-image="https://pri-po.com/public/assets/images/default.png"
                                                                            @endif
                                                                            @if($subtask->subtask_user_id == $user->id ) selected="selected" @endif
                                                                    >{{$user->user_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" value="{{$subtask->id}}" class="testinput" data-id="{{$subtask->id}}"/>
                                                            <button class="btn btn-icon btn-primary TaskTitle task_comments_count" data-id="{{$subtask->id}}"><i class="fa fa-comments"></i></button>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <li class="create">
                                                <i class="material-icons unselectable">add</i>
                                                <input class="new-task" contenteditable="true"
                                                       placeholder="{{__('messages.subtasks')}}">
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

                                                        <li @if($subtask->subtask_status != 0) class="task  ui-state-default completed"

                                                            @else class="task  ui-state-default"
                                                            @endif  data-id="{{$subtask->id}}"
                                                            id="subtask{{$subtask->id}}">

                                                            <i class="bi bi-three-dots-vertical subtask_dropdown dropdown-toggle"
                                                               id="custom_dropdown_subtask" data-bs-toggle="dropdown"
                                                               aria-expanded="false"></i>

                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="custom_dropdown_subtask">
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

                                                            <!--Start  subtask Stats -->
                                                            @if($subtask->subtask_status == 1)
                                                                <label class="form-checkbox-label">
                                                                    <input name="completed"
                                                                           class="form-checkbox-field  taskched"
                                                                           data-id="{{$subtask->id}}" type="checkbox"
                                                                           value="1" checked/>
                                                                    <i class="form-checkbox-button"></i>
                                                                </label>
                                                            @else
                                                                <label class="form-checkbox-label">
                                                                    <input name="completed"
                                                                           class="form-checkbox-field taskched"
                                                                           data-id="{{$subtask->id}}" type="checkbox"
                                                                           value="0"/>
                                                                    <i class="form-checkbox-button"></i>
                                                                </label>
                                                            @endif

                                                            <!--Start  subtask Stats -->
                                                            <!--Start Subtask Tested -->
                                                            @if($subtask->tested == 1 )
                                                                <label class="form-checkbox-label testing">
                                                                    <input name="completed"
                                                                           class="form-checkbox-field tested" value="0"
                                                                           type="checkbox" data-id="{{$subtask->id}}"
                                                                           checked/>
                                                                    <i class="form-checkbox-button"></i>
                                                                </label>

                                                            @endif
                                                            @if($subtask->tested == 0 )
                                                                <label class="form-checkbox-label testing">
                                                                    <input name="completed"
                                                                           class="form-checkbox-field tested" value="1"
                                                                           type="checkbox" data-id="{{$subtask->id}}"/>
                                                                    <i class="form-checkbox-button"></i>
                                                                </label>
                                                            @endif
                                                            <!--EnD Subtask Tested -->


                                                            <span
                                                                @if($subtask->tested === 1) style="color: #eb6028 !important;"
                                                                @endif  class="description desc"
                                                                data-id="{{$subtask->id}}"
                                                                contenteditable="true">{!!$subtask->subtask_title!!}</span>
                                                            <!-- <input type="date" class="date dte" data-id="{{$subtask->id}}" value="{{$subtask->subtask_due_date}}"> -->


                                                            <div class="test">
                                                                <div class="calender">
                                                                    <label>@if(  !empty($subtask->subtask_due_date) &&  date('d.m.Y', strtotime($subtask->subtask_due_date)) !='01.01.1970' )

                                                                            <p class="date_text">  {{date('d.m.Y', strtotime($subtask->subtask_due_date))}}</p>
                                                                            <script>
                                                                                $(document).ready(function () {
                                                                                    $("#subtask{{$subtask->id}} .ui-datepicker-trigger").css('visibility', 'hidden');
                                                                                });
                                                                            </script>
                                                                        @else
                                                                            <script>
                                                                                $(document).ready(function () {
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


                                                            <select class="slick{{$subtask->id}} task_resp"
                                                                    is="ms-dropdown" data-enable-auto-filter="true"
                                                                    data-id="{{$subtask->id}}"
                                                                    name="TaskResponsiple"
                                                                    style="height: 30px ; width:89px !important; "
                                                                    data-enable-auto-filter="true">
                                                                <option
                                                                    data-imagesrc="{{asset('public/assets/images/person.png')}}">
                                                                    Select
                                                                </option>
                                                                @foreach($users as $user)
                                                                    <option value="{{$user->id}}"
                                                                            @if(!empty($user2->image))
                                                                                data-imagesrc="{{asset('public/assets/images/users/'.$user2->image)}}"
                                                                            @else
                                                                                data-imagesrc="{{asset('public/assets/images/default.png')}}"
                                                                            @endif

                                                                            @if($subtask->subtask_user_id == $user->id ) selected="selected" @endif> {{$user->user_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" value="{{$subtask->id}}"
                                                                   class="testinput"
                                                                   data-id="{{$subtask->id}}"/>


                                                            <button class="btn btn-icon btn-primary TaskTitle task_comments_count" data-id="{{$subtask->id}}"><i class="fa fa-comments"></i></button>

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
                        </div>
                        <!--Start  Comments -->
                        <div class="row">
                            <div class="col-md-9">
                                <div class="comments">
                                    <form  action="{{route('admin.subtasks.store_comment')}}" id="upload-images-form" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <input id="hidden_subtask" type="hidden" name="subtask_id"/>
                                        <textarea id="commentbox" rows="5" class="form-control"
                                                  placeholder="{{__('messages.enter_comment')}}..."></textarea>
                                        <div id="commentoutput" style="display: none"></div>

                                        <select id="commentTag" name="tags[]" class="userTags select2" multiple
                                                data-name="tags[]">
                                            @foreach($users_gests as $user)
                                                <option id="{{$user->id}}" value="{{$user->id}}"
                                                        @if(!empty($user->image))
                                                            data-image="{{asset('public/assets/images/users/'.$user->image)}}"
                                                        @else
                                                            data-image="https://pri-po.com/public/assets/images/default.png"
                                                    @endif
                                                > {{$user->first_name}}</option>
                                            @endforeach
                                        </select>
                                        <div id="popup1" class="popup">
                                            <div class="drop-zone-container">
                                                <div class="drop-zone">DRAG AND DROP IMAGES HERE</div>
                                                <input class="standard-upload-files" type="file" name="standard-upload-files[]" multiple style="display:none">
                                                <div class="show-selected-images"></div>
                                            </div>
                                        </div>

                                        <button type="submit" id="add_comment" class="send-comment send-comment2 btn_1"
                                                data-task="{{$task->id}}">
                                            <div class="svg-wrapper">
                                                <i class="fas fa-paper-plane"
                                                   style="font-size: 16px; color: #fff; margin-top: 1px; margin-left: -3px;"></i>
                                            </div>
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('.TaskTitle').click(function (e) {
                                    e.preventDefault();
                                    $subtask_id = $(this).data('id');
                                    $('.main-tasks').css('display', 'none');
                                    $('#tabcomments').css('display', 'block');
                                    $.ajax({
                                        type: "POST",
                                        url: '{{route('admin.comments.getTaskComments')}}',   // need to create this post route
                                        cache: false,
                                        data: {subtask_id: $subtask_id},
                                        success: function (data) {
                                            $('#tabcomments').html(data.options);
                                        },
                                        error: function (jqXHR, status, err) {
                                        },
                                    });
                                })
                            });
                        </script>

                        <script>
                            $(document).ready(function () {
                                $(document).on('change', '.donecomment', function (e) {
                                    if ($(this).prop("checked")) {
                                        var comment_id = $(this).data('id');
                                        var addedby = "{{Auth::user()->first_name}}";
                                        var task_id = $("#task_id").val();
                                        var comment_author = $('.comments-list' + comment_id).data('author');
                                        /* display  model */
                                        $('#exampleModal' + comment_id).modal('toggle');
                                    }
                                });


                                $(document).on('keyup', '.desc', function () {
                                    var subtask_id = $(this).data('id');
                                    var desc_val = $(this).text();
                                    //	  alert(desc_val);
                                    $.ajax({
                                        type: "POST",
                                        url: '{{route('admin.subtasks.updatefielddd')}}', // need to create this post route
                                        data: {
                                            subtask_id: subtask_id,
                                            desc_val: desc_val,
                                            _token: '{{ csrf_token() }}'
                                        },
                                        cache: false,
                                        success: function (data) {

                                        },
                                        error: function (jqXHR, status, err) {
                                        },
                                    });

                                });


                                $('.ergatecomment').each(function () {
                                    var data_id = $(this).data('id');
                                    $(this).on('keyup', function () {
                                        $('#charchtercount' + data_id).html($(this).val().length);
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
                                            // verify  to delete comments

                                            Swal.fire({
                                                title: 'Sollen alle Kommentare die zu dieser Aufgabe gehören als Erledigt gesetzt werden ?',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'JA',
                                                cancelButtonText: 'Nein',
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: '{{ route('admin.subtasks.update_status') }}',
                                                        data: {
                                                            id: id,
                                                            task_id: task_id,
                                                            deletedcomment: true,
                                                            _token: '{{ csrf_token() }}'
                                                        },
                                                        success: function (data) {
                                                            $('#task' + task_id).html('');
                                                            $('#task' + task_id).html(data.options);
                                                            /* Add Popup Success */
                                                            var x = Math.floor(Math.random() * 3);
                                                            if (x == 0) {
                                                                $('.success-image1').css('display', 'block');
                                                                $('.success-image2').css('display', 'none');
                                                                $('.success-image3').css('display', 'none');
                                                                setTimeout(() => {
                                                                    $('.success-image1').css('display', 'none')
                                                                }, 3000);
                                                                setTimeout(() => {
                                                                    $('.success-image2').css('display', 'none')
                                                                }, 3000);
                                                                setTimeout(() => {
                                                                    $('.success-image3').css('display', 'none')
                                                                }, 3000);

                                                            } else if (x == 1) {
                                                                $('.success-image2').css('display', 'block');
                                                                $('.success-image1').css('display', 'none');
                                                                $('.success-image3').css('display', 'none');
                                                                setTimeout(() => {
                                                                    $('.success-image2').css('display', 'none')
                                                                }, 3000);
                                                                setTimeout(() => {
                                                                    $('.success-image1').css('display', 'none')
                                                                }, 3000);
                                                                setTimeout(() => {
                                                                    $('.success-image3').css('display', 'none')
                                                                }, 3000);
                                                            } else if (x == 2) {
                                                                $('.success-image3').css('display', 'block');
                                                                $('.success-image2').css('display', 'none')
                                                                $('.success-image1').css('display', 'none')
                                                                setTimeout(() => {
                                                                    $('.success-image3').css('display', 'none')
                                                                }, 3000);
                                                                setTimeout(() => {
                                                                    $('.success-image2').css('display', 'none')
                                                                }, 3000);
                                                                setTimeout(() => {
                                                                    $('.success-image1').css('display', 'none')
                                                                }, 3000);
                                                            }
                                                            /* End Popup */
                                                        }
                                                    });


                                                } else {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: '{{ route('admin.subtasks.update_status') }}',
                                                        data: {
                                                            id: id,
                                                            task_id: task_id,
                                                            deletedcomment: false,
                                                            _token: '{{ csrf_token() }}'
                                                        },
                                                        success: function (data) {
                                                            $('#task' + task_id).html('');
                                                            $('#task' + task_id).html(data.options);
                                                            /* Add Popup Success */
                                                            var x = Math.floor(Math.random() * 3);
                                                            if (x == 0) {
                                                                $('.success-image1').css('display', 'block');
                                                                $('.success-image2').css('display', 'none');
                                                                $('.success-image3').css('display', 'none');
                                                                setTimeout(() => {
                                                                    $('.success-image1').css('display', 'none')
                                                                }, 3000);
                                                                setTimeout(() => {
                                                                    $('.success-image2').css('display', 'none')
                                                                }, 3000);
                                                                setTimeout(() => {
                                                                    $('.success-image3').css('display', 'none')
                                                                }, 3000);

                                                            } else if (x == 1) {
                                                                $('.success-image2').css('display', 'block');
                                                                $('.success-image1').css('display', 'none');
                                                                $('.success-image3').css('display', 'none');
                                                                setTimeout(() => {
                                                                    $('.success-image2').css('display', 'none')
                                                                }, 3000);
                                                                setTimeout(() => {
                                                                    $('.success-image1').css('display', 'none')
                                                                }, 3000);
                                                                setTimeout(() => {
                                                                    $('.success-image3').css('display', 'none')
                                                                }, 3000);
                                                            } else if (x == 2) {
                                                                $('.success-image3').css('display', 'block');
                                                                $('.success-image2').css('display', 'none')
                                                                $('.success-image1').css('display', 'none')
                                                                setTimeout(() => {
                                                                    $('.success-image3').css('display', 'none')
                                                                }, 3000);
                                                                setTimeout(() => {
                                                                    $('.success-image2').css('display', 'none')
                                                                }, 3000);
                                                                setTimeout(() => {
                                                                    $('.success-image1').css('display', 'none')
                                                                }, 3000);
                                                            }
                                                            /* End Popup */
                                                        }
                                                    });
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

                            function load() {}

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
                                            $('.subtask_count'+data.subtask_id).css('visibility' , 'visible') ;
                                            $('.TaskTitle').click(function (e) {
                                                e.preventDefault();
                                                $subtask_id = $(this).data('id');
                                                $('.main-tasks').css('display', 'none');
                                                $('#tabcomments').css('display', 'block');
                                                $.ajax({
                                                    type: "POST",
                                                    url: '{{route('admin.comments.getTaskComments')}}',   // need to create this post route
                                                    cache: false,
                                                    data: {subtask_id: $subtask_id},
                                                    success: function (data) {
                                                        $('#tabcomments').html(data.options);
                                                    },
                                                    error: function (jqXHR, status, err) {
                                                    },
                                                });
                                            })
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
                                    subtask_id = $(this).data('id');
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
                                function createNewTask(text, isComplete){

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
                                    responsiple.className = "mySelect2 subtasks_users custom_select";
                                    responsiple.name = "TaskResponsiple";

                                    let users2 = [];
                                    users2.push("<option>Select</option>");

                                    <?php
                                    $url = url('/');
                                    $ld = $last_subtask_id + $SD;
                                    foreach ($users as $user) { ?>
                                    users2.push("<?php echo "<option value='$user->id' data-image= '$url/public/assets/images/users/$user->image'> $user->user_name</option>" ?>");
                                    <?php } ?>

                                        responsiple.innerHTML = users2.join("");

                                    $(".custom_select").select2({
                                        templateResult: formatOption,
                                        templateSelection: formatSelection
                                    });

                                    function formatOption(option) {
                                        if (!option.id) {
                                            return option.text;
                                        }

                                        var imageSrc = $(option.element).data('image');
                                        if (!imageSrc) {
                                            return option.text;
                                        }

                                        return $('<span><img src="' + imageSrc + '" class="select-image" /> ' + option.text + '</span>');
                                    }

                                    function formatSelection(selectedOption) {
                                        if (!selectedOption.id) {
                                            return selectedOption.text;
                                        }

                                        var imageSrc = $(selectedOption.element).data('image');
                                        if (!imageSrc) {
                                            return selectedOption.text;
                                        }

                                        return $('<span><img src="' + imageSrc + '" class="selected-image" /> ' + selectedOption.text + '</span>');
                                    }


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


                                    // Create the button
                                    let button = document.createElement("button");
                                    button.className = "btn btn-icon btn-primary TaskTitle custom_comments_count subtask_count" + (xx + ic);
                                    button.setAttribute("data-id", xx + ic);


                                    let icon = document.createElement("i");
                                    icon.className = "fa fa-comments"; // Replace with the actual icon class
                                    button.appendChild(icon);


                                    button.addEventListener("click", function () {
                                        const dataId = this.getAttribute("data-id");
                                        const url = `javascript:void(0);`; // Replace with the desired link logic
                                        window.location.href = url; // Navigate to the URL if needed
                                    });

                                    task.appendChild(button);
                                    task.appendChild(deleteicones);
                                    task.appendChild(dropdown);
                                    task.appendChild(dragBtn);
                                    task.appendChild(checkBox);
                                    task.appendChild(descr);
                                    task.appendChild(date);
                                    task.appendChild(responsiple);
                                    task.appendChild(resinput);
                                    task.appendChild(button);



                                    $(".subtasks_users").each(function () {
                                        $(this).on('change', function () {

                                            resp_val = $(this).val();
                                            subtask_id = $(this).data('id');
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
                                                $(this).next('.ui-datepicker-trigger').css("visibility", "hidden");
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


                                            }
                                        });
                                    });

                                    $('.calender label').on('click', function () {
                                        $(this).next(".hiddenInput").datepicker("show");
                                    });


                                    $('.dd-click-off-close').css('display', 'none');

                                    $(".subtask_count").css('display', 'block');

                                    $('.slick').ddslick({

                                        onSelect: function (selectedData) {
                                            let xxx = task.children[POS_CHECKBOX].getAttribute('data-id');
                                            let resp_val = selectedData.selectedData.value;
                                            let subtask_id = xxx - 1;
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
            </div>
        </div>
    </div>
    <!-- Sidebar -->
</header>
<!--Main Navigation-->

<!--Main layout-->
<main style="margin-top: 58px;">
    <div class="container pt-4"></div>
</main>
<script>

    //add  comment
    $('.add-comment').click(function () {
        $('#sidebarMenu .comments').css('display', 'block');
        $('#sidebarMenu').animate({
            scrollTop: $("#sidebarMenu .comments").offset().top - 100
        }, 200);
        $('#commentbox').focus();
        $subtask_id = $(this).data('id');
        $('#hidden_subtask').val($subtask_id);
    });


    $(document).ready(function () {

        /* Change Task Tested */
        $(document).on('click', '.tested', function () {

            $.ajax({
                url: '{{route('admin.subtasks.tested')}}',
                type: "POST",

                data: {
                    subtask_id: $(this).data('id'),
                    value: $(this).val(),
                    _token: '{{ csrf_token() }}'
                },
                cache: false,
                success: function (data) {
                },
                error: function (jqXHR, status, err) {
                },
            });

        });
        /*End Task tested*/

        //start Clik why close comment
        $('.doneerledigt').unbind().click(function () {
            var comment_id = $(this).data('id');
            var addedby = "{{Auth::user()->first_name}}";
            var task_id = $("#task_id").val();
            var comment_author = $('.comments-list' + comment_id).data('author');
            var replay = $('#erigate' + comment_id).val();
            if (replay == '' || replay.length < 50) {
                $('.alert' + comment_id).css('display', 'block');
            } else {
                $.ajax({
                    url: '{{route('admin.comments.donecomment')}}',
                    type: "POST",
                    data: {
                        comment_id: $(this).data('id'),
                        doneby: "{{auth::user()->id}}",
                        value: 1,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        /* send As Replay */
                        $.ajax({
                            url: '{{route('admin.subtasks.store_replay')}}',
                            method: "POST",
                            data: {
                                tags: null,
                                addedby: addedby,
                                comment_id: comment_id,
                                replay_comment: replay,
                                task_id: task_id,
                                comment_author: comment_author,
                                _token: '{{ csrf_token() }}'
                            },

                            success: function (response) {
                                var li_elem = document.createElement('li');

                                var image = document.createElement('div');
                                image.className = "comment-avatar";

                                var innerimage = document.createElement('img');
                                innerimage.setAttribute('src', "{{asset('public/assets/images/users/'.auth::user()->image)}}");
                                image.appendChild(innerimage);


                                var comment_box = document.createElement('div');
                                comment_box.className = "comment-box";

                                var comment_head = document.createElement('div');
                                comment_head.className = "comment-head";
                                comment_box.appendChild(comment_head);

                                var comment_name = document.createElement('h6');
                                comment_name.className = "comment-name";
                                comment_head.appendChild(comment_name);

                                var spantime = document.createElement('span');
                                spantime.innerText = 'Now';
                                comment_head.appendChild(spantime);

                                var hyperlink = document.createElement('a');
                                hyperlink.innerText = "{{auth::user()->first_name}}";
                                comment_name.appendChild(hyperlink);


                                var content = document.createElement('div');
                                content.className = "comment-content";
                                content.innerText = replay;

                                comment_box.appendChild(content);
                                li_elem.appendChild(image);


                                li_elem.appendChild(comment_box);
                                $('#exampleModal' + comment_id).modal('toggle');
                                $('.reply-list' + comment_id).append(li_elem);
                                $('.reply-list' + comment_id).css({'display': 'block'});

                                $('.comments-list' + comment_id).css('display', 'none');

                            },
                            error: function () {

                            }

                        });


                    },
                    error: function (jqXHR, status, err) {
                    },
                });
            }

        });


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

        // Add Or Remove Team Member
        $('#edit_subtask .target').on('change', function () {
            var task_id = $('#task_id').val();
            var field_name = $(this).data('name');
            var field_val = $(this).val();
            $.ajax({
                type: "post",
                url: "{{route('admin.tasks.update_field')}}", // need to create this post route
                data: {task_id: task_id, field_name: field_name, field_val: field_val, _token: '{{ csrf_token() }}'},
                cache: false,
                success: function (data) {
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


        Dropzone.autoDiscover = false;

        // Initialize Dropzone with autoProcessQueue disabled
        var myDropzone = new Dropzone("#imageUpload", {
            url: "{{ route('admin.subtasks.store_image') }}",
            maxFiles: 5,
            maxFilesize: 5, // Maximum size in MB
            acceptedFiles: "image/*",
            dictDefaultMessage: "Drag and drop images here or click to upload",
            addRemoveLinks: true,
            autoProcessQueue: false, // Disable automatic upload
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        });

        // Active And Disactive textarea
        $('.replaystyle').each(function () {
            $(this).on('keyup', function () {
                if ($(this).val().length > 0) {
                    $('#send_replay' + $(this).data('id')).prop('disabled', false);
                } else {
                    $('#send_replay' + $(this).data('id')).prop('disabled', true);
                }
            })
        });

        $('.send_replay').each(function () {
            $(this).on('click', function () {
                $(this).prop('disabled', true);
                var addedby = "{{Auth::user()->first_name}}";
                var comment_id = $(this).data('id');
                var replay_comment = $('.replay_comment' + comment_id).val();
                var replay_formattedValue = replay_comment.replace(/\n/g, '<br>');


                var comment_author = $('.comments-list' + comment_id).data('author');
                var task_id = $("#task_id").val();
                var tagsc = $('#replay_tags_'+comment_id).val();
                var tagstring = tagsc.toString();
                /*create  replay box */
                var li_elem = document.createElement('li');
                var image = document.createElement('div');
                image.className = "comment-avatar";

                var innerimage = document.createElement('img');
                innerimage.setAttribute('src', "{{asset('public/assets/images/users/'.auth::user()->image)}}");
                image.appendChild(innerimage);


                var comment_box = document.createElement('div');
                comment_box.className = "comment-box";

                var comment_head = document.createElement('div');
                comment_head.className = "comment-head";
                comment_box.appendChild(comment_head);

                var controles = document.createElement('div');
                controles.className = "controls";

                var del_replay = document.createElement('span');
                del_replay.className = "delete-replay";


                var delicon = document.createElement('i');
                delicon.className = "fa fa-trash";

                del_replay.appendChild(delicon);
                controles.appendChild(del_replay);

                var edit_replay = document.createElement('span');
                edit_replay.className = "edit-replay";

                var editicon = document.createElement('i');
                editicon.className = "fa fa-edit";

                edit_replay.appendChild(editicon);
                controles.appendChild(edit_replay);


                comment_head.appendChild(controles);


                var comment_name = document.createElement('h6');
                comment_name.className = "comment-name";
                comment_head.appendChild(comment_name);

                var spantime = document.createElement('span');
                spantime.innerText = 'Now';
                comment_head.appendChild(spantime);

                var hyperlink = document.createElement('a');
                hyperlink.innerText = "{{auth::user()->first_name}}";
                comment_name.appendChild(hyperlink);


                var content = document.createElement('div');
                content.className = "comment-content";
                content.innerText = replay_comment;

                var tags_footer = document.createElement('div');
                tags_footer.className = "tags_footer";


                $('#selectator_select' + comment_id + ' .selectator_selected_items').children('.selectator_selected_item').each(function () {
                    var tag_name = document.createElement('span');
                    tag_name.className = "tagname";
                    tag_name.innerText = '@' + $(this).find('.selectator_selected_item_title').text();
                    tags_footer.appendChild(tag_name);
                });


                content.appendChild(tags_footer);
                comment_box.appendChild(content);


                li_elem.appendChild(image);
                li_elem.appendChild(comment_box);

                $('.reply-list' + comment_id).append(li_elem);

                $('.reply-list' + comment_id).css({'display': 'block'});

                $('.replay_comment' + comment_id).val(' ');

                /*End Replay box*/


                $.ajax({
                    url: '{{route('admin.subtasks.store_replay')}}',
                    method: "POST",
                    data: {
                        tags: tagstring,
                        addedby: addedby,
                        comment_id: comment_id,
                        replay_comment: replay_formattedValue,
                        task_id: task_id,
                        comment_author: comment_author,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {

                        $(".replayes_count" + comment_id + " p span").text(data['count']);
                        del_replay.setAttribute('data-id', data['id']);
                        del_replay.classList.add('delete-replay' + data['id']);
                        comment_box.classList.add('comment-box' + data['id']);
                        /* Delete Added Replay   */
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

                                                    $(".comment-box" + id).parent('li').css('display', 'none');
                                                }
                                            });
                                            swal("Deleted!", {
                                                icon: "success",
                                            });

                                        }

                                    });

                            });
                        });

                    },
                    error: function () {
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
                    }
                });


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
            $('.submit_comment').html("Sending...");

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
                    $(".filupp-file-name").text("1 - Datei einfügen");
                    //document.getElementById("myForm").reset();
                    $('.submit_comment').html("{{__('messages.upload_photo')}}");
                    $('#dataup').trigger("reset");

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
<script>
    $(document).ready(function () {

        var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
            enableTime: true,
            dateFormat: "d.m.Y  H:i",
        });

        $('.add_replay').each(function () {
            $(this).unbind().on('click', function () {
                var comment_id = $(this).data('id');
                $.ajax({
                    url: '{{route('admin.comments.viewreplays')}}',
                    type: 'post',
                    data: {comment_id: comment_id, _token: '{{ csrf_token() }}'},
                    cache: false,
                    success: function (data) {
                        $('#replyalist' + comment_id).html(data.options);
                        $('#replyalist' + comment_id).toggle();

                        // Edit Replays
                        $('.edit-replay').each(function () {
                            $(this).on("click", function () {

                                var cmid = $(this).data('id');
                                $(".replaytext" + cmid).attr("contenteditable", "true");
                                $(".replaytext" + cmid).css({"border": "1px solid #ccc", "padding": '3px'});
                                $(".edit_replay_button" + cmid).css('display', 'block');
                            });
                        });

                        /* Edit Replay Button */
                        $('.edit_replay_button').each(function () {
                            $(this).on('click', function () {
                                var replay_id = $(this).data('id');
                                var replay_text = $('.replaytext' + replay_id).text();
                                $.ajax({
                                    type: "POST",
                                    url: '{{route('admin.comments.editreplay')}}', // need to create this post route
                                    data: {id: replay_id, replay_text: replay_text, _token: '{{ csrf_token() }}'},
                                    cache: false,
                                    success: function (data) {
                                        $('.replayalert' + replay_id).text('Replay Updated Successfuly');
                                    },
                                    error: function (jqXHR, status, err) {
                                    },
                                });

                            });
                        });
                        //For Deleting Replay
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
                                                    $(".comment-box" + id).parent('li').css('display', 'none');
                                                }
                                            });
                                            swal("Deleted!", {
                                                icon: "success",
                                            });

                                        }

                                    });

                            });
                        });

                    },
                    error: function () {

                    }
                });
                $('.add_new_replay' + $(this).data('id')).css("display", "block");

            });
        });

        /* Replay  Tags */
        $('.replay_tags').each(function () {
            $(this).on('change', function () {
                var replay_id = $(this).data('id');
                var tagsc = $(this).val();
                var tagstring = tagsc.toString();
                $.ajax({
                    url: '{{route('admin.comments.savetags')}}',
                    type: 'post',
                    data: {replay_id: replay_id, tags: tagstring, _token: '{{ csrf_token() }}'},
                    cache: false,
                    success: function (data) {

                    },
                    error: function () {

                    }
                })
            });

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

        /* Toggle Commennts */
        $('.cb-value2').click(function () {
            if ($(this).is(':checked')) {

                $('.uncompleted_comments').css('display', 'none');
                $('.completed_comments').css('display', 'block');
            } else {
                $('.uncompleted_comments').css('display', 'block');
                $('.completed_comments').css('display', 'none');
            }
        });


        $('.edit_comment').each(function () {
            $(this).on("click", function () {
                var cmid = $(this).data('id');
                $("#comment_name" + cmid).attr("contenteditable", "true");
                $("#comment_name" + cmid).css("border", "1px solid #ccc");
                $(".update_btn" + cmid).css("display", "initial");


            });
        });


        /* Update Comment */
        $('.update_comment_btn').on('click', function () {
            var id = $(this).data('id');

            $('.commenttext' + id).html($('.comment-content' + id).text().replace(/\n/g, "<br>"));
            var comment_text = $('.commenttext' + id).html();

            $.ajax({
                type: "POST",
                url: '{{route('admin.comments.update')}}', // need to create this post route
                data: {id: id, comment_name: comment_text, _token: '{{ csrf_token() }}'},
                cache: false,
                success: function (data) {
                    $('.comment_updated' + id).css("display", "initial");
                    setTimeout(() => {
                        $('.comment_updated' + id).css("display", "none");
                    }, 1500);
                },
                error: function (jqXHR, status, err) {
                },
            });
        });

        $('.del_comment').each(function () {
            $(this).on("click", function () {
                var id = $(this).data('id');

                swal({
                    title: "{{__('messages.delete comment')}}",
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
                                    $('comments-list' + id).css('display', 'none');
                                }
                            });
                            swal("Es wurde bereits gelöscht!", {
                                icon: "success",
                            });
                            //window.location.reload();
                            $(".comments-list" + id).css('display', 'none');
                            $(".add_new_replay" + id).css('display', 'none');
                        } else {

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
                                    $(".comment-box" + id).parent('li').css('display', 'none');
                                }
                            });
                            swal("Deleted!", {
                                icon: "success",
                            });

                        }

                    });

            });
        });


        var Selected_tags = [];
        // On Change  on Category
        $('#task_category_one').on('change', function () {

            $category_id = $(this).val();
            $task_id = $(this).data('task-id');

            $.ajax({
                url: '{{route('admin.tags.getCategoryTag')}}',
                method: "POST",
                data: {_token: '{{ csrf_token() }}', task_id: $task_id, category_id: $category_id},
                success: function (response) {
                    $('#select6').html(response.options);
                }
            });
        });


        $('#task_category_two').on('change', function () {

            $category_id = $(this).val();
            $task_id = $(this).data('task-id');

            $.ajax({
                url: '{{route('admin.tags.getCategoryTag')}}',
                method: "POST",
                data: {_token: '{{ csrf_token() }}', task_id: $task_id, category_id: $category_id},
                success: function (response) {

                }
            });
        });

        $("#imageUpload-1").change(function () {
            $.readURL(this);
            $('.upload_post_image').css('display', 'block');
        });

        $('.remove-image-privew').on('click', function () {
            var task_id = $(this).data('id');
            var el = $(this);
            $.ajax({
                url: '{{route('admin.tasks.removebackgroundImage')}}',
                method: "POST",
                data: {_token: '{{ csrf_token() }}', task_id: task_id},
                success: function (response) {
                    el.parents('#imageUpload-1-preview').css('display', 'none');
                    $('.upload_post_image').css('display', 'none');
                }
            });
        });
// UPLOAD images
        $.extend({
            readURL: function (input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    var input_name = "#" + $(input).attr('id') + "-preview";
                    reader.onload = function (e) {
                        $(input_name).css('background-image', 'url(' + e.target.result + ')');
                        console.log(this);
                        $(input_name).css("background-size", "cover");
                        $(input_name).css("background-position", "center center");
                        $(input_name).show();
                        $(input_name + "> div > button").click(function () {
                            $(input_name).hide();
                            $(input).val("");
                            $(input_name).css('background-image', 'url()');
                        });
                    }
                    reader.readAsDataURL(input.files[0]);
                }

            }

        });

        var filename = $('#image-upload').val();
        if (filename == "") {
            $("#image-preview").hide()
        }
        $('#image-upload').change(function () {
            var filename = $('#image-upload').val();
            if (filename != "") {
                $("#image-preview").show()
            } else {
                $("#image-preview").hide()
            }
        });

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
        $('.mySelect2').select2({
            templateResult: formatOption,
            templateSelection: formatSelection
        });

        function formatOption(option) {
            if (!option.id) {
                return option.text;
            }

            var imageSrc = $(option.element).data('image');
            if (!imageSrc) {
                return option.text;
            }

            return $('<span><img src="' + imageSrc + '" class="select-image" /> ' + option.text + '</span>');
        }

        function formatSelection(selectedOption) {
            if (!selectedOption.id) {
                return selectedOption.text;
            }

            var imageSrc = $(selectedOption.element).data('image');
            if (!imageSrc) {
                return selectedOption.text;
            }

            return $('<span><img src="' + imageSrc + '" class="selected-image" /> ' + selectedOption.text + '</span>');
        }
    });
</script>


<!--Start Team Members Multi select-->
<script>
    $(document).ready(function () {
        $('#userSelect').select2({
            templateResult: formatUser, // Custom function to display images
            templateSelection: formatUserSelection // Custom function for selected images
        });

        function formatUser(user) {
            if (!user.id) {
                return user.text;
            }
            var $user = $(
                '<span><img class="user-image" src="' + $(user.element).data('image') + '" /> ' + user.text + '</span>'
            );

            return $user;
        }

        function formatUserSelection(user, container) {
            if (!user.id) {
                return user.text;
            }
            var $selectedUser = $(
                '<span><img class="user-image" src="' + $(user.element).data('image') + '" /> ' + user.text + '</span>'
            );

            // Hide the selected option in the dropdown
            if ($(container).hasClass('select2')) {
                container.style.display = 'none';
            }
            return $selectedUser;
        }
        // Handle removal of items
        $('#userSelect').on('select2:unselect', function (e) {
            // Remove the option from the original select element
            $(this).find('option[value="' + e.params.data.id + '"]').remove();
        });
    });
</script>
<!--Select  Guest on nMult Select  -->
<script>
    $(document).ready(function () {
        $('#userguest').select2({
            templateResult: formatUserResult, // Custom function to display images
            templateSelection: formatUserSelection // Custom function for selected images
        });

        function formatUserResult(user) {
            if (!user.id) {
                return user.text;
            }
            var $userResult = $(
                '<span><img class="user-image" src="' + $(user.element).data('image') + '" /> ' + user.text + '</span>'
            );

            return $userResult;
        }

        function formatUserSelection(user, container) {
            if (!user.id) {
                return user.text;
            }
            var $selectedUser = $(
                '<span><img class="user-image" src="' + $(user.element).data('image') + '" /> ' + user.text + '</span>'
            );

            // Hide the selected option in the dropdown
            if ($(container).hasClass('select2')) {
                container.style.display = 'none';
            }
            return $selectedUser;
        }

        // Handle removal of items
        $('#userguest').on('select2:unselect', function (e) {
            // Remove the option from the original select element
            $(this).find('option[value="' + e.params.data.id + '"]').remove();
            $('#userguest').trigger('change'); // Trigger change to update Select2
        });
    });
</script>

<!--Comment Tags -->
<script>
    $(document).ready(function () {
        $('#commentTag').select2({
            templateResult: formatTagUser, // Custom function to display images
            templateSelection: formatTagUserSelection // Custom function for selected images
        });

        function formatTagUser(Taguser) {
            if (!Taguser.id) {
                return Taguser.text;
            }
            var $Taguser = $(
                '<span><img class="user-image" src="' + $(Taguser.element).data('image') + '" /> ' + Taguser.text + '</span>'
            );

            return $Taguser;
        }
        function formatTagUserSelection(Taguser, Tagcontainer) {
            if (!Taguser.id) {
                return Taguser.text;
            }
            var $selectedTaguser = $(
                '<span><img class="user-image" src="' + $(Taguser.element).data('image') + '" /> ' + Taguser.text + '</span>'
            );

            // Hide the selected option in the dropdown
            if ($(Tagcontainer).hasClass('select2')) {
                Tagcontainer.style.display = 'none';
            }
            return $selectedTaguser;
        }

        // Handle removal of items
        $('#commentTag').on('select2:unselect', function (e) {
            // Remove the option from the original select element
            $(this).find('option[value="' + e.params.data.id + '"]').remove();
            $('#commentTag').trigger('change'); // Trigger change to update Select2
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#categoryselect').selectize();
    });
</script>

<script>
    // Map to hold files for each popup
    const fileStorage = new Map();

    function getFilesForPopup(popupId) {
        if (!fileStorage.has(popupId)) fileStorage.set(popupId, []);
        return fileStorage.get(popupId);
    }

    document.addEventListener("click", (evt) => {
        const dropZone = evt.target.closest(".drop-zone");
        if (dropZone) {
            const container = dropZone.closest(".drop-zone-container");
            container.querySelector(".standard-upload-files").click();
        }
    });

    document.addEventListener("dragover", (evt) => {
        if (evt.target.matches(".drop-zone")) {
            evt.preventDefault();
        }
    });

    document.addEventListener("drop", (evt) => {
        const dropZone = evt.target.closest(".drop-zone");
        if (dropZone) {
            evt.preventDefault();
            const container = dropZone.closest(".drop-zone-container");
            const showSelectedImages = container.querySelector(".show-selected-images");
            const popupId = container.closest(".popup").id;
            const files = getFilesForPopup(popupId);

            const droppedFiles = evt.dataTransfer.files;
            if (droppedFiles.length) {
                files.push(...droppedFiles);
                [...droppedFiles].forEach(file => updateThumbnail(file, showSelectedImages, files));
            }
        }
    });

    document.addEventListener("change", (evt) => {
        const input = evt.target.closest(".standard-upload-files");
        if (input) {
            const container = input.closest(".drop-zone-container");
            const showSelectedImages = container.querySelector(".show-selected-images");
            const popupId = container.closest(".popup").id;
            const files = getFilesForPopup(popupId);

            files.push(...input.files);
            [...input.files].forEach(file => updateThumbnail(file, showSelectedImages, files));
        }
    });

    function updateThumbnail(file, showSelectedImages, files) {
        if (file.type.startsWith("image/")) {
            const wrapper = document.createElement("figure");
            const removeBtn = document.createElement("div");
            const thumbnail = new Image();

            // Set up remove button
            removeBtn.classList.add("remove-image");
            removeBtn.innerHTML =
                '<svg id="remove-x" viewBox="0 0 150 150"><path fill="#000" d="M147.23,133.89a9.43,9.43,0,1,1-13.33,13.34L75,88.34,16.1,147.23A9.43,9.43,0,1,1,2.76,133.89L61.66,75,2.76,16.09A9.43,9.43,0,0,1,16.1,2.77L75,61.66,133.9,2.77a9.42,9.42,0,1,1,13.33,13.32L88.33,75Z"/></svg>';

            // Set up thumbnail image
            thumbnail.src = URL.createObjectURL(file);
            thumbnail.classList.add("drop-zone__thumb");
            thumbnail.onload = () => URL.revokeObjectURL(thumbnail.src);

            // Append elements
            wrapper.append(removeBtn, thumbnail);
            showSelectedImages.append(wrapper);

            // Remove file from list when clicked
            removeBtn.addEventListener("click", () => {
                const index = files.indexOf(file);
                if (index > -1) files.splice(index, 1);
                wrapper.remove();
            });
        }
    }

    document.addEventListener("submit", (evt) => {
        const form = evt.target.closest("#upload-images-form");
        if (form) {
            evt.preventDefault(); // Prevent default form submission

            // Get the popup ID (assuming the popup is open)
            const popupId = document.querySelector('.popup').id;
            const files = getFilesForPopup(popupId);

            // Create a FormData object to hold form data and files
            const formData = new FormData();

            // Append selected files to FormData
            files.forEach(file => formData.append("standard-upload-files[]", file));

            // Get other form values
            const subtask_id = document.getElementById("hidden_subtask").value;
            const comment = document.getElementById("commentbox").value;
            const tags = $('#commentTag').val(); // Use jQuery for Select2
            const task_id = document.getElementById("add_comment").dataset.task;

            formData.append("subtask_id", subtask_id);
            formData.append("comment", comment);
            formData.append("tags", tags.join(","));
            formData.append("task_id", task_id);
            formData.append("_token", "{{ csrf_token() }}");

            // AJAX submission
            $.ajax({
                type: "POST",
                url: "{{ route('admin.subtasks.store_comment') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: (response) => {
                    console.log("Success:", response);

                    // Reset the form and clear selections
                    form.reset(); // Reset the form
                    $(".show-selected-images").empty(); // Clear image previews
                    $("#commentTag").val([]).trigger('change'); // Reset Select2 tags

                    // Reset the file input field (important)
                    const fileInput = form.querySelector(".standard-upload-files");
                    if (fileInput) {
                        fileInput.value = ""; // Clear the file input value
                    }

                    // Clear file storage to ensure no files remain
                    const fileStorage = new Map();
                    fileStorage.set(popupId, []); // Reset the file map for the current popup

                    // Hide task section and show comments section
                    $(".main-tasks").hide();
                    $("#tabcomments").show();

                    // Reload comments section
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.comments.getTaskComments') }}",
                        data: { subtask_id },
                        success: (data) => {
                            $("#tabcomments").html(data.options);
                        },
                        error: (jqXHR, status, err) => {
                            console.error(err);
                        },
                    });
                },
                error: (jqXHR, status, err) => {
                    console.error("Error:", err);
                },
            });
        }
    });

    // Additional code for the drag-and-drop functionality
    document.addEventListener("drop", (evt) => {
        const dropZone = evt.target.closest(".drop-zone");
        if (dropZone) {
            evt.preventDefault();
            const container = dropZone.closest(".drop-zone-container");
            const showSelectedImages = container.querySelector(".show-selected-images");
            const popupId = container.closest(".popup").id;
            const files = getFilesForPopup(popupId);

            const droppedFiles = evt.dataTransfer.files;
            if (droppedFiles.length) {
                files.push(...droppedFiles);
                [...droppedFiles].forEach(file => updateThumbnail(file, showSelectedImages, files));
            }
        }
    });
    
</script>


