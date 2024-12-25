@extends('layouts.admin')

@section('content')

<!--  BEGIN CONTENT AREA  -->
  <div id="content" class="main-content">
      <div class="container">
          <div class="container">

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
                                  <div class="widget-header">
                                      <div class="row">
                                          <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                              <h4> Add New Section </h4>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="widget-content widget-content-area">


                                    <form action="{{route('admin.sections.store')}}" method="POST" enctype="multipart/form-data">

                                         @csrf

                                       <div class="form-group">



                                         <label>Section Name</label>
                                          <input type="text" name="section_name" class="form-control">



                                       </div>




                                            <button type="submit" class="btn btn-primary"> UPload</button>

                                       </form>

                                      <div class="code-section-container show-code">


                                          <div class="code-section text-left">

                                          </div>
                                      </div>


                                  </div>
                              </div>
                          </div>



                      </div>

                </div>


                </div>


                    </div>


@endsection
