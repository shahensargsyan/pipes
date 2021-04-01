@php
//dd(Route::currentRouteAction());
    $originalProduct = $product;
    $selectedAttrs = [];
    $productImages = $product->images;
    if ($product->is_variation) {
        $product = get_parent_product($product->id);
        $selectedAttrs = app(\Botble\Ecommerce\Repositories\Interfaces\ProductVariationInterface::class)
            ->getAttributeIdsOfChildrenProduct($originalProduct->id);
        if (count($productImages) == 0) {
            $productImages = $product->images;
        }
    } else {
        $selectedAttrs = $product->defaultVariation->productAttributes->pluck('id')->all();
    }

    $countRating = $reviews->count();

    Theme::layout('pipes');
    Theme::set('stickyHeader', 'false');
    Theme::set('topHeader', Theme::partial('header-product-page', compact('product', 'countRating')));
    Theme::set('bottomFooter', Theme::partial('footer-product-page', compact('product')));
    Theme::set('pageId', 'product-page');
    Theme::set('headerMobile', Theme::partial('header-mobile-product'));
    Theme::breadcrumb(false);

@endphp

<div class="lnd_section1_banner">
    <div class="lnd_section1">
        <div class="container">
            <div class="top_section_info">
                <h1>{{ $product->head_title }}</h1>
                <p>{!! clean($product->head_description) !!}</p>
                <div class="top_btns">
                    <a href="#shop_product" class="want_it_btn">I WANT IT</a>
                    <div class="video_div">
                        <button type="button" class="btn btn-primary video-btn" data-toggle="modal"
                                data-src=" {!! Theme::asset()->url('/pipes/images/video.mp4') !!}" data-target="#myModal">
                            WATCH VIDEO
                            <p><span><i class="fas fa-play"></i></span></p>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item" src="" id="video"
                                                    allowscriptaccess="always" allow="autoplay"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="benefits" class="lnd_section2">
    <div class="container">
        <div class="lnd_sect2_info">
            <div class="lnd_sect2_info_item">
                <img src="{!! Theme::asset()->url('/pipes/images/easy-to-use.svg') !!}">
                <div>
                    <h3>Easy to use</h3>
                    <p>The hose is very flexible, it makes it easy to move around, store and use daily. </p>
                </div>
            </div>
            <div class="lnd_sect2_info_item">
                <img src="{!! Theme::asset()->url('/pipes/images/reliable-robust.svg') !!}">
                <div>
                    <h3>Reliable, Robust, and strong </h3>
                    <p>This hose features 2 layers of PVC nitrile compound, which makes it very strong, durable, and ensures the longevity of the hose.</p>
                </div>
            </div>
            <div class="lnd_sect2_info_item">
                <img src="{!! Theme::asset()->url('/pipes/images/flexible.svg') !!}">
                <div>
                    <h3>Flexible and tangle resistant</h3>
                    <p>The product is very flexible and features a stylish holder. It won’t get tangled either as it features exterior longitudinal fluting.</p>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="shop_product" class="lnd_section3">
    <div class="container">
        <div class="row">
            <div class="col-md-7">

                <div id="gallery-slider1" class="gallery-slider">
                    <div class="gallery-slider__thumbnails">
                        <div>
                            @foreach ($productImages as $img)
                                <div class="item slides-to-show">
                                    <img src="{{ RvMedia::getImageUrl($img, 'thumb') }}" alt="{{ $originalProduct->name }}"/>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="gallery-slider__images">
                        <div>
                            @foreach ($productImages as $img)
                                <div class="item">
                                    <img src="{{ RvMedia::getImageUrl($img) }}" alt="{{ $originalProduct->name }}"/>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-md-5">
                <div class="sect2_right_info">
                    <h2 class="product_title">{{ $product->name }}</h2>
                    <div class="product_sale_price">
                        <del><span class="was"></span><span><span class="was_price-amount"><span
                                        class="was_price-currencySymbol"></span></span>@if ($product->front_sale_price !== $product->price) {{ format_price($product->price_with_taxes) }} @endif</span>
                        </del>
                        <p class="price_now">
                             <span class="Price-amount">
                                 <span class="Price-currency"></span>{{ format_price($product->front_sale_price_with_taxes) }}</span>
                        </p>
                    </div>
                    <div class="product_rating">
                        <div class="star_rating">
                            <div class="star_rating_div">
                                <div class="star-rating" role="img" aria-label="Rated 4.66 out of 5"><span
                                        style="width:100%">Rated <strong
                                            class="rating">4.66</strong> out of 5</span></div>
                            </div>
                        </div>
                        <div class="reviews_text">
                            <a href="#" class="reviews_text">
                                <span class="rate_txt">  (64)<span class="count"></span> {{ __('Reviews') }}</span>
                            </a>
                        </div>
                    </div>
                    <span class="desc_title">{{ __('Description') }}</span>
                    <p class="product_short-description">
                        {!! clean($product->description) !!}
                    </p>
                    <form class="add-to-cart-form" method="POST" action="{{ route('public.cart.add-to-cart') }}">
                        @csrf
                        {!! apply_filters(ECOMMERCE_PRODUCT_DETAIL_EXTRA_HTML, null) !!}
                        <div class="color-and-price">
                            <div class="row_color_price">
                                <div class="choose_color_row">
                                    <span class="color_title">Choose color</span>
                                    @if ($product->variations()->count() > 0)
                                        <div class="pr_switch_wrap">
                                            {!! render_product_swatches($product, [
                                                'selected' => $selectedAttrs,
                                                'view'     => Theme::getThemeNamespace() . '::views.ecommerce.attributes.swatches-renderer'
                                            ]) !!}
                                        </div>
                                        <div class="number-items-available" style="display: none; margin-bottom: 10px;"></div>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="quant_btn_row">
                            <div class="quantity product__qty">
                                <input type="hidden" name="id" class="hidden-product-id" value="{{ ($originalProduct->is_variation || !$originalProduct->defaultVariation->product_id) ? $originalProduct->id : $originalProduct->defaultVariation->product_id }}"/>


                                <input type="hidden" class="form-control qty-input" type="text" name="qty" value="1" placeholder="1" readonly>
                                <div class="custom_qty"><span
                                        class="product_count_numb product_count_numb_min minus down" id="mins">-</span>
                                    <label
                                        class="screen-reader-text" for="quantity"></label>
                                    <input type="number" id="quantity" class="input-text qty text" min="1" max=""
                                           name="quantity" value="1" title="Qty" size="4" placeholder=""/>
                                    <span class="product_count_numb product_count_numb_plus plus up" id="plus">+</span>
                                </div>
                            </div>
                            @if (EcommerceHelper::isCartEnabled())
                                <button class="ps-btn ps-btn--black single_add_to_cart_button button" type="submit">{{ __('Add to cart') }}</button>
                                @if (EcommerceHelper::isQuickBuyButtonEnabled())
{{--                                    <button class="ps-btn" type="submit" name="checkout">{{ __('Buy Now') }}</button>--}}
                                @endif
                            @endif
{{--                            <button type="submit" name="add-to-cart" value=""--}}
{{--                                    class="single_add_to_cart_button button">BUY NOW--}}
{{--                            </button>--}}
                        </div>
                    </form>
                    <div class="lnd_section3_row">
                        <div class="row">
                            <div class="col__left">
                                <div class="lnd_sect3_bottom">
                                    <img src="{!! Theme::asset()->url('/pipes/images/free-delivery.svg') !!}">
                                    <p>Free delivery</p>
                                </div>
                                <div class="lnd_sect3_bottom">
                                    <img src="{!! Theme::asset()->url('/pipes/images/payment-security.svg') !!}">
                                    <p>Payment Security</p>
                                </div>
                            </div>
                            <div class="col__right">
                                <div class="lnd_sect3_bottom">
                                    <img src="{!! Theme::asset()->url('/pipes/images/24-7.svg') !!}">
                                    <p>24/7 Customer Service</p>
                                </div>
                                <div class="lnd_sect3_bottom">
                                    <img src="{!! Theme::asset()->url('/pipes/images/money-back-guarantee.svg') !!}">
                                    <p>30 Days Money Back Guarantee</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="faq" class="lnd_section4_banner">
    <div class="lnd_section4">
        <div class="container">
            <h2 class="faq_title">FAQ</h2>
            <div class="faq-area">
                @foreach($faqs as $faq)
                    <button class="accordion">{{ $faq->question }}
                        <img class="faq_plus" src="{!! Theme::asset()->url('/pipes/images/plus.svg') !!}">
                        <img class="faq_minus" src="{!! Theme::asset()->url('/pipes/images/minus.svg') !!}">
                        <div class="panel" style="display: none;">
                            {!! clean($faq->answer) !!}
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>



