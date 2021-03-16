@php
    $crossSellProducts = [];
    Theme::layout('pipes');
    //Theme::set('stickyHeader', 'false');
    //dd(Route::current()->uri)
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


<section class="design-process-section cart_page" id="process-tab">
    <div class="container">
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
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="customer-info">
                <div class="design-process-content">
                    <h2 class="cart_title">CUSTOMER INFO</h2>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="checkout_form">
                                <div>
                                    <div class="checkout_input_row">
                                        <div class="check_input @if ($errors->has('address.first_name')) has-error @endif">
                                            <label>{{ __('First Name') }}</label>
                                            <input type="text" name="address[first_name]" id="address[name]" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.first_name', Arr::get($sessionCheckoutData, 'first_name')) }}">
                                            {!! Form::error('address.first_name', $errors) !!}
                                        </div>
                                        <div class="check_input @if ($errors->has('address.last_name')) has-error @endif">
                                            <label>{{ __('Last Name') }}</label>
                                            <input type="text" name="address[last_name]" id="address[name]" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.last_name', Arr::get($sessionCheckoutData, 'last_name')) }}">
                                            {!! Form::error('address.last_name', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="checkout_input_row">
                                        <div class="check_input @if ($errors->has('address.company_name')) has-error @endif">
                                            <label>{{ __('Company Name') }}</label>
                                            <input type="text" name="address[company_name]" id="address[name]" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.company_name', Arr::get($sessionCheckoutData, 'company_name')) }}">
                                            {!! Form::error('address.company_name', $errors) !!}
                                        </div>
                                        <div class="check_input @if ($errors->has('address.email')) has-error @endif">
                                            <label>{{ __('Email Address*') }}</label>
                                            <input type="text" name="address[email]" id="address[name]" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.email', Arr::get($sessionCheckoutData, 'email')) }}">
                                            {!! Form::error('address.email', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="checkout_input_row">
                                        <div class="check_input @if ($errors->has('address.address')) has-error @endif">
                                            <label>{{ __('Street Address*') }}</label>
                                            <input type="text" name="address[address]" id="address[name]" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.address', Arr::get($sessionCheckoutData, 'address')) }}">
                                            {!! Form::error('address.address', $errors) !!}
                                        </div>

                                        <div class="check_input @if ($errors->has('address.apartment')) has-error @endif">
                                            <label>{{ __('Apartment') }}</label>
                                            <input type="text" name="address[apartment]" id="address[apartment]" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.apartment', Arr::get($sessionCheckoutData, 'address')) }}">
                                            {!! Form::error('address.apartment', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="checkout_input_row">
                                        <div class="check_input @if ($errors->has('address.city')) has-error @endif">
                                            <label>{{ __('Town / City*') }}</label>
                                            <input type="text" name="address[city]" id="address[apartment]" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.city', Arr::get($sessionCheckoutData, 'city')) }}">
                                            {!! Form::error('address.city', $errors) !!}
                                        </div>
                                        <div class="check_input">
                                            <label>{{ __('Select country...') }}</label>
                                            <select name="address[country]" class="form-control address-control-item" id="address_country">
                                                @foreach(['' => __('Select country...')] + EcommerceHelper::getAvailableCountries() as $countryCode => $countryName)
                                                    <option value="{{ $countryCode }}" @if (old('address.country', Arr::get($sessionCheckoutData, 'country')) == $countryCode) selected @endif>{{ $countryName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {!! Form::error('address.country', $errors) !!}
                                    </div>
                                    <div class="checkout_input_row">
                                        <div class="check_input @if ($errors->has('address.zip_code')) has-error @endif">
                                            <label>{{ __('Post Code*') }}</label>
                                            <input type="text" name="address[zip_code]" id="address[zip_code]"  class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.zip_code', Arr::get($sessionCheckoutData, 'zip_code')) }}">
                                            {!! Form::error('address.zip_code', $errors) !!}
                                        </div>
                                        <div class="check_input">
                                            <label>{{ __('Phone') }}</label>
                                            <input type="text" name="address[phone]" id="address[phone]"  class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.phone', Arr::get($sessionCheckoutData, 'phone')) }}">
                                            {!! Form::error('address.phone', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="check_input">
                                        <label for="description" class="control-label">{{ __('Order Notes') }}</label>
                                        <textarea name="description" id="description" rows="3" class="form-control" placeholder="{{ __('Note') }}...">{{ old('description') }}</textarea>
                                        {!! Form::error('description', $errors) !!}
                                    </div>
                                    <div class="notif_info">
                                        <p>By clicking the Place Order button, you confirm that you have read
                                            and understood, and
                                            accept our <a href="">Terms & Conditions</a>, <a href="">Return
                                                Policy</a> and <a
                                                href="">Privacy Policy</a>.</p>
                                    </div>
                                    <label class="check_btn_div "> Use this address as my billing address
                                        <input type="checkbox" checked="checked use_as_billing_address">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
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
                                <div class="promocode_form_div">
                                    <div class="promocode-input">
                                        <input type="text" placeholder="Enter Code">
                                        <input type="button" value="Apply">
                                    </div>
                                </div>
                            </div>
                            <div class="payment_btn_row">
                                <button class="btn">COUNTINUE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="amount" value="{{ ($promotionDiscountAmount + $couponDiscountAmount - $shippingAmount) > Cart::instance('cart')->rawTotal() ? 0 : Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount + $shippingAmount }}">
            <input type="hidden" name="currency" value="{{ strtoupper(get_application_currency()->title) }}">
            <input type="hidden" name="currency_id" value="{{ get_application_currency_id() }}">
            <input type="hidden" name="callback_url" value="{{ route('public.payment.paypal.status') }}">
            <input type="hidden" name="return_url" value="{{ route('public.checkout.success', $token) }}">




            <div role="tabpanel" class="tab-pane" id="payment">
                <div class="design-process-content">
                    <h2 class="cart_title">CUSTOMER INFO</h2>
                    <div class="row">
                        <div class="col-md-8">
                            <p class="cart_information">All transactions are secure and encrypted. Credit card
                                information is never stored on our servers.</p>
                            <div class="checkout_form">

                                    <div class="payment_form"  @if (!setting('default_payment_method') || setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::STRIPE) show @endif">

                                    @if (setting('payment_stripe_status') == 1)
                                        <div class="payment_list_row1 payment_check active">
                                            <div class="payment_list">
                                                <input type="radio" id="card" name="payment_method" value="stripe" checked>
                                                <label for="card">Credit Card
                                                    <div class="cards_img">
                                                        <img class="master" src="/themes/pipes/images/cards.png">
                                                    </div>
                                                </label>
                                                <div class="check"></div>
                                            </div>
                                            <div class="payment_input_row">
                                                <div class="payment_input card_number">
                                                    <label>Card Number*</label>
                                                    <input type="text" placeholder="1234 1234 1234 1234" type="text" id="stripe-number" data-stripe="number">
                                                </div>
                                            </div>
                                            <div class="payment_input_row @if ($errors->has('name')) has-error @endif">
                                                <div class="payment_input card_number">
                                                    <label>Full Name*</label>
                                                    <input type="text" placeholder="Full Name" type="text" id="stripe-name" type="text" data-stripe="name">
                                                </div>
                                            </div>
                                            <div class="payment_input_row">
                                                <div class="payment_input">
                                                    <label>Expiry Date*</label>

                                                    <div class="payment_date_inputs @if ($errors->has('cvc')) has-error @endif">
                                                        <input type="text" id="stripe-exp" data-stripe="exp" placeholder="MM/YY" >
                                                    </div>
                                                </div>
                                                <div class="payment_input cvv_code">
                                                    <label>Card Code (CVC)*</label>
                                                    <input type="password" placeholder="CVC" id="stripe-cvc" data-stripe="cvc">
                                                </div>

                                            </div>
                                            <div id="payment-stripe-key" data-value="{{ setting('payment_stripe_client_id') }}"></div>
                                        </div>
                                    @endif
                                        <div class="payment_list_row payment_check">
                                            <div class="payment_list payment_input">
                                                <input type="radio" id="payment_method" name="payment_method"
                                                       value="bank_transfer" >
                                                <label for="payment_method">
                                                    Direct Bank Transfer
                                                </label>
                                                <div class="check"></div>
                                            </div>
                                        </div>
                                        @if (setting('payment_paypal_status') == 1)
                                            <div class="payment_list_row payment_check">
                                                <div class="payment_list payment_input">
                                                    <input type="radio" id="payment_method" name="Card" value="paypal"
                                                           @if (setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::PAYPAL) checked @endif>
                                                    <label for="paypal">PayPal Express
                                                        <div class="cards_img2">
                                                            <img class="paypal" src="/themes/pipes/images/paypal-express@2x.png">
                                                        </div>
                                                    </label>
                                                    <div class="check"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            @if (isset($products) && $products)
                                @foreach(Cart::instance('cart')->content() as $key => $cartItem)
                                    @php
                                        $product = $products->where('id', $cartItem->id)->first();
                                    @endphp
                                    @if(!empty($product))
                                        <div id="main-checkout-product-info">
                                        <div class="cart_totals-list">
                                            <h3 class="order_title">Order Details</h3>
                                            <div class="table_div">
                                                <table class="table-module">
                                                    <tbody>

                                                    @if (session('applied_coupon_code'))
                                                        <tr class="shipping-totals">
                                                            <th>
                                                                {{ __('Coupon code') }}:
                                                            </th>
                                                            <td>
                                                                {{ session('applied_coupon_code') }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @if ($couponDiscountAmount > 0)
                                                        <tr class="shipping-totals">
                                                            <th>
                                                                <p>{{ __('Coupon code discount amount') }}:</p>
                                                            </th>
                                                           <th>
                                                                <p class="price-text total-discount-amount-text"> {{ format_price($couponDiscountAmount) }} </p>
                                                            </th>
                                                        </tr>
                                                    @endif
                                                    @if ($promotionDiscountAmount > 0)
                                                        <tr class="shipping-totals">
                                                            <th>
                                                                <p>{{ __('Promotion discount amount') }}:</p>
                                                            </th>
                                                            <th>
                                                                <p class="price-text"> {{ format_price($promotionDiscountAmount) }} </p>
                                                            </th>
                                                        </tr>
                                                    @endif
                                                    <tr class="cart-subtotal">
                                                        <th>Subtotal</th>
                                                        <td>
                                                        <span class="Price-amount amount">{{ format_price(Cart::instance('cart')->rawSubTotal()) }}</span>
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
                                                            {{ ($promotionDiscountAmount + $couponDiscountAmount - $shippingAmount) > Cart::instance('cart')->rawTotal() ? format_price(0) : format_price(Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount + $shippingAmount) }}
                                                        </span>
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="promocode_form">
                                            <h3 class="promocode_title">Promocode</h3>
                                            <div class="promocode_form_div">
                                                <div class="promocode-input coupon-wrapper">
                                                    <input type="text" class="form-control coupon-code input-md checkout-input" name="coupon_code" placeholder="Enter Code">
                                                    <input class="apply-coupon-code" value="Apply" data-url="{{ route('public.coupon.apply') }}" type="button"> {{ __('Apply') }}
                                                    <div class="coupon-error-msg">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                    <button class="btn btn-md btn-gray btn-info apply-coupon-code float-right" data-url="{{ route('public.coupon.apply') }}" type="button"> {{ __('Apply') }}</button>--}}
                                                </div>
                                            </div>
                                        </div>
                                        </div>
{{--                                        <div class="promocode_form">--}}
{{--                                            <h3 class="promocode_title">Promocode</h3>--}}
{{--                                            <div class="promocode_form_div">--}}
{{--                                                <div class="promocode-input coupon-wrapper">--}}
{{--                                                    <input type="text" name="coupon_code" class="form-control coupon-code input-md checkout-input" value="{{ old('coupon_code') }}" placeholder="{{ __('Enter coupon code...') }}">--}}
{{--                                                    <div class="coupon-error-msg">--}}
{{--                                                        <span class="text-danger"></span>--}}
{{--                                                    </div>--}}
{{--                                                    <button class="btn btn-md btn-gray btn-info apply-coupon-code float-right" data-url="{{ route('public.coupon.apply') }}" type="button" style="margin-top: 0;padding: 10px 20px;><i class="><i class="fa fa-gift"></i> {{ __('Apply') }}</button>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="promocode_form">--}}
{{--                                            <h3 class="promocode_title">Promocode</h3>--}}
{{--                                            <div class="promocode_form_div">--}}
{{--                                                <div class="promocode-input coupon-wrapper">--}}
{{--                                                    <input type="text" name="coupon_code" class="form-control coupon-code input-md checkout-input" value="{{ old('coupon_code') }}" placeholder="{{ __('Enter coupon code...') }}">--}}
{{--                                                    <div class="coupon-error-msg">--}}
{{--                                                        <span class="text-danger"></span>--}}
{{--                                                    </div>--}}
{{--                                                    <button class="btn btn-md btn-gray btn-info apply-coupon-code float-right" data-url="{{ route('public.coupon.apply') }}" type="button"> {{ __('Apply') }}</button>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="payment_btn_row">
                                            <button class="btn">PLACE ORDER</button>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






</section>

<script src="{{ asset('vendor/core/plugins/payment/libraries/card/card.js') }}"></script>
@if (setting('payment_stripe_status') == 1)
    <script src="{{ asset('https://js.stripe.com/v2/') }}"></script>
@endif
<script src="{{ asset('vendor/core/plugins/payment/js/payment.js') }}?v=1.0.2"></script>
