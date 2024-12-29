
function searchToggle(obj,evt){
    evt.preventDefault()
    let container = $(obj).closest('.search-wrapper');
    if(!container.hasClass('active')){
        container.addClass('active');
    }else if(container.hasClass('active') && $(obj).closest('.input-holder').length == 0){
        container.removeClass('active');
        $('.search-input').focus() ;
    }
}
// ----------swiper-slider---------
var swiper = '';
$(window).on('load', function(){
    swiper = new Swiper('#catgory-slider', {
        loop: false,
        slidesPerView: "auto",
        allowTouchMove: false,
        spaceBetween: 5,
        mousewheel: true,
        slideToClickedSlide: true,
        centeredSlides: false,
        navigation: {
            nextEl: '.slider-next',
            prevEl: '.slider-prev',
        }
    });

  $('.loading').fadeOut(500);
});




    /*upload file*/




    (function($){

        $(window).on('click' , function(event){

            if(!$(event.target).hasClass('searchclick') && !$(event.target).hasClass('search-wrapper') && !$(event.target).hasClass('input-holder')  && !$(event.target).hasClass('search-input')    )
            {
                $('.search-wrapper').removeClass('active');
            }else
            {
                $('#search-input').focus() ;
            }

        });


          $(document).on("click", ".browse", function() {
  var file = $(this)
    .parent()
    .parent()
    .parent()
    .find(".file");
  file.trigger("click");
});
$(document).on("change", ".file", function() {
  $(this)
    .parent()
    .find(".form-control")
    .val(
      $(this)
        .val()
        .replace(/C:\\fakepath\\/i, "")
    );
});


    // $('.btn-upload').on('click', function() {
    //     $('.file').trigger('click');
    // });

    // $('.file').on('change', function() {
    //     var fileName = $(this)[0].files[0].name;
    //     $('#file-name').val(fileName);
    // });

    })(jQuery);



$(document).ready(function(){

  "use strict";

  /*Start  Multi  */

  new Sortable(shuffle, {
	   animation: 300 ,
       selectedClass: 'selected' ,
       onUpdate:function(){
               var list = new Array();
                $('#shuffle').find('.ui-state-default').each(function(){
                     var id=$(this).attr('data-id');
                     list.push(id);
                });

                 $.ajax({
                         headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         },
                        url: 'admin/tasks/save_perority',
                        method:"POST",
                        data:{list:list},

                        success:function(data)
                        {
                        // alert(data);
                        }
                       });
       }
  } ,



  );

  $('#sidebarMenu .dismiss').on('click' , function(){
    $('#sidebarMenu').attr("style", "display: none !important");

  });


      $(document).on('click','#save-reorder',function(){
        var list = new Array();
        $('#shuffle').find('.ui-state-default').each(function(){
             var id=$(this).attr('data-id');
             list.push(id);
        });


        var data=JSON.stringify(list);
        console.log(data) ;

        $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        } ,
        type: 'POST',
        url: $(this).data('prop'),
        data: {data:data }, // data to send in ajax format or querystring format
        datatype: 'json',
        success: function(message) {
            alert(message);
        }

    });

    });




                                $(document).on('click','.wrapper .item p[data-id="editable-list-item"]', function() {

                                          var $input = $('<input type="text" data-id="editable-list-item">');

                                          $input.val( $(this).html() );  // Input value = span value


                                          $(this).replaceWith($input);

                                          $input.focus();

                           });
                          $(document).on('focusout','.wrapper .item input[data-id="editable-list-item"]', function() {

                                          var $p = $('<p data-id="editable-list-item">');
                                          $p.html($(this).val());
                                          $(this).replaceWith($p);
                          });


                          $('input[type=radio][name=subtask_status]').on('change' , function(e) {

                                  e.preventDefault();
                                   var type = $(this).data('type');
                                   var subtask_status  = this.value;
                                   var start_due_date = $('.start_due_date').val();
                                   var end_due_date = $('.end_due_date').val();
                                   var subtask_user_id = $('#subtasks_users').val();

                                       $.ajax({

                                        type: "POST",
                                        url:   "{{route('admin.filter.usertasks')}}",
                                        data: {type : type , subtask_status:subtask_status,start_due_date:start_due_date,end_due_date:end_due_date,subtask_user_id:subtask_user_id, _token: '{{ csrf_token() }}'},
                                        cache: false,
                                        success: function (data) {

                                           $('.user_subtasks').html('');
                                            $('.user_subtasks').html(data.options);

                                        },
                                        error: function (jqXHR, status, err) {


                                        },
                                  });





                          });


});


var box  = document.getElementById('box');
var down = false;


function toggleNotifi(){
    if (down) {
        box.style.height  = '0px';
        box.style.opacity = 0;
        down = false;
    }else {
        box.style.height  = '510px';
        box.style.opacity = 1;
        down = true;
    }
}

