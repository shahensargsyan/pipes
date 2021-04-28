@php
    $crossSellProducts = [];
    Theme::layout('pipes');
@endphp
{!! Html::style('vendor/core/core/base/libraries/toastr/toastr.min.css') !!}

{!! Html::script('vendor/core/plugins/ecommerce/js/checkout.js?v=1.0.3') !!}

{!! Html::script('vendor/core/plugins/ecommerce/js/utilities.js') !!}
{!! Html::script('vendor/core/core/base/libraries/toastr/toastr.min.js') !!}

<script type="text/javascript">
    window.messages = {
        error_header: '{{ __('Error') }}',
        success_header: '{{ __('Success') }}',
    }
</script>

@if (session()->has('success_msg') || session()->has('error_msg') || isset($errors))
    <script type="text/javascript">
        $(document).ready(function () {
            @if (session()->has('success_msg'))
            MainCheckout.showNotice('success', '{{ session('success_msg') }}');
            @endif
            @if (session()->has('error_msg'))
            MainCheckout.showNotice('error', '{{ session('error_msg') }}');
            @endif
            @if (isset($errors))
            @foreach ($errors->all() as $error)
            MainCheckout.showNotice('error', '{{ $error }}');
            @endforeach
            @endif
        });
    </script>
@endif

    <link rel="stylesheet" href="{{ asset('vendor/core/plugins/payment/libraries/card/card.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/core/plugins/payment/css/payment.css') }}?v=1.0.2">

    @if (Cart::instance('cart')->count() > 0)
        {!! Form::open(['route' => ['public.checkout.process', $token], 'class' => 'checkout-form payment-checkout-form', 'id' => 'checkout-form']) !!}
        <input type="hidden" name="checkout-token" id="checkout-token" value="{{ $token }}">
        @php
            $productIds = Cart::instance('cart')->content()->pluck('id')->toArray();
            if ($productIds) {
                $products = get_products([
                    'condition' => [
                        ['ec_products.id', 'IN', $productIds],
                    ],
                ]);
            }
        @endphp

        <section class="design-process-section cart_page" id="process-tab">
            <div class="container">
                <!-- design process steps-->
                <!-- Nav tabs -->
                <ul class="nav nav-tabs process-model more-icon-preocess" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#customer-info" aria-controls="customer-info" role="tab"
                           data-toggle="tab"><span>1</span>
                            <p>CUSTOMER INFO</p>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#payment" aria-controls="payment" role="tab" data-toggle="tab"><span>2</span>
                            <p>PAYMENT METHOD</p>
                        </a>
                    </li>
                </ul>
                <!-- end design process steps-->
                <!-- Tab panes -->
                @if (isset($products) && $products)
                    <p>{{ __('Product(s)') }}:</p>
                    @foreach(Cart::instance('cart')->content() as $key => $cartItem)

                        @php
                            $product = $products->where('id', $cartItem->id)->first();
                        @endphp

                        @if(!empty($product))
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="customer-info">
                                    <div class="design-process-content">
                                        <h2 class="cart_title">CUSTOMER INFO</h2>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="checkout_form">
                                                    <form>
                                                        <div class="checkout_input_row">
                                                            <div class="check_input @if ($errors->has('address.first_name')) has-error @endif">
                                                                <input type="text" name="address[first_name]" id="address[name]" placeholder="{{ __('First Name') }}" class="form-control address-control-item checkout-input"
                                                                       value="{{ old('address.first_name', Arr::get($sessionCheckoutData, 'first_name')) }}">
                                                                {!! Form::error('address.first_name', $errors) !!}
                                                            </div>
                                                            <div class="check_input @if ($errors->has('address.last_name')) has-error @endif">
                                                                <input type="text" name="address[last_name]" id="address[name]" placeholder="{{ __('Last Name') }}" class="form-control address-control-item checkout-input"
                                                                       value="{{ old('address.last_name', Arr::get($sessionCheckoutData, 'last_name')) }}">
                                                                {!! Form::error('address.last_name', $errors) !!}
                                                            </div>
                                                        </div>
                                                        <div class="checkout_input_row">
                                                            <div class="check_input @if ($errors->has('address.company_name')) has-error @endif">
                                                                <input type="text" name="address[company_name]" id="address[name]" placeholder="{{ __('Company Name') }}" class="form-control address-control-item checkout-input"
                                                                       value="{{ old('address.company_name', Arr::get($sessionCheckoutData, 'company_name')) }}">
                                                                {!! Form::error('address.company_name', $errors) !!}
                                                            </div>
                                                            <div class="check_input @if ($errors->has('address.email')) has-error @endif">
                                                                <input type="text" name="address[email]" id="address[name]" placeholder="{{ __('Email Address*') }}" class="form-control address-control-item checkout-input"
                                                                       value="{{ old('address.email', Arr::get($sessionCheckoutData, 'email')) }}">
                                                                {!! Form::error('address.email', $errors) !!}
                                                            </div>
                                                        </div>
                                                        <div class="checkout_input_row">
                                                            <div class="check_input @if ($errors->has('address.address')) has-error @endif">
                                                                <input type="text" name="address[address]" id="address[name]" placeholder="{{ __('Street Address*') }}" class="form-control address-control-item checkout-input"
                                                                       value="{{ old('address.address', Arr::get($sessionCheckoutData, 'address')) }}">
                                                                {!! Form::error('address.address', $errors) !!}
                                                            </div>

                                                            <div class="check_input @if ($errors->has('address.apartment')) has-error @endif">
                                                                <input type="text" name="address[apartment]" id="address[apartment]" placeholder="{{ __('Apartment') }}" class="form-control address-control-item checkout-input"
                                                                       value="{{ old('address.apartment', Arr::get($sessionCheckoutData, 'address')) }}">
                                                                {!! Form::error('address.apartment', $errors) !!}
                                                            </div>
                                                        </div>
                                                        <div class="checkout_input_row">
                                                            <div class="check_input @if ($errors->has('address.city')) has-error @endif">
                                                                <input type="text" name="address[city]" id="address[apartment]" placeholder="{{ __('Town / City*') }}" class="form-control address-control-item checkout-input"
                                                                       value="{{ old('address.city', Arr::get($sessionCheckoutData, 'city')) }}">
                                                                {!! Form::error('address.city', $errors) !!}
                                                            </div>
                                                            <div class="check_input">
                                                                <label>Country</label>
                                                                <select name="address[country]" class="form-control address-control-item" id="address_country">
                                                                    @foreach(['' => __('Select country...')] + EcommerceHelper::getAvailableCountries() as $countryCode => $countryName)
                                                                        <option value="{{ $countryCode }}" @if (old('address.country', Arr::get($sessionCheckoutData, 'country')) == $countryCode) selected @endif>{{ $countryName }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            {!! Form::error('address.country', $errors) !!}
                                                        </div>
                                                        <div class="checkout_input_row">
                                                            <div class="check_input">
                                                                <label>Post Code*</label>
                                                                <input type="text" placeholder="">
                                                            </div>
                                                            <div class="check_input">
                                                                <label>Phone</label>
                                                                <input type="text" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="check_input">
                                                            <label>Order Notes</label>
                                                            <textarea></textarea>
                                                        </div>
                                                        <div class="notif_info">
                                                            <p>By clicking the Place Order button, you confirm that you have read
                                                                and understood, and
                                                                accept our <a href="">Terms & Conditions</a>, <a href="">Return
                                                                    Policy</a> and <a
                                                                    href="">Privacy Policy</a>.</p>
                                                        </div>
                                                        <label class="check_btn_div"> Use this address as my billing address
                                                            <input type="checkbox" checked="checked">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="cart_totals-list">
                                                    <h3 class="order_title">Order Details</h3>
                                                    <div class="table_div">
                                                        <table class="table-module">
                                                            <tbody>
                                                            <tr class="cart-subtotal">
                                                                <th>Subtotal</th>
                                                                <td>
                                                <span class="Price-amount amount"><span
                                                        class="Price-currencySymbol">$</span>14.23</span>
                                                                </td>
                                                            </tr>
                                                            <tr class="shipping-totals">
                                                                <th>
                                                                    Shipping
                                                                </th>
                                                                <td>
                                                                    Free
                                                                </td>
                                                            </tr>
                                                            <tr class="order-total">
                                                                <th>Grand Total</th>
                                                                <td><strong>
                                            <span class="Price-amount amount">
                                            <span class="Price-currencySymbol">$</span>
                                                14.23</span>
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="promocode_form">
                                                    <h3 class="promocode_title">Promocode</h3>
                                                    <form class="">
                                                        <div class="promocode-input">
                                                            <input type="text" placeholder="Enter Code">
                                                            <input type="button" value="Apply">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="checkout_cont_btn">
                                                    <a href="">COUNTINUE</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="payment">
                                    <div class="design-process-content">
                                        <h2 class="cart_title">CUSTOMER INFO</h2>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <p class="cart_information">All transactions are secure and encrypted. Credit card
                                                    information is never stored on our servers.</p>
                                                <div class="checkout_form">
                                                    <form class="payment_form">
                                                        <div class="payment_list_row1 payment_check active">
                                                            <div class="payment_list">
                                                                <input type="radio" id="card" name="Card" value="cards" checked>
                                                                <label for="card">Credit Card
                                                                    <div class="cards_img">
                                                                        <img class="master" src="images/cards.png">
                                                                    </div>
                                                                </label>
                                                                <div class="check"></div>
                                                            </div>
                                                            <div class="payment_input_row">
                                                                <div class="payment_input card_number">
                                                                    <label>Card Number*</label>
                                                                    <input type="text" placeholder="1234 1234 1234 1234">
                                                                </div>
                                                            </div>
                                                            <div class="payment_input_row">
                                                                <div class="payment_input">
                                                                    <label>Expiry Date*</label>

                                                                    <div class="payment_date_inputs">
                                                                        <input type="text" placeholder="MM/YY">
                                                                    </div>
                                                                </div>
                                                                <div class="payment_input cvv_code">
                                                                    <label>Card Code (CVC)*</label>
                                                                    <input type="password" placeholder="CVC">
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="payment_list_row payment_check">
                                                            <div class="payment_list payment_input">
                                                                <input type="radio" id="banktransfer" name="Card"
                                                                       value="banktransfer" >
                                                                <label for="banktransfer">
                                                                    Direct Bank Transfer
                                                                </label>
                                                                <div class="check"></div>
                                                            </div>
                                                        </div>
                                                        <div class="payment_list_row payment_check">
                                                            <div class="payment_list payment_input">
                                                                <input type="radio" id="paypal" name="Card" value="paypal">
                                                                <label for="paypal">PayPal Express
                                                                    <div class="cards_img2">
                                                                        <img class="paypal" src="images/paypal-express@2x.png">
                                                                    </div>
                                                                </label>
                                                                <div class="check"></div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="cart_totals-list">
                                                    <h3 class="order_title">Order Details</h3>
                                                    <div class="table_div">
                                                        <table class="table-module">
                                                            <tbody>
                                                            <tr class="cart-subtotal">
                                                                <th>Subtotal</th>
                                                                <td>
                                                <span class="Price-amount amount"><span
                                                        class="Price-currencySymbol">$</span>14.23</span>
                                                                </td>
                                                            </tr>
                                                            <tr class="shipping-totals">
                                                                <th>
                                                                    Shipping
                                                                </th>
                                                                <td>
                                                                    Free
                                                                </td>
                                                            </tr>
                                                            <tr class="order-total">
                                                                <th>Grand Total</th>
                                                                <td><strong>
                                            <span class="Price-amount amount">
                                            <span class="Price-currencySymbol">$</span>
                                                14.23</span>
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="promocode_form">
                                                    <h3 class="promocode_title">Promocode</h3>
                                                    <form class="">
                                                        <div class="promocode-input">
                                                            <input type="text" placeholder="Enter Code">
                                                            <input type="button" value="Apply">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="payment_btn_row">
                                                    <button class="btn">PLACE ORDER</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </section>

        <div class="row">
            <div class="col-lg-7 col-md-6 col-12 left">

                @if (theme_option('logo'))
                    <div class="checkout-logo">
                        <a href="{{ url('/') }}" title="{{ theme_option('site_title') }}">
                            <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" class="img-fluid" width="150" alt="{{ theme_option('site_title') }}" />
                        </a>
                    </div>
                    <hr/>
                @endif

                <!-- for mobile device display -->
                <div class="d-sm-block d-md-none" style="padding: 0 15px;" id="main-checkout-product-info-mobile">
                    <div class="payment-info-loading" style="display: none;">
                        <div class="payment-info-loading-content">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>
                    <div id="cart-item">
                        @if (isset($products) && $products)
                            <p>{{ __('Product(s)') }}:</p>
                            @foreach(Cart::instance('cart')->content() as $key => $cartItem)

                                @php
                                    $product = $products->where('id', $cartItem->id)->first();
                                @endphp

                                @if(!empty($product))
                                    <div class="row cart-item">
                                        <div class="col-3">
                                            <div class="checkout-product-img-wrapper">
                                                <img class="item-thumb img-thumbnail img-rounded" src="{{ $cartItem->options['image']}}" alt="{{ $product->name ?? '' }}">
                                                <span class="checkout-quantity">{{ $cartItem->qty }}</span>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <p style="margin-bottom: 0;">{{ $product->name }}</p>
                                            <p style="margin-bottom: 0">
                                                @php $attributes = get_product_attributes($product->id) @endphp
                                                @if (!empty($attributes))
                                                    <small>
                                                        @foreach ($attributes as $attr)
                                                            @if (!$loop->last)
                                                                {{ $attr->attribute_set_title }}: {{ $attr->title }},
                                                            @else
                                                                {{ $attr->attribute_set_title }}: {{ $attr->title }}
                                                            @endif
                                                        @endforeach
                                                    </small>
                                                @endif
                                            </p>
                                            @if (!empty($cartItem->options['extras']) && is_array($cartItem->options['extras']))
                                                @foreach($cartItem->options['extras'] as $option)
                                                    @if (!empty($option['key']) && !empty($option['value']))
                                                        <p style="margin-bottom: 0;"><small>{{ $option['key'] }}: <strong> {{ $option['value'] }}</strong></small></p>
                                                    @endif
                                                @endforeach
                                            @endif

                                        </div>
                                        <div class="col-4 float-right">
                                            <p>{{ format_price($cartItem->price) }}</p>
                                        </div>
                                    </div> <!--  /item -->
                                @endif
                            @endforeach
                        @endif

                        <div class="row">
                            <div class="col-6">
                                <p>{{ __('Subtotal') }}:</p>
                            </div>
                            <div class="col-6">
                                <p class="price-text sub-total-text text-right"> {{ format_price(Cart::instance('cart')->rawSubTotal()) }} </p>
                            </div>
                        </div>
                        @if (session('applied_coupon_code'))
                            <div class="row coupon-information">
                                <div class="col-6">
                                    <p>{{ __('Coupon code') }}:</p>
                                </div>
                                <div class="col-6">
                                    <p class="price-text coupon-code-text"> {{ session('applied_coupon_code') }} </p>
                                </div>
                            </div>
                        @endif
                        @if ($couponDiscountAmount > 0)
                            <div class="row price discount-amount">
                                <div class="col-6">
                                    <p>{{ __('Coupon code discount amount') }}:</p>
                                </div>
                                <div class="col-6">
                                    <p class="price-text total-discount-amount-text"> {{ format_price($couponDiscountAmount) }} </p>
                                </div>
                            </div>
                        @endif
                        @if ($promotionDiscountAmount > 0)
                            <div class="row">
                                <div class="col-6">
                                    <p>{{ __('Promotion discount amount') }}:</p>
                                </div>
                                <div class="col-6">
                                    <p class="price-text"> {{ format_price($promotionDiscountAmount) }} </p>
                                </div>
                            </div>
                        @endif
                        @if (!empty($shipping))
                            <div class="row">
                                <div class="col-6">
                                    <p>{{ __('Shipping fee') }}:</p>
                                </div>
                                <div class="col-6 float-right">
                                    <p class="price-text shipping-price-text">{{ format_price($shippingAmount) }}</p>
                                </div>
                            </div>
                        @endif

                        @if (EcommerceHelper::isTaxEnabled())
                            <div class="row">
                                <div class="col-6">
                                    <p>{{ __('Tax') }}:</p>
                                </div>
                                <div class="col-6 float-right">
                                    <p class="price-text tax-price-text">{{ format_price(Cart::instance('cart')->rawTax()) }}</p>
                                </div>
                            </div>
                        @endif
                        <hr/>
                        <div class="row">
                            <div class="col-6">
                                <p>{{ __('Total') }}:</p>
                            </div>
                            <div class="col-6 float-right">
                                <p class="total-text raw-total-text"
                                   data-price="{{ Cart::instance('cart')->rawTotal() }}"> {{ ($promotionDiscountAmount + $couponDiscountAmount - $shippingAmount) > Cart::instance('cart')->rawTotal() ? format_price(0) : format_price(Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount + $shippingAmount) }} </p>
                            </div>
                        </div>

                    </div>

                    <div>
                        <hr />
                        @include('plugins/ecommerce::themes.discounts.partials.form')
                        <hr />
                    </div>
                </div> <!-- /mobile display -->

                <div class="form-checkout">
                    <form action="{{ route('payments.checkout') }}" method="post">
                        @csrf

                        <div>
                            <h5 class="checkout-payment-title">{{ __('Shipping information') }}</h5>
                            <input type="hidden" value="{{ route('public.checkout.save-information', $token) }}" id="save-shipping-information-url">
                            @include('plugins/ecommerce::orders.partials.address-form', compact('sessionCheckoutData'))
                        </div>
                        <br>

                        <div id="shipping-method-wrapper">
                            <h5 class="checkout-payment-title">{{ __('Shipping method') }}</h5>
                            <div class="shipping-info-loading" style="display: none;">
                                <div class="shipping-info-loading-content">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            @if (!empty($shipping))
                                <div class="payment-checkout-form">
                                    <input type="hidden" name="shipping_option" value="{{ old('shipping_option', $defaultShippingOption) }}">
                                    <ul class="list-group list_payment_method">
                                        @foreach ($shipping as $shippingKey => $shippingItem)
                                            @foreach($shippingItem as $subShippingKey => $subShippingItem)
                                                @include('plugins/ecommerce::orders.partials.shipping-option', [
                                                     'defaultShippingMethod' => $defaultShippingMethod,
                                                     'defaultShippingOption' => $defaultShippingOption,
                                                     'shippingOption'        => $subShippingKey,
                                                     'shippingItem'          => $subShippingItem,
                                                ])
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <p>{{ __('No shipping methods available!') }}</p>
                            @endif
                        </div>
                        <br>

                        <div>
                            <h5 class="checkout-payment-title">{{ __('Payment method') }}</h5>
                            <input type="hidden" name="amount" value="{{ ($promotionDiscountAmount + $couponDiscountAmount - $shippingAmount) > Cart::instance('cart')->rawTotal() ? 0 : Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount + $shippingAmount }}">
                            <input type="hidden" name="currency" value="{{ strtoupper(get_application_currency()->title) }}">
                            <input type="hidden" name="currency_id" value="{{ get_application_currency_id() }}">
                            <input type="hidden" name="callback_url" value="{{ route('public.payment.paypal.status') }}">
                            <input type="hidden" name="return_url" value="{{ route('public.checkout.success', $token) }}">
                            <ul class="list-group list_payment_method">
                                @if (setting('payment_stripe_status') == 1)
                                    <li class="list-group-item">
                                        <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_stripe"
                                               value="stripe" @if (!setting('default_payment_method') || setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::STRIPE) checked @endif data-toggle="collapse" data-target=".payment_stripe_wrap" data-parent=".list_payment_method">
                                        <label for="payment_stripe" class="text-left">
                                            {{ setting('payment_stripe_name', trans('plugins/payment::payment.payment_via_card')) }}
                                        </label>
                                        <div class="payment_stripe_wrap payment_collapse_wrap collapse @if (!setting('default_payment_method') || setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::STRIPE) show @endif">
                                            <div class="card-checkout">
                                                <div class="form-group">
                                                    <div class="stripe-card-wrapper"></div>
                                                </div>
                                                <div class="form-group @if ($errors->has('number') || $errors->has('expiry')) has-error @endif">
                                                    <div class="row">
                                                        <div class="col-sm-9">
                                                            <input placeholder="{{ trans('plugins/payment::payment.card_number') }}"
                                                                   class="form-control" type="text" id="stripe-number" data-stripe="number">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input placeholder="{{ trans('plugins/payment::payment.mm_yy') }}" class="form-control"
                                                                   type="text" id="stripe-exp" data-stripe="exp">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group @if ($errors->has('name') || $errors->has('cvc')) has-error @endif">
                                                    <div class="row">
                                                        <div class="col-sm-9">
                                                            <input placeholder="{{ trans('plugins/payment::payment.full_name') }}"
                                                                   class="form-control" id="stripe-name" type="text" data-stripe="name">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input placeholder="{{ trans('plugins/payment::payment.cvc') }}" class="form-control"
                                                                   type="text" id="stripe-cvc" data-stripe="cvc">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="payment-stripe-key" data-value="{{ setting('payment_stripe_client_id') }}"></div>
                                        </div>
                                    </li>
                                @endif
                                @if (setting('payment_paypal_status') == 1)
                                    <li class="list-group-item">
                                        <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_paypal"
                                               @if (setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::PAYPAL) checked @endif
                                               value="paypal">
                                        <label for="payment_paypal" class="text-left">{{ setting('payment_paypal_name', trans('plugins/payment::payment.payment_via_paypal')) }}</label>
                                    </li>
                                @endif

                                {!! apply_filters(PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS, null, ['amount' => ($promotionDiscountAmount + $couponDiscountAmount - $shippingAmount) > Cart::instance('cart')->rawTotal() ? 0 : Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount + $shippingAmount, 'currency' => strtoupper(get_application_currency()->title), 'name' => null]) !!}

                                @if (setting('payment_cod_status') == 1)
                                    <li class="list-group-item">
                                        <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_cod"
                                               @if (setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::COD) checked @endif
                                               value="cod" data-toggle="collapse" data-target=".payment_cod_wrap" data-parent=".list_payment_method">
                                        <label for="payment_cod" class="text-left">{{ setting('payment_cod_name', trans('plugins/payment::payment.payment_via_cod')) }}</label>
                                        <div class="payment_cod_wrap payment_collapse_wrap collapse @if (setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::COD) show @endif" style="padding: 15px 0;">
                                            {!! clean(setting('payment_cod_description')) !!}
                                        </div>
                                    </li>
                                @endif
                                @if (setting('payment_bank_transfer_status') == 1)
                                    <li class="list-group-item">
                                        <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_bank_transfer"
                                               @if (setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::BANK_TRANSFER) checked @endif
                                               value="bank_transfer" data-toggle="collapse" data-target=".payment_bank_transfer_wrap" data-parent=".list_payment_method">
                                        <label for="payment_bank_transfer" class="text-left">{{ setting('payment_bank_transfer_name', trans('plugins/payment::payment.payment_via_bank_transfer')) }}</label>
                                        <div class="payment_bank_transfer_wrap payment_collapse_wrap collapse @if (setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::BANK_TRANSFER) show @endif" style="padding: 15px 0;">
                                            {!! clean(setting('payment_bank_transfer_description')) !!}
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <br>

                        <div class="form-group @if ($errors->has('description')) has-error @endif">
                            <label for="description" class="control-label">{{ __('Note') }}</label>
                            <br>
                            <textarea name="description" id="description" rows="3" class="form-control" placeholder="{{ __('Note') }}...">{{ old('description') }}</textarea>
                            {!! Form::error('description', $errors) !!}
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 d-none d-md-block" style="line-height: 53px">
                                    <a class="text-info" href="{{ route('public.cart') }}"><i class="fas fa-long-arrow-alt-left"></i> {{ __('Back to cart') }}</a>
                                </div>
                                <div class="col-md-6" style="margin-bottom: 40px">
                                    <button type="submit" class="btn payment-checkout-btn payment-checkout-btn-step float-right" data-processing-text="{{ __('Processing. Please wait...') }}" data-error-header="{{ __('Error') }}">
                                        {{ __('Checkout') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div> <!-- /form checkout -->

            </div>
            <!---------------------- start right column ---------------- -->
            <div class="col-lg-5 col-md-6 d-none d-md-block right"  id="main-checkout-product-info">
                <div class="payment-info-loading" style="display: none;">
                    <div class="payment-info-loading-content">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </div>
                @if (isset($products) && $products)
                    @foreach(Cart::instance('cart')->content() as $key => $cartItem)
                        @php
                            $product = $products->where('id', $cartItem->id)->first();
                        @endphp
                        @if(!empty($product))
                            <div class="row product-item">
                                <div class="col-lg-2 col-md-2">
                                    <div class="checkout-product-img-wrapper">
                                        <img class="item-thumb img-thumbnail img-rounded" src="{{ $cartItem->options['image']}}" alt="{{ $product->name ?? '' }}">
                                        <span class="checkout-quantity">{{ $cartItem->qty }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-5">
                                    <p style="margin-bottom: 0;">{{ $product->name }}</p>
                                    <p style="margin-bottom: 0">
                                        <small>
                                            @php
                                                $attributes = get_product_attributes($product->id);
                                            @endphp

                                            @if (!empty($attributes))
                                                @foreach ($attributes as $attr)
                                                    @if (!$loop->last)
                                                        {{ $attr->attribute_set_title }}: {{ $attr->title }},
                                                    @else
                                                        {{ $attr->attribute_set_title }}: {{ $attr->title }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </small>
                                    </p>
                                    @if (!empty($cartItem->options['extras']) && is_array($cartItem->options['extras']))
                                        @foreach($cartItem->options['extras'] as $option)
                                            @if (!empty($option['key']) && !empty($option['value']))
                                                <p style="margin-bottom: 0;"><small>{{ $option['key'] }}: <strong> {{ $option['value'] }}</strong></small></p>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col-lg-4 col-md-4 col-4 float-right">
                                    <p class="price-text">
                                        <span>{{ format_price($cartItem->price) }}</span>
                                    </p>
                                </div>
                            </div> <!--  /item -->
                        @endif
                    @endforeach
                @endif
                <hr />
                @include('plugins/ecommerce::themes.discounts.partials.form')
                <hr/>
                <div class="row price">
                    <div class="col-lg-7 col-md-8 col-5">
                        <p>{{ __('Subtotal') }}:</p>
                    </div>
                    <div class="col-lg-5 col-md-4 col-5">
                        <p class="price-text sub-total-text"> {{ format_price(Cart::instance('cart')->rawSubTotal()) }} </p>
                    </div>
                </div>
                @if (session('applied_coupon_code'))
                    <div class="row coupon-information">
                        <div class="col-lg-7 col-md-8 col-5">
                            <p>{{ __('Coupon code') }}:</p>
                        </div>
                        <div class="col-lg-5 col-md-4 col-5">
                            <p class="price-text coupon-code-text"> {{ session('applied_coupon_code') }} </p>
                        </div>
                    </div>
                @endif
                @if ($couponDiscountAmount > 0)
                    <div class="row price discount-amount">
                        <div class="col-lg-7 col-md-8 col-5">
                            <p>{{ __('Coupon code discount amount') }}:</p>
                        </div>
                        <div class="col-lg-5 col-md-4 col-5">
                            <p class="price-text total-discount-amount-text"> {{ format_price($couponDiscountAmount) }} </p>
                        </div>
                    </div>
                @endif
                @if ($promotionDiscountAmount > 0)
                    <div class="row">
                        <div class="col-lg-7 col-md-8 col-5">
                            <p>{{ __('Promotion discount amount') }}:</p>
                        </div>
                        <div class="col-lg-5 col-md-4 col-5">
                            <p class="price-text"> {{ format_price($promotionDiscountAmount) }} </p>
                        </div>
                    </div>
                @endif
                @if (!empty($shipping))
                    <div class="row shipment">
                        <div class="col-lg-7 col-md-8 col-5">
                            <p>{{ __('Shipping fee') }}:</p>
                        </div>
                        <div class="col-lg-5 col-md-4 col-5 float-right">
                            <p class="price-text shipping-price-text"> {{ format_price($shippingAmount) }} </p>
                        </div>
                    </div>
                @endif
                @if (EcommerceHelper::isTaxEnabled())
                    <div class="row shipment">
                        <div class="col-lg-7 col-md-8 col-5">
                            <p>{{ __('Tax') }}:</p>
                        </div>
                        <div class="col-lg-5 col-md-4 col-5 float-right">
                            <p class="price-text tax-price-text"> {{ format_price(Cart::instance('cart')->rawTax()) }} </p>
                        </div>
                    </div>
                @endif
                <hr/>
                <div class="row total-price">
                    <div class="col-lg-7 col-md-8 col-5">
                        <p>{{ __('Total') }}:</p>
                    </div>
                    <div class="col-lg-5 col-md-4 col-5 float-right">
                        <p class="total-text raw-total-text"
                           data-price="{{ Cart::instance('cart')->rawTotal() }}"> {{ ($promotionDiscountAmount + $couponDiscountAmount - $shippingAmount) > Cart::instance('cart')->rawTotal() ? format_price(0) : format_price(Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount + $shippingAmount) }} </p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if (theme_option('logo'))
                        <div class="checkout-logo">
                            <a href="{{ url('/') }}" title="{{ theme_option('site_title') }}">
                                <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" class="img-fluid" width="150" alt="{{ theme_option('site_title') }}" />
                            </a>
                        </div>
                        <hr/>
                    @endif
                    <div class="alert alert-warning" style="margin: 50px auto;">
                        <span>{!! __('No products in cart. :link!', ['link' => Html::link(url('/'), __('Back to shopping'))]) !!}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="{{ asset('vendor/core/plugins/payment/libraries/card/card.js') }}"></script>
    @if (setting('payment_stripe_status') == 1)
        <script src="{{ asset('https://js.stripe.com/v2/') }}"></script>
    @endif
    <script src="{{ asset('vendor/core/plugins/payment/js/payment.js') }}?v=1.0.2"></script>

