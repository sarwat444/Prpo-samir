
@extends('layouts.frontLayout.front_design')
@section('content')
<!-- breadcrumb-area start -->
<div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box  align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-6 text-center text-sm-left">
                            <h2 class="breadcrumb-title">Familie Tasse</h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-6">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-sm-right">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">Tasse</li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->

    <div id="main-wrapper">
    <div class="site-wrapper-reveal">
            <div class="single-product-wrap section-space--pt_90 border-bottom">
                <div class="container fixme">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">

                            <!-- Product Details Left -->
                            <div class="product-details-left">
                                <div class="product-details-images-2 slider-lg-image-2">

                                    <div class="easyzoom-style">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="{{asset('assets/images/white_heart.png')}}" class="poppu-img">
                                                <img src="{{asset('assets/images/white_heart.png') }}" class="img-fluid" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="easyzoom-style">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="https://i.etsystatic.com/24461419/r/il/114aec/3036025776/il_794xN.3036025776_aow7.jpg" class="poppu-img">
                                                <img src="https://i.etsystatic.com/24461419/r/il/114aec/3036025776/il_794xN.3036025776_aow7.jpg" class="img-fluid" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="easyzoom-style">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="https://i.etsystatic.com/24461419/r/il/72ab34/3267714753/il_794xN.3267714753_6ua3.jpg" class="poppu-img">
                                                <img src="https://i.etsystatic.com/24461419/r/il/72ab34/3267714753/il_794xN.3267714753_6ua3.jpg" class="img-fluid" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="easyzoom-style">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="https://i.etsystatic.com/24461419/r/il/0c28f6/3220020006/il_794xN.3220020006_dd9x.jpg" class="poppu-img">
                                                <img src="https://i.etsystatic.com/24461419/r/il/0c28f6/3220020006/il_794xN.3220020006_dd9x.jpg" class="img-fluid" alt="">
                                            </a>
                                        </div>
                                    </div>

                                </div>
                                <div class="product-details-thumbs-2 slider-thumbs-2">
                                    <div class="sm-image" style="height: 90px; overflow:hidden;"><img style="object-fit: cover;height:100%" src="https://i.etsystatic.com/24461419/r/il/9e0df5/3221426959/il_1588xN.3221426959_pydc.jpg" alt="product image thumb" class="img-fluid"></div>
                                    <div class="sm-image" style="height: 90px; overflow:hidden;"><img style="object-fit: cover;height:100%" src="https://i.etsystatic.com/24461419/r/il/114aec/3036025776/il_794xN.3036025776_aow7.jpg" alt="product image thumb" class="img-fluid"></div>
                                    <div class="sm-image" style="height: 90px; overflow:hidden;"><img style="object-fit: cover;height:100%" src="https://i.etsystatic.com/24461419/r/il/72ab34/3267714753/il_794xN.3267714753_6ua3.jpg" alt="product image thumb" class="img-fluid"></div>
                                    <div class="sm-image" style="height: 90px; overflow:hidden;"><img style="object-fit: cover;height:100%" src="https://i.etsystatic.com/24461419/r/il/0c28f6/3220020006/il_794xN.3220020006_dd9x.jpg" alt="product image thumb" class="img-fluid"></div>
                                </div>
                            </div>
                            <!--// Product Details Left -->

                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                            <div class="product-details-content ">

                                <h5 class="font-weight--reguler mb-10">Hijab Freundin Tasse, Freundin Tasse, Hijab Schwestern Tasse, Eid Geschenk, Ramadan Tasse, Ramadan Geschenk, Hijab Freundin Poster</h5>

                                <div class="row">
                                    <div class="col-8">
                                        <h3 class="price">21,99 € - 32,00 €</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <div class="check rounded text-center">
                                            <i class="fas fa-check"></i> Verfügbar
                                        </div>
                                    </div>
                                </div>


                                <div class="quickview-peragraph mt-10">
                                    <p>Inkl. lokaler Steuern (wo zutreffend), plus Versand</p>
                                </div>


                                <a href="{{url('/shop/model_maker/'.$motive->id)}}" class="btn btn-primary btn-block mb-3"><i data-feather="coffee"></i>Make Your Own Design </a>


                                <div class="quickview-action-wrap mt-5 pt-4">
                                    <div class="quickview-cart-box">
                                        <div class="quickview-quality">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" type="text" name="qtybutton" value="0">
                                            </div>
                                        </div>

                                        <div class="quickview-button">
                                            <div class="quickview-cart button">
                                                <a href="product-details.html" class="btn--lg btn--black font-weight--reguler text-white">Ins Warenkorb</a>
                                            </div>
                                            <div class="quickview-wishlist button">
                                                <a title="Add to wishlist" href="#"><i class="icon-heart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3"><i style="font-size: 26px;" class="fas fa-shipping-fast pt-4"></i>&nbsp;&nbsp;&nbsp;&nbsp;Lieferung bis <abbr title="attribute">30. Jul - 04. Aug</abbr>, wenn du heute bestellst.</p>
                                </div>

                                <div class="product_meta mt-30">
                                    <div class="sku_wrapper item_meta">
                                        <span class="label"> SKU: </span>
                                        <span class="sku"> 502 </span>
                                    </div>
                                    <div class="posted_in item_meta">
                                        <span class="label">Kategorien: </span><a href="#">Freunde</a>, <a href="#">Freundschaft</a>
                                    </div>
                                    <div class="tagged_as item_meta">
                                        <span class="label">Tag: </span><a href="#">Pottery</a>
                                    </div>
                                </div>

                                <div class="product_socials section-space--mt_60">
                                    <span class="label">Teile diese Tasse :</span>
                                    <ul class="helendo-social-share socials-inline">
                                        <li>
                                            <a class="share-twitter helendo-twitter" href="#" target="_blank"><i class="social_twitter"></i></a>
                                        </li>
                                        <li>
                                            <a class="share-facebook helendo-facebook" href="#" target="_blank"><i class="social_facebook"></i></a>
                                        </li>
                                        <li>
                                            <a class="share-google-plus helendo-google-plus" href="#" target="_blank"><i class="social_googleplus"></i></a>
                                        </li>
                                        <li>
                                            <a class="share-pinterest helendo-pinterest" href="#" target="_blank"><i class="social_pinterest"></i></a>
                                        </li>
                                        <li>
                                            <a class="share-linkedin helendo-linkedin" href="#" target="_blank"><i class="social_linkedin"></i></a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="product-details-tab section-space--pt_90">
                                <ul role="tablist" class=" nav">
                                    <li class="active" role="presentation">
                                        <a data-toggle="tab" role="tab" href="#description" class="active">Beschreibung</a>
                                    </li>
                                    <li role="presentation">
                                        <a data-toggle="tab" role="tab" href="#sheet">Produktinformation</a>
                                    </li>
                                    <li role="presentation">
                                        <a data-toggle="tab" role="tab" href="#reviews">Bewertungen</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="product_details_tab_content tab-content mt-30">
                                <!-- Start Single Content -->
                                <div class="product_tab_content tab-pane active" id="description" role="tabpanel">
                                    <div class="product_description_wrap">
                                        <div class="product-details-wrap">
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <div class="details mt-30">
                                                        <h5 class="mb-10">Detail</h5>
                                                        <p>❗️Nach dem Kauf bekommst du immer eine Druckvorschau, um eventuelle Änderungswünsche UND Korrekturen vornehmen zu können. Bitte achte auf unsere Nachricht, damit du deinen Artikel schnell erhälst. Prüfe dazu auch deinen Email Spamordner. Nach Druckfreigabe geht die Tasse in den Druck.
                                                        <br><br>

                                                        ☆ Keramikbecher<br>
                                                        ☆ 330 ml<br>
                                                        ☆ Spülmaschinen geeignet<br>
                                                        ☆ Mikrowellengeeignet<br>

                                                        _________________
                                                        <br><br>
                                                        ☆ Personalisierbar:<br><br>

                                                        • Personenanzahl<br>
                                                        • Kleidung<br>
                                                        • Hautfarbe<br>
                                                        • Hintergrund<br>
                                                        • Spruch<br>
                                                        • Namen<br>
                                                        _________________<br><br>

                                                        Nach dem Kauf bekommst du immer eine Druckvorschau, um eventuelle Änderungswünsche UND Korrekturen vornehmen zu können. Bitte achte auf unsere Nachricht, damit du deinen Artikel schnell erhälst. Prüfe dazu auch deinen Email Spamordner. Nach Druckfreigabe geht die Tasse in den Druck.</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 mt-4 pt-2">
                                                    <div class="high mb-5">
                                                        <h5 class="mb-10">Highlights</h5>
                                                        <p><i class="fas fa-hand-sparkles"></i> &nbsp;&nbsp;Handgefertigt</p>
                                                        <p><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;Verschickt von einem Kleinunternehmen in Deutschland</p>
                                                        <p><i class="fab fa-creative-commons-remix"></i> &nbsp;&nbsp;Materialien: Keramik</p>
                                                    </div>

                                                    <div class="images">
                                                        <img src="https://i.etsystatic.com/24461419/r/il/9e0df5/3221426959/il_1588xN.3221426959_pydc.jpg" class="img-fluid" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Content -->
                                <!-- Start Single Content -->
                                <div class="product_tab_content tab-pane" id="sheet" role="tabpanel">
                                    <div class="pro_feature">
                                        <table class="shop_attributes">
                                            <tbody>
                                                <tr>
                                                    <th>Weight</th>
                                                    <td>1.2 kg</td>
                                                </tr>
                                                <tr>
                                                    <th>Dimensions</th>
                                                    <td>12 × 2 × 1.5 cm</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- End Single Content -->
                                <!-- Start Single Content -->
                                <div class="product_tab_content tab-pane" id="reviews" role="tabpanel">

                                    <!-- Start RAting Area -->
                                    <div class="rating_wrap mb-30">
                                        <h4 class="rating-title-2">Be the first to review “Wooden chair”</h4>
                                        <p>Your rating</p>
                                        <div class="rating_list">
                                            <div class="product-rating d-flex">
                                                <i class="yellow icon_star"></i>
                                                <i class="yellow icon_star"></i>
                                                <i class="yellow icon_star"></i>
                                                <i class="yellow icon_star"></i>
                                                <i class="yellow icon_star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End RAting Area -->
                                    <div class="comments-area comments-reply-area">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <form action="#" class="comment-form-area">
                                                    <p class="comment-form-comment">
                                                        <label>Your review *</label>
                                                        <textarea class="comment-notes" required="required"></textarea>
                                                    </p>
                                                    <div class="comment-input">
                                                        <p class="comment-form-author">
                                                            <label>Name <span class="required">*</span></label>
                                                            <input type="text" required="required" name="Name">
                                                        </p>
                                                        <p class="comment-form-email">
                                                            <label>Email <span class="required">*</span></label>
                                                            <input type="text" required="required" name="email">
                                                        </p>
                                                    </div>

                                                    <div class="comment-form-submit">
                                                        <input type="submit" value="Submit" class="comment-submit">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Content -->
                            </div>
                        </div>
                    </div>

                    <div class="related-products section-space--ptb_90">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title text-center mb-30">
                                    <h4>Empfohlene Produkte</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row product-slider-active">
                            <div class="col-lg-12">
                                <!-- Single Product Item Start -->
                                <div class="single-product-item text-center">
                                    <div class="products-images">
                                        <a href="product-details.html" class="product-thumbnail">
                                            <img src="https://i.etsystatic.com/24461419/r/il/c50b57/3037776090/il_1588xN.3037776090_da7h.jpg" class="img-fluid" alt="Product Images">

                                            <span class="ribbon out-of-stock ">
                                            Out Of Stock
                                        </span>
                                        </a>
                                        <div class="product-actions">
                                            <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                            <a href="product-details.html"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                            <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h6 class="prodect-title"><a href="product-details.html">Abschluss Tasse</a></h6>
                                        <div class="prodect-price">
                                            <span class="new-price">40,00 €</span>
                                        </div>
                                    </div>
                                </div><!-- Single Product Item End -->
                            </div>

                            <div class="col-lg-12">
                                <!-- Single Product Item Start -->
                                <div class="single-product-item text-center">
                                    <div class="products-images">
                                        <a href="product-details.html" class="product-thumbnail">
                                            <img src="https://i.etsystatic.com/24461419/c/2553/2030/447/54/il/bf3d8c/3213995004/il_340x270.3213995004_ov18.jpg" class="img-fluid" alt="Product Images">

                                        </a>
                                        <div class="product-actions">
                                            <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                            <a href="product-details.html"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                            <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h6 class="prodect-title"><a href="product-details.html">Akhi Tasse</a></h6>
                                        <div class="prodect-price">
                                            <span class="new-price">17,00 €</span>
                                        </div>
                                    </div>
                                </div><!-- Single Product Item End -->
                            </div>

                            <div class="col-lg-12">
                                <!-- Single Product Item Start -->
                                <div class="single-product-item text-center">
                                    <div class="products-images">
                                        <a href="product-details.html" class="product-thumbnail">
                                            <img src="https://i.etsystatic.com/24461419/r/il/1b08f7/3217736327/il_1588xN.3217736327_e3wo.jpg" class="img-fluid" alt="Product Images">

                                        </a>
                                        <div class="product-actions">
                                            <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                            <a href="product-details.html"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                            <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h6 class="prodect-title"><a href="product-details.html">Freundin Tasse</a></h6>
                                        <div class="prodect-price">
                                            <span class="new-price">16,00 €</span>
                                        </div>
                                    </div>
                                </div><!-- Single Product Item End -->
                            </div>

                            <div class="col-lg-12">
                                <!-- Single Product Item Start -->
                                <div class="single-product-item text-center">
                                    <div class="products-images">
                                        <a href="product-details.html" class="product-thumbnail">
                                            <img src="https://i.etsystatic.com/24461419/d/il/7df60b/2971308112/il_340x270.2971308112_gyex.jpg?version=0" class="img-fluid" alt="Product Images">

                                            <span class="ribbon onsale">
                                        -14%
                                        </span>
                                        </a>
                                        <div class="product-actions">
                                            <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                            <a href="product-details.html"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                            <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h6 class="prodect-title"><a href="product-details.html">Wooden Flowerpot</a></h6>
                                        <div class="prodect-price">
                                            <span class="new-price">40,00 €</span>
                                        </div>
                                    </div>
                                </div><!-- Single Product Item End -->
                            </div>

                            <div class="col-lg-12">
                                <!-- Single Product Item Start -->
                                <div class="single-product-item text-center">
                                    <div class="products-images">
                                        <a href="product-details.html" class="product-thumbnail">
                                            <img src="../assets/images/product/1_5-300x300.jpg" class="img-fluid" alt="Product Images">

                                        </a>
                                        <div class="product-actions">
                                            <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                            <a href="product-details.html"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                            <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h6 class="prodect-title"><a href="product-details.html">Living room & Bedroom lights</a></h6>
                                        <div class="prodect-price">
                                            <span class="new-price">£60.00</span> - <span class="old-price"> £69.00</span>
                                        </div>
                                    </div>
                                </div><!-- Single Product Item End -->
                            </div>

                            <div class="col-lg-12">
                                <!-- Single Product Item Start -->
                                <div class="single-product-item text-center">
                                    <div class="products-images">
                                        <a href="product-details.html" class="product-thumbnail">
                                            <img src="../assets/images/product/1_6-300x300.jpg" class="img-fluid" alt="Product Images">

                                        </a>
                                        <div class="product-actions">
                                            <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                            <a href="product-details.html"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                            <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h6 class="prodect-title"><a href="product-details.html">Gray lamp</a></h6>
                                        <div class="prodect-price">
                                            <span class="new-price">£80.00</span>
                                        </div>
                                    </div>
                                </div><!-- Single Product Item End -->
                            </div>

                            <div class="col-lg-12">
                                <!-- Single Product Item Start -->
                                <div class="single-product-item text-center">
                                    <div class="products-images">
                                        <a href="product-details.html" class="product-thumbnail">
                                            <img src="../assets/images/product/1_7-300x300.jpg" class="img-fluid" alt="Product Images">

                                        </a>
                                        <div class="product-actions">
                                            <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                            <a href="product-details.html"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                            <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h6 class="prodect-title"><a href="product-details.html">Decoration wood</a></h6>
                                        <div class="prodect-price">
                                            <span class="new-price">£50.00</span>
                                        </div>
                                    </div>
                                </div><!-- Single Product Item End -->
                            </div>

                            <div class="col-lg-12">
                                <!-- Single Product Item Start -->
                                <div class="single-product-item text-center">
                                    <div class="products-images">
                                        <a href="product-details.html" class="product-thumbnail">
                                            <img src="../assets/images/product/1_8-300x300.jpg" class="img-fluid" alt="Product Images">

                                        </a>
                                        <div class="product-actions">
                                            <a href="#" data-toggle="modal" data-target="#prodect-modal"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                            <a href="product-details.html"><i class="p-icon icon-bag2"></i> <span class="tool-tip">Add to cart</span></a>
                                            <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span class="tool-tip">Browse Wishlist</span></a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h6 class="prodect-title"><a href="product-details.html">Teapot with black tea</a></h6>
                                        <div class="prodect-price">
                                            <span class="new-price">£20.00</span> - <span class="old-price"> £135.00</span>
                                        </div>
                                    </div>
                                </div><!-- Single Product Item End -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


            <script>
                var fixmeTop = $('.fixme').offset().top;
                $(window).scroll(function() {
                    var currentScroll = $(window).scrollTop();
                    if (currentScroll >= fixmeTop) {
                        $('.fixme').css({
                            position: 'fixed',
                            top: '0',
                            left: '0'
                        });
                    } else {
                        $('.fixme').css({
                            position: 'static'
                        });
                    }
                });
            </script>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop">
    <div class="modal-dialog modal-xl shadow-lg border-0">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title " id="staticBackdrop">Tassen-Konfigurator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mt-5">
                <div class="row">
                    <div class="col-12 col-lg-6 text-center">
                        <img src="{{--asset('assets/images/white_classic.png') --}}" alt="" class="img-fluid w-75">
                    </div>

                    <div class="col-12 col-lg-5">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <div class="card-body pt-0">
                                    <div class="product-size-wrapper">
                                        <div class="tab-content d-flex">
                                            {{-- foreach($mug_images as $image): --}}
                                                <div class="tab-pane fade mb-2 position-absolute" style="width: 200px;height: 40px;" id="{{--$image->img_name--}}) ">
                                                     {{--$image->img_name --}}
                                                </div>
                                            {{--  endforeach --}}
                                        </div>

                                        <ul class="nav image-swatches-nav mt-5" role="tablist">
                                            {{-- foreach($mug_images as $image):--}}
                                                <li class="tab__item nav-item active">
                                                    <a class="nav-link border p-2 rounded" data-toggle="tab" href="#str_replace(' ','', {{--$image->img_name--}}) ?>" role="tab">
                                                        <div class="sm-image"><img src="{{--asset(''.{{--$image->img_path--}}" alt="product image thumb"></div>
                                                    </a>
                                                </li>
                                             {{--endforeach; --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <div class="card-body pt-0">
                                    <div class="product-size-wrapper">
                                        <div class="tab-content d-flex">
                                             {{-- foreach($bg_images as $image): -- }}
                                                <div class="tab-pane fade mb-2 position-absolute" style="width: 200px;height: 40px;" id="str_replace(' ','', $image->img_name) ">
                                                   {{--$image->img_name--}}
                                                </div>
                                            {{-- endforeach --}}
                                        </div>

                                        <ul class="nav image-swatches-nav mt-5" role="tablist">
                                            {{--foreach($bg_images as $image)--}}
                                                <li class="tab__item nav-item active">
                                                    <a class="nav-link border p-2 rounded" data-toggle="tab" href="# {{--str_replace(' ','', $image->img_name) --}}" role="tab">
                                                        <div class="sm-image"><img src="{{-- asset(''.{{--$image->img_path--}}.'') --}}" alt="product image thumb"></div>
                                                    </a>
                                                </li>
                                           {{--endforeach--}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                <label for="exampleFormControlTextarea1">Schreibe hier Deinen Wunschetxt ein, der auf der Rückseite der Tasse stehen soll.</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="hautfarbe" aria-selected="true"><img src="https://i.imgur.com/BqHId22.png" class="img-fluid"></a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="hair" aria-selected="false"><img src="https://i.imgur.com/MibUpYy.png" class="img-fluid"></a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#hijab" role="tab" aria-controls="cap" aria-selected="false"><img src="https://i.imgur.com/p1ovQH5.png" class="img-fluid"></a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="hose" aria-selected="false"><img src="https://i.imgur.com/JzFanxU.png" alt="" class="img-fluid"></a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="card-body pt-0">
                                            <div class="product-size-wrapper">
                                                <div class="tab-content d-flex">
                                                    {{-- foreach($body_color as $image) --}}
                                                        <div class="tab-pane fade mb-2 position-absolute" style="width: 200px;height: 40px;" id=" str_replace(' ','', {{--$image->img_name--}}) ?>">
                                                           {{-- $image->img_name --}}
                                                        </div>
                                                   {{--endforeach--}}
                                                </div>

                                                <ul class="nav image-swatches-nav mt-5" role="tablist">
                                                     {{--foreach($body_color as $image)--}}
                                                        <li class="tab__item nav-item active">
                                                            <a class="nav-link border p-2 rounded" data-toggle="tab" href="#str_replace(' ','', {{--$image->img_name--}}) ?>" role="tab">
                                                                <div class="sm-image"><img src="{{-- asset(''.{{--$image->img_path--}}" alt="product image thumb"></div>
                                                            </a>
                                                        </li>
                                                    {{-- endforeach --}}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="contact-tab">
                                        <div class="card-body pt-0">
                                            <div class="product-size-wrapper">
                                                <div class="tab-content d-flex">
                                                   {{-- foreach($hair_color as $image): --}}
                                                        <div class="tab-pane fade mb-2 position-absolute" style="width: 200px;height: 40px;" id="str_replace(' ','', {{--$image->img_name--}}) ?>">
                                                             {{--$image->img_name --}}
                                                        </div>
                                                    {{-- endforeach --}}
                                                </div>

                                                <ul class="nav image-swatches-nav mt-5" role="tablist">
                                                   {{-- foreach($hair_color as $image): --}}
                                                        <li class="tab__item nav-item active">
                                                            <a class="nav-link border p-2 rounded" data-toggle="tab" href="# str_replace(' ','', {{--$image->img_name--}}) ?>" role="tab">
                                                                <div class="sm-image"><img src="{{-- asset(''.{{--$image->img_path--}}" alt="product image thumb"></div>
                                                            </a>
                                                        </li>
                                                    {{--endforeach --}}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="hijab" role="tabpanel" aria-labelledby="contact-tab">
                                        <div class="card-body pt-0">
                                            <div class="product-size-wrapper">
                                                <div class="tab-content d-flex">
                                                    {{--foreach($hijabs as $image)--}}
                                                        <div class="tab-pane fade mb-2 position-absolute" style="width: 200px;height: 40px;" id=" str_replace(' ','', {{--$image->img_name--}}) ?>">
                                                           {{--$image->img_name --}}
                                                        </div>
                                                    {{-- endforeach --}}
                                                </div>

                                                <ul class="nav image-swatches-nav mt-5" role="tablist">
                                                 {{--foreach($hijabs as $image): --}}
                                                        <li class="tab__item nav-item active">
                                                            <a class="nav-link border p-2 rounded" data-toggle="tab" href="# str_replace(' ','',{{--$image->img_name--}} ) ?>" role="tab">
                                                                <div class="sm-image"><img src="{{--asset(''.{{--$image->img_path--}}.'') --}}" alt="product image thumb"></div>
                                                            </a>
                                                        </li>
                                                   {{--endforeach--}}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        <div class="card-body pt-0">
                                            <div class="product-size-wrapper">
                                                <div class="tab-content d-flex">
                                                    {{-- foreach($jeans as $image) --}} :
                                                        <div class="tab-pane fade mb-2 position-absolute" style="width: 200px;height: 40px;" id=" str_replace(' ','',{{--$image->img_name--}} ) ?>">
                                                           {{--$image->img_name  --}}
                                                        </div>
                                                    {{-- endforeach --}}
                                                </div>

                                                <ul class="nav image-swatches-nav mt-5" role="tablist">
                                                    {{-- foreach($jeans as $image)--}} :
                                                        <li class="tab__item nav-item active">
                                                            <a class="nav-link border p-2 rounded" data-toggle="tab" href="#str_replace(' ','', {{--$image->img_name--}}) ?>" role="tab">
                                                                <div class="sm-image"><img src="{{--url(''.{{--$image->img_path--}}.'')}}" alt="product image thumb"></div>
                                                            </a>
                                                        </li>
                                                    {{--endforeach --}}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-1">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a data-tooltip="Tasse" class="nav-link active mb-2 border rounded" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="ml-1 my-2" data-feather="coffee"></i></a>
                            <a data-tooltip="Hintergrund" class="nav-link mb-2 border rounded" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="ml-1 my-2" data-feather="image"></i></a>
                            <a data-tooltip="Spruch" class="nav-link mb-2 border rounded" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="ml-1 my-2" data-feather="type"></i></a>
                            <a data-tooltip="Person" class="nav-link mb-2 border rounded mt-4" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="ml-1 my-2" data-feather="user"></i></a>
                            <a data-tooltip="Person hinzufügen" class="nav-link mb-2 border rounded" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="ml-1 my-2" data-feather="user-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-5">
                <button type="button" class="btn btn-secondary rounded px-5" data-dismiss="modal">Schließen</button>
                <button type="button" class="btn btn-primary rounded">Konfiguration übernehmen</button>
            </div>
        </div>
    </div>
</div>
@endsection
