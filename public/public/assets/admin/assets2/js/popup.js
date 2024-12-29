<!--End Sidebar -->

<script>

$(document).ready(function () {
    //start Clik why close comment
    $(document).on('click','.doneerledigt' ,  function (e) {
        var comment_id =  $(this).data('id') ;
        var addedby = "{{Auth::user()->first_name}}" ;
        var task_id = $("#task_id").val();
        var comment_author =  $('.comments-list'+comment_id).data('author') ;
        var replay =  $('#erigate'+comment_id).val() ;
        if(replay == '' || replay.length < 50 ){
            $('.alert'+comment_id).css('display' , 'block') ;
        }else {
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
        var  task_id = $(this).data('task') ;
        $('#commentoutput').html($('#commentbox').val().replace(/\n/g, "<br>"));
        var comment = $('#commentoutput').html() ;
        var task_id = $("#task_id").val();
        var tags = $("#select55").val();
        var tagstring = tags.toString();
        /* Add New Comment  on js*/
        $.ajax({
            type: "post",
            url: "{{route('admin.subtasks.store_comment')}}", // need to create this post route
            data: {comment: comment, tags: tagstring, task_id: task_id, _token: '{{ csrf_token() }}'},
            cache: false,
            success: function (data) {

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

                liel.appendChild(rows) ;


                var replay_count =  document.createElement('div') ;
                replay_count.className = "replayes_count3021 replayes_count add_replay" ;
                replay_count.setAttribute('data-list' ,{{auth::user()->id}}) ;
                replay_count.setAttribute('data-id' , data['last_comment_id']) ;

                var paragrap =  document.createElement('p') ;
                var spancount =  document.createElement('span') ;
                spancount.innerHTML = '0' ;
                paragrap.appendChild(spancount) ;
                replay_count.appendChild(paragrap) ;

                liel.appendChild(replay_count);

                var add_replay =  document.createElement('div') ;
                add_replay.className = "add_replay" ;
                add_replay.setAttribute('data-id' , data['last_comment_id']) ;
                add_replay.innerText = 'Antworten' ;


                var replayicon =  document.createElement('i') ;
                replayicon.className = "bi bi-plus" ;
                add_replay.appendChild(replayicon) ;

                liel.appendChild(add_replay);

                $('#commentbox').val(' ') ;

                //Man Append to comments
                $('.comments2').prepend(comments_container);
                /*add Replay*/

                var type = '1';

                $.ajax({
                    type: "post",
                    url: "{{route('admin.get.task_data')}}", // need to create this post route
                    data: {id:task_id , type: type, _token: '{{ csrf_token() }}'},
                    cache: false,
                    success: function (data) {
                        $('#tasks').modal('show');
                        $('.overlay').css('display', 'block');
                        $(".sidebar-model").html(data);
                        $(".sidebar-model").css({'width': '50%'});
                        /*Start  Plugin */

                    }
                });

            },
            error: function (jqXHR, status, err) {
            },
        });

    });

    // Active And Disactive textarea
    $('.replaystyle').each(function(){
        $(this).on('keyup' ,function (){
            if($(this).val().length > 0) {
                $('#send_replay'+$(this).data('id')).prop('disabled', false);
            }else
            {
                $('#send_replay'+$(this).data('id')).prop('disabled', true);
            }
        })
    });



    $('.send_replay').each(function() {
        $(this).on('click' , function (){
            $(this).prop('disabled', true);
            var addedby = "{{Auth::user()->first_name}}" ;
            var comment_id =$(this).data('id') ;
            var  replay_comment = $('.replay_comment'+comment_id).val() ;
            var comment_author =  $('.comments-list'+comment_id).data('author') ;
            var task_id = $("#task_id").val();
            var tagsc =  $('#select'+comment_id).val() ;
            var tagstring = tagsc.toString();
            /*create  replay box */
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

            var controles   =  document.createElement('div') ;
            controles.className = "controls" ;

            var del_replay   =  document.createElement('span') ;
            del_replay.className = "delete-replay";


            var delicon   =  document.createElement('i') ;
            delicon.className = "fa fa-trash";

            del_replay.appendChild(delicon) ;
            controles.appendChild(del_replay) ;

            var edit_replay   =  document.createElement('span') ;
            edit_replay.className = "edit-replay";

            var editicon   =  document.createElement('i') ;
            editicon.className = "fa fa-edit";

            edit_replay.appendChild(editicon) ;
            controles.appendChild(edit_replay) ;



            comment_head.appendChild(controles) ;




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

            $('.replay_comment'+comment_id).val(' ') ;

            /*End Replay box*/


            $.ajax({
                url: '{{route('admin.subtasks.store_replay')}}',
                method: "POST",
                data: {tags:tagstring , addedby : addedby ,comment_id : comment_id ,replay_comment : replay_comment , task_id:task_id , comment_author :comment_author ,   _token: '{{ csrf_token() }}'},
                success: function (data) {

                    $(".replayes_count"+comment_id+" p span").text(data['count']);
                    del_replay.setAttribute('data-id', data['id']) ;
                    del_replay.classList.add('delete-replay'+data['id']) ;
                    comment_box.classList.add('comment-box'+data['id']) ;
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

<script>
$(document).ready(function () {

    var f2 = flatpickr(document.getElementsByClassName('dateTimeFlatpickr'), {
        enableTime: true,
        dateFormat: "d.m.Y  H:i",
    });



    $('.add_replay').on('click',function()
    {
        var comment_id  = $(this).data('id') ;
        $.ajax({
            url:'{{route('admin.comments.viewreplays')}}' ,
            type:'post' ,
            data:{comment_id: comment_id , _token: '{{ csrf_token() }}'} ,
            cache: false,
            success:function (data)
            {
                $('#replyalist'+comment_id).html(data.options);
                $('#replyalist'+comment_id).toggle() ;

                // Edit Replays
                $('.edit-replay').each(function () {
                    $(this).on("click", function () {
                        console.log('test edit') ;
                        var cmid = $(this).data('id');
                        $(".replaytext" + cmid).attr("contenteditable", "true");
                        $(".replaytext" + cmid).css({"border":"1px solid #ccc" , "padding":'3px'});
                        $(".edit_replay_button" + cmid).css('display', 'block');
                    });
                });

                /* Edit Replay Button */
                $('.edit_replay_button').each(function(){
                    $(this).on('click' , function(){
                        var replay_id  = $(this).data('id') ;
                        var  replay_text =  $('.replaytext'+ replay_id).text() ;
                        $.ajax({
                            type: "POST",
                            url: '{{route('admin.comments.editreplay')}}', // need to create this post route
                            data: {id: replay_id , replay_text: replay_text, _token: '{{ csrf_token() }}'},
                            cache: false,
                            success: function (data) {
                                $('.replayalert'+ replay_id).text('Replay Updated Successfuly') ;
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

            },
            error:function ()
            {

            }
        });
        $('.add_new_replay'+$(this).data('id')).css("display" , "block") ;


    });
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
                title: "Möchten Sie den Kommentar wirklich löschen?!",
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
                                $('comments-list'+id).css('display' , 'none');
                            }
                        });
                        swal("Es wurde bereits gelöscht!", {
                            icon: "success",
                        });
                        //window.location.reload();
                        $(".comments-list"+id).css('display', 'none');
                        $(".add_new_replay"+id).css('display', 'none');
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
