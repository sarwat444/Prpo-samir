@extends('layouts.dashboard')
@section('css')
@endsection
@section('title'){{$title}} @endsection
@section('content')
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

<section class="bg-diffrent">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="category-lists-slider">
                    <div class="swiper-container" id="catgory-slider">
                        <div class="swiper-wrapper" id="swiper">

                          <div class="swiper-slide cat_list">
                              <div class="category-button  active filter" data-type ="guest"  data-id="all" >
                                   Alle
                              </div>
                          </div>

                  @if(!empty($guestcats))
                      @foreach($guestcats as $guestcat)
                            <div class="swiper-slide cat_list">
                                <div class="category-button  filter" data-type ="guest"    data-id="{{$guestcat->id}}">
                                     {{$guestcat->category_name}}
                                </div>
                            </div>

                        @endforeach
                  @endif

                        </div>
                    </div>
                    <div class="slider-button slider-prev"><i class="fa fa-chevron-left"></i></div>
                    <div class="slider-button slider-next"><i class="fa fa-chevron-right"></i></div>
                </div>
            </div>
        </div>


    </div>


</section>
      <div class="cards" id="cards">


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

             <div class="row sortable-cards" id="shuffle">

               @if(!empty($tasks))


                  @foreach ($tasks as $key => $task)

                     <div class="col-md-3  sortable-divs mix ui-state-default {{$task->category->category_name}}" data-id="{{$task->id}}" id="task{{$task->id}}">
                     <div class="card sort"  @if(!empty($task->category->category_color) && !empty($task->second_category->category_color)) style="background:linear-gradient(0deg, {{$task->category->category_color }} 50%,  {{$task->second_category->category_color}} 50%);" @elseif(!empty($task->category->category_color)) style="background-color:{{$task->category->category_color}}"  @endif >
                        <div class="card-contents">
                            <div class="top-bar">
                                <div class="row">
                                <div class="col-md-3">
                                  <p>{{!empty($task->category->category_name) ? $task->category->category_name :' ' }} {{!empty($task->second_category->category_name) ? '/'.$task->second_category->category_name :' ' }}</p>
                                </div>
                                <div class="col-md-4">
                                 <p> {{$task->completed_subtasks->count()}} /{{$task->subtasks->count()}}</p>
                                </div>
                                <div class="col-md-5">

                                          @if(!empty($task->responsible))

                                              @if(file_exists(public_path().'/assets/images/users/'.$task->responsible->image))
                                                 <img src="{{asset('public/assets/images/users/'.$task->responsible->image)}}" alt="member">
                                              @else
                                                   <img src="https://source.unsplash.com/user/c_v_r">
                                              @endif
                                                 <p>Verantwortlich</p>
                                            @endif

                                  </div>
                                </div>
                            </div>
                            <div class="middle-content">

                               <h3>{!!substr($task->task_title,0,70)!!}</h3>
                               <br>
                                <div class="members">
                                     <ul>


                                         @php
                                              $teamids = \App\Models\TaskTeam::where('task_id' , $task->id)->pluck('user_id');
                                              $teams   =  \App\Models\User::whereIn('id',$teamids)->get();
                                         @endphp

                                          @if(!empty($teams))
                                              @foreach ($teams->take(4) as $key => $team)
                                                <li>
                                                      @if(file_exists(public_path().'/assets/images/users/'.$team->image))
                                                         <img src="{{asset('public/assets/images/users/'.$team->image)}}" alt="member">
                                                      @else
                                                           <img src="https://source.unsplash.com/user/c_v_r">
                                                      @endif
                                                </li>
                                              @endforeach
                                           @endif

                                           @if(count($teams) > 4)
                                             ....
                                           @endif

                                        <button class="btn btn-default btn-task-popup" data-id="{{$task->id}}" ><i class="bi bi-plus-circle"></i></button>
                                     </ul>

                                </div>
                            </div>
                            <div class="button-bar">
                                <div class="row">

                                     <div class="col-md-6">
                                      @if(!empty($task->added_by))

                                      @if(file_exists(public_path().'/assets/images/users/'.$task->added_by->image))
                                         <img src="{{asset('public/assets/images/users/'.$task->added_by->image)}}" alt="member">
                                      @else
                                           <img src="https://source.unsplash.com/user/c_v_r">
                                      @endif

                                      @endif
                                       <span> {{--!empty($task->added_by->user_name) ? $task->added_by->user_name :' ' --}} Erstellt von </span></div>
                                     <div class="col-md-6">
                                          <p>Falligkeitsdatum</p>
                                         <p> {{ date('d.m.Y', strtotime($task->task_due_date))}} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                 @endforeach
                 @endif


              </div>

      </div>


@endsection

@section('script')
<script src="{{asset('public/assets/admin/assets2/js/mixitup.min.js')}}"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
$(document).ready(function () {

      //Filtering  With Categories
       var mixer = mixitup('#shuffle');


            $('.multiple-items').slick({
              infinite: true,
              vertical:true ,
              slidesToShow: 5,
              slidesToScroll: 5
            });


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






@endsection