<div class="lnd_section5">
    <div class="container">
        <div class="lnd_sect5_left">
            <img src="{!! Theme::asset()->url('/pipes/images/banner@2x.png') !!}">
        </div>
        <div class="lnd_sect5_right">
            <h1 class="sect5_title">{{ $product->middle_title }}</h1>
            <p class="sect5_description">{!! clean($product->middle_description) !!}</p>
            <a href="#shop_product" class="sect5_buyNowBtn">BUY NOW</a>
        </div>
    </div>
</div>

<div id="review" class="lnd_section6_banner">
    <div class="lnd_section6">
        <div class="container">
            <h2 class="reviews_title">REVIEWS</h2>
            <div id="carousel" class="reviews_div slider">
                @foreach($reviews as $review)
                    <div class="slider-item reviews_item">
                        <div class="rev_product_img">
                            <img src="/storage/{{$review->user->avatar}}">
                        </div>
                        <div class="rev_product_info">
                            <h3>{{$review->user->name}}</h3>
                            <div class="star_rating_div">
                                <div class="star-rating" role="img" aria-label="Rated 4.66 out of 5"><span
                                        style="width:{{$review->star*20}}%">Rated <strong
                                            class="rating">4.66</strong> out of 5</span></div>
                            </div>
                            <div class="rev_product_description">
                                <p>
                                    {{$review->comment}}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
