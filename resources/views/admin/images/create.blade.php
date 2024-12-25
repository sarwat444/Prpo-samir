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
                                              <h4>Select Type And Upload Multiple Images</h4>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="widget-content widget-content-area">


                                    <form action="{{route('admin.images.store')}}" method="POST" enctype="multipart/form-data">

                                         @csrf



                                         <div class="form-group">



                                           <select class="selectpicker form-control" id="motive_id" name="motive_id" data-size="5" >

                                                   <option value="">Select Motive</option>

                                                 @foreach ($motives as $key => $motive)


                                                        <option value="{{$motive->id}}"> {{$motive->motive_name }} </option>

                                                  @endforeach

                                            </select>





                                         </div>

                                   <div id="characters_dta">



                                   </div>


                                   <div class="form-group">



                                     <select class="selectpicker form-control" id="section" name="section" data-size="5" >

                                             <option value="">Select Section</option>

                                            <option value="hinterground"> Hinterground </option>
                                            <option value="mann"> Mann </option>
                                            <option value="frau"> Frau </option>
                                            <option value="ubenannt"> Ubenannt </option>
                                            <option value="hair"> Hair </option>
                                            <option value="skrph"> Skrph </option>



                                      </select>





                                   </div>

                                  <div class="form-group">

                                        <label>Upload Images</label>
                                         <input type="file" name="images[]" multiple>
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


@section('script')




<script>

    $(document).ready(function() {

       $('#motive_id').change(function(){


                 var motive_id = $(this).val();

         //alert(brand_id);

                 $.ajax({


                     type : 'POST',
                     url : "{{ route('admin.motives_charrs') }}",
                     data : { motive_id : motive_id , _token : '{{ csrf_token() }}' },
                     success : function (data) {


                              $('#characters_dta').empty().html(data.options);

                     }
                 });
       });




    });


    </script>






@stop
