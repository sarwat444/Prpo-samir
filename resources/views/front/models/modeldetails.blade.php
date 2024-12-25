
{{--
Model Name :couple model  .
Model N0 : 2 ,
Charactristics  : Hintgrround  , Mann , Fau  ,  unbennat , Typing

--}}
 @extends('layouts.frontLayout.front_design')

 @section('css')
<link rel="stylesheet" href="{{asset('assets/css/frontend_css/models_css/2.css')}}">
 @endsection
 @section('content')


  <div class="editor couplempodel">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
                <div class="container">
                      <div class="row">
                          <div class="col-md-5">
                              <div class="mug-modal">

                                <div class="main-mug">
                                <img class="mogmodel" src="{{asset('assets/images/frontend_images/model_images/MugModels/gold_special.png')}}" alt="mug">
                                </div>
                                  <div class="hinterground">
                                      <img  class="couplebackgroundimage" src="" alt="" />
                                  </div>
                                  <div id="coupletyped">
                                      <p></p>
                                  </div>
                                  <!--Jeans Of two Persons-->
                                  <div class="jeans">
                                      <img class="active5" src="" alt="" />
                                  </div>
                                  <div class="jeans2">
                                      <img class="active6" src="" alt="" />
                                  </div>
                                  <!--Jeans Of two person-->
                                  <div class="frau">
                                      <img class="frauimage" src="" alt="" />
                                  </div>
                                  <!--Jeans Of two Hair-->
                                  <div class="Unbenannt">
                                      <img class="couple1unbenantimage" src="" alt="" />
                                  </div>

                                  <div class="Unbenannt2">
                                      <img class="couple2unbenantimage" src="" alt="" />
                                  </div>


                                  <div class="mann">
                                      <img class="mannimage" src="" alt="" />
                                  </div>


                                  <div class="Unbenannt2">
                                      <img class="couple1unbenantimage" src="" alt="" />
                                  </div>
                                  <!--Jeans Of two Hair-->
                                  <div class="spruch">
                                      <img class="active7" src="" alt="" />
                                  </div>
                              </div>


                          </div>

                          <div class="col-md-7">
                              <div class="img-filteration">
                                  <div id="accordion">
                                      <div class="card">
                                          <div class="card-header" id="category1">
                                              <h5 class="mb-0">
                                                  <button class="btn btn-link" data-toggle="collapse" data-target="#coupleimagescontent1" aria-expanded="true" aria-controls="collapseOne">
                                                      <h4><i class="icofont-arrow-down"></i> Hinterground</h4>
                                                  </button>
                                              </h5>
                                          </div>

                                          <div id="coupleimagescontent1" class="collapse show" aria-labelledby="category1" data-parent="#accordion">
                                              <div class="card-body">
                                                  <div class="list-images">
                                                      <ul>

                                                          <li><img  src="{{asset('assets/images/frontend_images/model_images/2/couplemodel/background/Couple%20Hintergrund%2038.png')}}" alt="couplebackground  1"></li>
                                                          <li><img  src="{{asset('assets/images/frontend_images/model_images/2/couplemodel/background/Couple%20Hintergrund%2040.png')}}" alt="couplebackground  2"></li>
                                                          <li class="couplenoimage"><i class="icofont-not-allowed"></i></li>
                                                      </ul>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="card">
                                          <div class="card-header" id="category3">
                                              <h5 class="mb-0">
                                                  <button class="btn btn-link" data-toggle="collapse" data-target="#content2" aria-expanded="false" aria-controls="collapseOne">
                                                      <h4><i class="icofont-arrow-down"></i> Mann</h4>
                                                  </button>
                                              </h5>
                                          </div>
                                          <div id="content2" class="collapse" aria-labelledby="category3" data-parent="#accordion">
                                              <div class="card-body">
                                                  <div class="list-images">
                                                      <ul>
                                                          <li><img  src="{{asset('assets/images/frontend_images/model_images/2/couplemodel/Mann/Mann/Couple%20Mann%20H1-2.png')}}" alt="Manna1"></li>
                                                          <li><img  src="{{asset('assets/images/frontend_images/model_images/2/couplemodel/Mann/Mann/Couple Mann H2-1.png')}}" alt="Manna2"></li>
                                                      </ul>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="card">
                                          <div class="card-header" id="category4">
                                              <h5 class="mb-0">
                                                  <button class="btn btn-link" data-toggle="collapse" data-target="#fraucontent" aria-expanded="false" aria-controls="collapseOne">
                                                      <h4><i class="icofont-arrow-down"></i> Frau </h4>
                                                  </button>
                                              </h5>
                                          </div>
                                          <div id="fraucontent" class="collapse" aria-labelledby="category4" data-parent="#accordion">
                                              <div class="card-body">
                                                  <div class="list-images">
                                                      <ul>
                                                          <li><img  src="{{asset('assets/images/frontend_images/model_images/2/couplemodel/Frau/Frau/Couple Frau H2-1.png')}}" alt="frau"></li>

                                                      </ul>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="card">
                                          <div class="card-header" id="category3">
                                              <h5 class="mb-0">
                                                  <button class="btn btn-link" data-toggle="collapse" data-target="#couple1Unbenannt" aria-expanded="false" aria-controls="collapseOne">
                                                      <h4><i class="icofont-arrow-down"></i> Unbenannt</h4>
                                                  </button>
                                              </h5>
                                          </div>
                                          <div id="couple1Unbenannt" class="collapse " aria-labelledby="category3" data-parent="#accordion">
                                              <div class="card-body">
                                                  <div class="list-images">
                                                      <ul>
                                                          <li><img  src="{{asset('assets/images/frontend_images/model_images/2/couplemodel/Unbenannt/Unbenannt-1.png')}}" alt="Unbenannt 1"></li>
                                                          <li><img  src="{{asset('assets/images/frontend_images/model_images/2/couplemodel/Unbenannt/Unbenannt-2.png')}}" alt="Unbenannt 1"></li>
                                                      </ul>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                     {{--
                                      <div class="card">
                                          <div class="card-header" id="category4">
                                              <h5 class="mb-0">
                                                  <button class="btn btn-link" data-toggle="collapse" data-target="#couple2Unbenannt" aria-expanded="false" aria-controls="collapseOne">
                                                      <h4><i class="icofont-arrow-down"></i> Unbenannt</h4>
                                                  </button>
                                              </h5>
                                          </div>
                                          <div id="couple2Unbenannt" class="collapse " aria-labelledby="category4" data-parent="#accordion">
                                              <div class="card-body">
                                                  <div class="list-images">
                                                      <ul>
                                                          <li><img  src="assets/img/Unbenannt/Unbenannt-1.png" alt="Körper 1"></li>
                                                          <li><img  src="assets/img/Unbenannt/Unbenannt-2.png" alt="Körper 1"></li>
                                                      </ul>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      --}}
                                      <div class="card">
                                          <div class="card-header" id="typing2">
                                              <h5 class="mb-0">
                                                  <button class="btn btn-link" data-toggle="collapse" data-target="#ctyping" aria-expanded="false" aria-controls="collapseOne">
                                                      <h4><i class="icofont-arrow-down"></i> Tippe was du willst </h4>
                                                  </button>
                                              </h5>
                                          </div>
                                          <div id="ctyping" class="collapse " aria-labelledby="category8" data-parent="#accordion">
                                              <div class="card-body">
                                                  <div class="typingdiloge">
                                                      <form>
                                                          <div class="form-group">
                                                              <label for="typing">Type Your Hint : </label>
                                                              <textarea  name="title" id="coupletyping" class="form-control" placeholder="Type What  You Want " /></textarea>
                                                          </div>
                                                          <div class="form-group">
                                                              <label for="fontfamily">Font Style : </label>
                                                              <select name="fontfamily" class="form-control" id="fontfamily">

                                                                  <option value="serif">Serif </option>
                                                                  <option value="sans-serif">Sans-serif	</option>
                                                                  <option value="monospace">Monospace</option>
                                                                  <option value="cursive">Cursive</option>
                                                                  <option value="fantasy">Fantasy</option>
                                                                  <option value="Apple Chancery, cursive">Apple Chancery, cursive</option>
                                                                  <option value="Brush Script MT, Brush Script Std, cursive">Brush Script MT, Brush Script Std, cursive</option>
                                                                  <option value="Impact, fantasy">Impact, fantasy	</option>
                                                                  <option value="Jazz LET, fantasy">Jazz LET, fantasy	</option>
                                                                  <option value="Trattatello, fantasy">Trattatello, fantasy	</option>
                                                              </select>
                                                          </div>
                                                          <div class="form-group">
                                                              <label for="fsize">Font Size : </label>
                                                              <input type="number" min="0" max="30" name="fsize" id="fsize" class="form-control" placeholder="font size"/>
                                                          </div>
                                                          <div class="form-group">
                                                              <label for="fcolor">Font Color : </label>
                                                              <input type="color" name="fcolor" id="fcolor" />
                                                          </div>
                                                      </form>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
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
@section('js')
<script src="{{asset('assets/js/frontend_js/models_js/2.js')}}"></script>
@endsection
