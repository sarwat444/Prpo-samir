@extends('layouts.dashboard')
@section('css')
@endsection
@section('title'){{$title}} @endsection
@section('content')

<section class="bg-diffrent">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-11">
                @if(!empty($tags))
                    <div class="category-lists-slider">
                        <div class="swiper-container" id="catgory-slider">
                            <div class="swiper-wrapper" id="swiper">
                                  @foreach($tags as $tag)
                                        <div class="swiper-slide cat_list" style="margin-right:5px;">
                                              <a href="{{route('admin.cat.tag.tasks',['cat_id' => $cat_id ,'tag_id' => $tag->id ,'status' => $status ])}}">
                                                  <div class="category-button  filter">
                                                  {{strtoupper($tag->tag_name)}}
                                                </div>
                                              </a>
                                        </div>
                                    @endforeach
                            </div>
                        </div>
                        <div class="slider-button slider-prev"><i class="fa fa-chevron-left"></i></div>
                        <div class="slider-button slider-next"><i class="fa fa-chevron-right"></i></div>
                    </div>
                @endif
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

             <div class="row justify-content-center">
              <div class="col-md-2">
                    <div class="category_sidebar">
                        <ul>

                              <a href="{{route('admin.cat.tasks',['cat_id' => 0 ,'status' => $status ])}}"><li @if($cat_id == 0) class="category-button  filter active" @else class="category-button  filter" @endif   data-status="{{$status}}" >  Alle </li> </a>
                          @if(!empty($categories))
                              @foreach($categories as $cat)
                                 <a href="{{route('admin.cat.tasks',['cat_id' => $cat->id ,'status' => $status ])}}"><li  @if($cat->id == $cat_id ) class="category-button  filter active" @else class="category-button  filter" @endif   data-status="{{$status}}">  {{$cat->category_name}} </li> </a>
                              @endforeach
                          @endif
                        </ul>
                    </div>
              </div>

                          <div class="col-md-9">
                              <div class="row sortable-cards" id="shuffle">
                           @if(!empty($tasks))
                             @foreach ($tasks as $key => $task)

                               @if(!empty($task->category))
                                <div class="col-md-3  sortable-divs mix ui-state-default {{$task->category->category_name}}" data-id="{{$task->id}}" id="task{{$task->id}}">
                                 <div class="card sort"
                                      @if(!empty($task->image))
                                         style="background-size: cover; background-image: linear-gradient(to right bottom, rgba(6, 46, 78, 0.42), rgba(20, 25, 53, 0.53)), url('{{asset('uploads/images/compressed/'.$task->image)}}'); background-position: center center;" @elseif(!empty($task->category->category_color)) style="background-color: {{ $task->category->category_color }}"
                                      @else
                                      @if(!empty($task->category->category_color) && !empty($task->second_category->category_color)) style="background:linear-gradient(0deg, {{$task->category->category_color }} 50%,  {{$task->second_category->category_color}} 50%);" @elseif(!empty($task->category->category_color)) style="background-color:{{$task->category->category_color}}"  @endif >
                                      @endif
                                     >
                                    <div class="card-contents">
                                        <div class="top-bar">
                                            <div class="row">
                                            <div class="col-md-6">
                                              <p>{{!empty($task->category->category_name) ? $task->category->category_name :' ' }} {{!empty($task->second_category->category_name) ? '/'.$task->second_category->category_name :' ' }}</p>
                                            </div>
                                            <div class="col-md-3">
                                             <p> {{$task->completed_subtasks->count()}} /{{$task->subtasks->count()}}</p>
                                            </div>
                                            <div class="col-md-3">

                                                      @if(!empty($task->responsible))

                                                          @if(file_exists(public_path().'/assets/images/users/'.$task->responsible->image))
                                                             <img src="{{asset('public/assets/images/users/'.$task->responsible->image)}}" alt="member">
                                                          @else
                                                               <img src="https://source.unsplash.com/user/c_v_r">
                                                          @endif

                                                        @endif

                                              </div>
                                            </div>
                                        </div>
                                        <div class="middle-content">

                                           <h3 style="font-size:17px;">{!!substr($task->task_title,0,70)!!}</h3>
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
                                                                @if(!empty($team->image))
                                                                  @if(file_exists(public_path().'/assets/images/users/'.$team->image))
                                                                     <img src="{{asset('public/assets/images/users/'.$team->image)}}" alt="member">
                                                                  @endif
                                                                @else
                                                                    <img src="{{asset('public/assets/images/default.png')}}">
                                                                @endif
                                                            </li>
                                                          @endforeach
                                                       @endif

                                                       @if(count($teams) > 4)
                                                         ....
                                                       @endif

                                                    <button class="btn btn-default btn-task-popup" data-id="{{$task->id}}" ><i class="fa fa-plus"></i></button>
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
                                                   <span> {{--!empty($task->added_by->user_name) ? $task->added_by->user_name :' ' --}} </span>
                                                      <button class="btn btn-default copy" data-id="{{$task->id}}" ><i class="fa fa-copy"></i></button>
                                                 </div>
                                                 <div class="col-md-6">

                                                     <p> {{ date('d.m.Y', strtotime($task->task_due_date))}} </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                @endif
                             @endforeach
                          @endif
                          </div>
</div>

             </div>

      </div>


@endsection


@section('script')
<script src="{{asset('public/assets/admin/assets2/js/mixitup.min.js')}}"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
@endsection
