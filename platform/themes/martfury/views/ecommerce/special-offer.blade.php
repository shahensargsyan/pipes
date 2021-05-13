@php
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

        Theme::layout('pipes');
        Theme::breadcrumb(false);
        $start  = new \Carbon\Carbon();
        $totalDuration = 0;
        if(!$order->created_at->addMinutes(15)->isPast())
            $totalDuration = $order->created_at->addMinutes(15)->timestamp.'000';
@endphp
<div class="gardenhose-timer-section">
<div class="container">
    <div id="clockdiv" timestamp="<?php echo $totalDuration; ?>">
        <div>
            <span class="hours"></span>
            <div class="smalltext">Hours</div>
        </div>
        <div>
            <span class="minutes"></span>
            <div class="smalltext">Minutes</div>
        </div>
        <div>
            <span class="seconds"></span>
            <div class="smalltext">Seconds</div>
        </div>
    </div>
    <div class="gardenhose_timer_right_text">
        Act Fast: Grab this one-time exclusive offer before time runs out. This offer is not available elsewhere on
        the
        site.
    </div>
</div>
</div>


<div class="gardenhose-landing-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gardenhose-logo">
                    <img src="{!! Theme::asset()->url('/pipes/images/wash-pipe-pro-logo-ff.svg') !!}">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="gardenhose-landing-section2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gardenhose-progressbar">
                    <div class="gardenhose-current-step-text">Step 2 of 3: Customize your order</div>
                    <div class="gardenhose-progress-meter">
                        <div class="gardenhose-progress-scale"><span>57%</span> Complete</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="gardenhose-landing-section3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gardenhose-top-headings">
                    <h1 class="gardenhose-top-heading">Wait <span
                            class="gardenhose-highlight">{{ $order->address->first_name.' '.$order->address->last_name  }}</span>! Here's an exclusive offer to
                        complement your order!</h1>
                    <h2 class="gardenhose-top-sub-heading">Add this to your order and get a 30% discount. We will ship
                        it with other items.</h2>
                </div>
            </div>
        </div>
    </div>
</div>



<div id="shop_product" class="lnd_section3">
    <div class="container">
        <div class="row">
            <div class="col-md-7">

                <div id="gallery-slider1" class="gallery-slider ps-product__variants">
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
                        <del><span class="was"></span><span><span class="was_price-amount">@if ($product->front_sale_price !== $product->price) {{ format_price($product->price_with_taxes) }} @endif</span></span>
                        </del>
                        <p class="price_now">
                            <span class="Price-amount">{{ format_price($product->front_sale_price_with_taxes) }}</span>
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

                    </div>
                    <span class="desc_title">{{ __('Description') }}</span>
                    <p class="product_short-description">
                        {!! clean($product->description) !!}
                    </p>
                    <form class="add-to-cart-form" method="POST" action="{{ route('payments.paypal.post-patch-order') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{  $token }}">

                        {!! apply_filters(ECOMMERCE_PRODUCT_DETAIL_EXTRA_HTML, null) !!}
                        <div class="color-and-price">
                            <div class="row_color_price">
                                <div class="choose_color_row"><br>
                                    @if ($product->variations()->count() > 0)
                                        <span class="color_title">Choose color</span>
                                        <div class="pr_switch_wrap">
                                            {!! render_product_swatches($product, [
                                                'selected' => $selectedAttrs,
                                                'view'     => Theme::getThemeNamespace() . '::views.ecommerce.attributes.swatches-renderer'
                                            ]) !!}
                                        </div>
                                        <div class="number-items-available" style="display: block; margin-bottom: 10px;">
                                            (Only {{$product->defaultVariation->product->quantity}} left in stock)
                                        </div>
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
                                <button class=" single_add_to_cart_button">{{ __('Add to Order') }}</button>
                            @endif

                        </div>
                        <div class="row gardenhose-skip">
                            <a href="{{ route('payments.paypal.finish-order', $order->token)  }}" class="gardenhose_skip_offer gardenhose-skip-offer-link ">
                                I don’t want to take advantage of this one-time offer
                            </a>
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
