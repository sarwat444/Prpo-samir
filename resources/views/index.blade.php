@extends('layouts.frontLayout.front_design')
@section('content')
    <!-- Hero Slider Area Start -->
    <div class="hero-area overflow-hidden">
        <!-- <div class="single-hero-slider-7"> -->
        <div class="container-fluid ml-0 mr-0">
            <div class="row row--25 hero-slider-8">
                <div class="col-lg-12 ">
                    <div class="single-hero-slider-7 bg-img" data-bg="{{ asset('assets/images/frontend_images/mug/tasse.jpg') }}">
                        <div class="hero-content-wrap">
                            <div class="hero-text-7 mt-lg-5">

                                <h1>Paar Tasse</h1>

                                <!-- <p class="mt-20">The other hand,denounce with righteous indignation and <br> dislike men who are the moment.</p> -->

                                <div class="button-box section-space--mt_60">
                                    <a href="{{url('shop/product_details')}}" class="btn--border-bottom">Bestelle jetzt</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 ">
                    <div class="single-hero-slider-7 bg-img" data-bg="{{ asset('assets/images/frontend_images/mug/tasse2.jpg')}}">
                        <div class="hero-content-wrap">
                            <div class="hero-text-7 mt-lg-5">

                                <h1>Abschiedsgeschenk <br>  Lehrer Tasse</h1>

                                <!-- <p class="mt-20">The other hand,denounce with righteous indignation and <br> dislike men who are the moment.</p>
     -->
                                <div class="button-box section-space--mt_60">
                                    <a href="{{url('shop/product_details')}}" class="btn--border-bottom">Bestelle jetzt</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 ">
                    <div class="single-hero-slider-7 bg-img" data-bg="assets/images/mug/tasse3.jpg">
                        <div class="hero-content-wrap">
                            <div class="hero-text-7 mt-lg-5">

                                <h1>Geburtsposter <br>  für Jungen und Mädchen</h1>

                                <!-- <p class="mt-20">The other hand,denounce with righteous indignation and <br> dislike men who are the moment.</p> -->

                                <div class="button-box section-space--mt_60">
                                    <a href="{{url('shop/product_details')}}" class="btn--border-bottom">Bestelle jetzt</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- </div> -->

    </div>
    <!-- Hero Slider Area End -->

    <div class="categories-shop-area section-space--pt_90">
        <div class="container">
            <div class="row row--5">
                <div class="col-lg-3 col-md-3">
                    <div class="hero-product-image mt-10">
                        <a href="{{url('shop/product_details')}}">
                            <img src="https://i.etsystatic.com/24461419/r/il/d4c3f4/3111651398/il_1588xN.3111651398_dww4.jpg" class="img-fluid" alt="Banner images">
                        </a>
                        <div class="product-banner-title">
                            <h4><a href="{{url('shop/product_details')}}">Braut Tasse</a></h4>
                            <!-- <h6>Deco collection</h6> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="hero-product-image mt-10">
                        <a href="{{url('shop/product_details')}}">
                            <img src="https://i.etsystatic.com/24461419/r/il/b27b3b/3213946426/il_1588xN.3213946426_x8fh.jpg" class="img-fluid" alt="Banner images">
                        </a>
                        <div class="product-banner-title">
                            <h4><a href="{{url('shop/product_details')}}">Polizist Tasse</a></h4>
                            <!-- <h6>Deco collection</h6> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="hero-product-image mt-10">
                        <a href="{{url('shop/product_details')}}">
                            <img src="https://i.etsystatic.com/24461419/r/il/c50b57/3037776090/il_1588xN.3037776090_da7h.jpg" class="img-fluid" alt="Banner images">
                        </a>
                        <div class="product-banner-title">
                            <h4><a href="{{url('shop/product_details')}}">Abschluss Tasse</a></h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="hero-product-image mt-10">
                        <a href="{{url('shop/product_details')}}">
                            <img src="https://i.etsystatic.com/24461419/r/il/e88f64/3261703707/il_1588xN.3261703707_dam8.jpg" class="img-fluid" alt="Banner images">
                        </a>
                        <div class="product-banner-title">
                            <h4><a href="{{url('shop/product_details') }} ">Beste Freundin Tasse</a></h4>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="hero-product-image mt-10">
                        <a href="{{ url('shop/product_details') }} ">
                            <img src="https://i.etsystatic.com/24461419/r/il/2d8dd6/3212848420/il_1588xN.3212848420_dadp.jpg" class="img-fluid" alt="Banner images">
                        </a>
                        <div class="product-banner-title">
                            <h4><a href="{{url('shop/product_details') }}">Braut Tasse</a></h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Product Area Start -->
    <div class="product-wrapper section-space--ptb_120">
        <div class="container">

            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="shop-toolbar__items shop-toolbar__item--left">
                        <div class="shop-toolbar__item shop-toolbar__item--result">
                            <p class="result-count"> Showing 1–9 of 21 results</p>
                        </div>

                        <div class="shop-toolbar__item shop-short-by">
                            <ul>
                                <li>
                                    <a href="#">Sort by <i class="fa fa-angle-down angle-down"></i></a>
                                    <ul>
                                        <li class="active"><a href="#">Default sorting</a></li>
                                        <li><a href="#">Sort by popularity</a></li>
                                        <li><a href="#">Sort by average rating</a></li>
                                        <li><a href="#">Sort by latest</a></li>
                                        <li><a href="#">Sort by price: low to high</a></li>
                                        <li><a href="#">Sort by price: high to low</a></li>
                                    </ul>
                                </li>

                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="shop-toolbar__items shop-toolbar__item--right">
                        <div class="shop-toolbar__items-wrapper">
                            <div class="shop-toolbar__item">
                                <ul class="nav toolber-tab-menu justify-content-start" role="tablist">
                                    <li class="tab__item nav-item active">
                                        <a class="nav-link" data-toggle="tab" href="#tab_columns_01" role="tab">
                                            <img src="{{asset('assets/images/frontend_images/svg/column-03.svg')}}" class="img-fluid" alt="Columns 03">
                                        </a>
                                    </li>
                                    <li class="tab__item nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tab_columns_02" role="tab"><img src="{{ asset('assets/images/frontend_images/svg/column-04.svg')}}" class="img-fluid" alt="Columns 03"> </a>
                                    </li>
                                    <li class="tab__item nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab_columns_03" role="tab"><img src="{{ asset('assets/images/frontend_images/svg/column-05.svg')}}" class="img-fluid" alt="Columns 03"> </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="shop-toolbar__item shop-toolbar__item--filter ">
                                <a class="shop-filter-active" href="#">Filter<i class="icon-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-filter-wrapper">
                <div class="row">
                    <!-- Product Filter -->
                    <div class=" mb-20 col__20">
                        <div class="product-filter">
                            <h5>Color</h5>
                            <ul class="widget-nav-list">
                                <li><a href="#"><span class="swatch-color black"></span> Black</a></li>
                                <li><a href="#"><span class="swatch-color green"></span> Green</a></li>
                                <li><a href="#"><span class="swatch-color grey"></span> Grey</a></li>
                                <li><a href="#"><span class="swatch-color red"></span> Red</a></li>
                                <li><a href="#"><span class="swatch-color white"></span> White</a></li>
                                <li><a href="#"><span class="swatch-color yellow"></span> Yellow</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Product Filter -->
                    <div class=" mb-20 col__20">
                        <div class="product-filter">
                            <h5>Size</h5>
                            <ul class="widget-nav-list">
                                <li><a href="#">Large</a></li>
                                <li><a href="#">Medium</a></li>
                                <li><a href="#">Small</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Product Filter -->
                    <div class=" mb-20 col__20">
                        <div class="product-filter">
                            <h5>Price</h5>
                            <ul class="widget-nav-list">
                                <li><a href="#">$0.00 - $20.00</a></li>
                                <li><a href="#">$20.00 - $40.00</a></li>
                                <li><a href="#">£40.00 - £50.00</a></li>
                                <li><a href="#">£50.00 - £60.00</a></li>
                                <li><a href="#">£60.00 +</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Product Filter -->
                    <div class=" mb-20 col__20">
                        <div class="product-filter">
                            <h5>Categories</h5>
                            <ul class="widget-nav-list">
                                <li><a href="#">All</a></li>
                                <li><a href="#">Accessories</a></li>
                                <li><a href="#">Chair</a></li>
                                <li><a href="#">Decoration</a></li>
                                <li><a href="#">Furniture</a></li>
                                <li><a href="#">Table</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class=" mb-20 col__20">
                        <div class="product-filter">
                            <h5>Tags</h5>
                            <div class="tagcloud"><a href="#" class="selected">All</a><a href="#" class="">Accesssories</a><a href="#" class="">Box</a><a href="#" class="">chair</a><a href="#" class="">Deco</a><a href="#" class="">Furniture</a><a href="#" class="">Glass</a><a href="#" class="">Pottery</a><a href="#" class="">Table</a></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade" id="tab_columns_01">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="{{ asset('assets/images/frontend_images/product/1_1-300x300.jpg')}}" class="img-fluid" alt="Product Images">

                                        <span class="ribbon out-of-stock ">
                                                Out Of Stock
                                            </span>
                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Teapot with black tea</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">£40.00</span> - <span class="old-price"> £635.00</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="{{ asset('assets/images/frontend_images/product/1_2-300x300.jpg')}}" class="img-fluid" alt="Product Images">

                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Simple Chair</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">£70.00</span> - <span class="old-price"> £95.00</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="https://i.etsystatic.com/24461419/c/2528/2009/270/43/il/9e0df5/3221426959/il_340x270.3221426959_pydc.jpg" class="img-fluid" alt="Product Images">

                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Smooth Disk</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">£46.00</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="{{ asset('assets/images/frontend_images/product/1_4-300x300.jpg')}}" class="img-fluid" alt="Product Images">

                                        <span class="ribbon onsale">
                                            -14%
                                            </span>
                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Wooden Flowerpot</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">£40.00</span> - <span class="old-price"> £635.00</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="{{ asset('assets/images/frontend_images/product/1_5-300x300.jpg')}}" class="img-fluid" alt="Product Images">

                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Living room & Bedroom lights</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">£60.00</span> - <span class="old-price"> £69.00</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="{{ asset('assets/images/frontend_images/product/1_6-300x300.jpg')}}" class="img-fluid" alt="Product Images">

                                    </a>
                                    <div class="product-actions">
                                        <a href="{{url('shop/product_details')}}" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Gray lamp</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">£80.00</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="{{ asset('assets/images/frontend_images/product/1_7-300x300.jpg') }}" class="img-fluid" alt="Product Images">

                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Familie Tasse</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">20,00 €</span> - <span class="old-price"> 35,00 €</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="{{asset('assets/images/frontend_images/product/1_8-300x300.jpg')}}" class="img-fluid" alt="Product Images">

                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Familie Tasse</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">20,00 €</span> - <span class="old-price"> 35,00 €</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade show active" id="tab_columns_02">
                    <div class="row">




                 @if(!empty($motives))


                   @foreach($motives as $motive)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details/'.$motive->id)}}" class="product-thumbnail">
                                        <img src="{{asset('assets/images/motives/'.$motive->motive_image )}}" class="img-fluid" alt="Product Images">

                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details/'.$motive->id)}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details/'.$motive->id)}}">{{$motive->motive_name}}</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">15,00 €</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>
                   @endforeach

                @endif






                    </div>
                </div>
                <div class="tab-pane fade" id="tab_columns_03">
                    <div class="row">

                        <div class="col__20">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="{{asset('assets/images/frontend_images/product/1_5-300x300.jpg')}}" class="img-fluid" alt="Product Images">

                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Living room & Bedroom lights</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">£60.00</span> - <span class="old-price"> £69.00</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>

                        <div class="col__20">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="{{asset('assets/images/frontend_images/product/1_6-300x300.jpg')}}" class="img-fluid" alt="Product Images">

                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Gray lamp</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">£80.00</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>

                        <div class="col__20">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="{{asset('assets/images/frontend_images/product/1_7-300x300.jpg')}}" class="img-fluid" alt="Product Images">
                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Decoration wood</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">£50.00</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>
                        <div class="col__20">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="{{asset('assets/images/frontend_images/product/1_7-300x300.jpg')}}" class="img-fluid" alt="Product Images">
                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Decoration wood</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">£50.00</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>

                        <div class="col__20">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="{{asset('assets/images/frontend_images/product/1_7-300x300.jpg')}}" class="img-fluid" alt="Product Images">
                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Decoration wood</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">£50.00</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>

                        <div class="col__20">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="{{asset('assets/images/frontend_images/product/1_7-300x300.jpg')}}" class="img-fluid" alt="Product Images">
                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Decoration wood</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">£50.00</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>

                        <div class="col__20">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{url('shop/product_details')}}" class="product-thumbnail">
                                        <img src="{{asset('assets/images/frontend_images/product/1_7-300x300.jpg')}}" class="img-fluid" alt="Product Images">
                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                        <a href="{{url('shop/product_details')}}"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a href="{{url('shop/product_details')}}">Decoration wood</a></h6>
                                    <div class="prodect-price">
                                        <span class="new-price">£50.00</span>
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Area End -->


@endsection
