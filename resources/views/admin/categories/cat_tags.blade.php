
                <div class="swiper-slide cat_list" style="margin-right:5px;">
                              <div class="category-button  active filter" data-type ="category"  data-id="{{$cat->id}}" data-status="{{$status}}">
                                   {{$cat->category_name}}
                              </div>
                          </div>

                  @if(!empty($tags))
                      @foreach($tags as $tag)
                            <div class="swiper-slide cat_list" style="margin-right:5px;">
                                <div class="category-button  filter" data-type ="tag"  data-status="{{$status}}"  data-id="{{$tag->id}}">
                                  {{$tag->tag_name}}
                                </div>
                            </div>

                        @endforeach
                  @endif


    <script>
$(document).ready(function () {



     $(".category-button").on('click',function (event) {

              var id = $(this).data('id');
              var status = $(this).data('status');
               var type = $(this).data('type');
             // alert(id);
              $.ajax({

                      type: "POST",
                      url:   '{{route('admin.filter_by_category')}}',   // need to create this post route
                      data: {id: id,status:status,type:type, _token: '{{ csrf_token() }}'},
                     cache: false,
                      success: function (data) {

                         $('.cat_list li').removeClass('selected mixitup-control-active');
                         $('.cat_list li[data-id='+id+']').addClass('selected mixitup-control-active');
                         $('#shuffle').html('');
                          $('#shuffle').html(data.options);

                      },
                      error: function (jqXHR, status, err) {


                      },
                });
        });


});

</script>
