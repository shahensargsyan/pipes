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
        <input type="hidden" name="create_account" id="create_account" value="1">
        <input type="hidden" name="address[country]" id="create_account" value="US">

        <input class="magic-radio" type="hidden" name="shipping_method"  value="default" data-option="1">
        @php
            $products = [];
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
                <a href="#payment" id="payment-tub" aria-controls="payment" role="tab" data-toggle="tab"><span>2</span>
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
                                            <input type="text" name="address[first_name]" id="address[first_name]" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.first_name', Arr::get($sessionCheckoutData, 'first_name')) }}">
                                            {!! Form::error('address.first_name', $errors) !!}
                                        </div>
                                        <div class="check_input @if ($errors->has('address.last_name')) has-error @endif">
                                            <label>{{ __('Last Name') }}</label>
                                            <input type="text" name="address[last_name]" id="address[last_name]" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.last_name', Arr::get($sessionCheckoutData, 'last_name')) }}">
                                            {!! Form::error('address.last_name', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="checkout_input_row">
                                        <div class="check_input @if ($errors->has('address.company_name')) has-error @endif">
                                            <label>{{ __('Company Name') }}</label>
                                            <input type="text" name="address[company_name]" id="address[company_name]" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.company_name', Arr::get($sessionCheckoutData, 'company_name')) }}">
                                            {!! Form::error('address.company_name', $errors) !!}
                                        </div>
                                        <div class="check_input @if ($errors->has('address.email')) has-error @endif">
                                            <label>{{ __('Email Address*') }}</label>
                                            <input type="text" name="address[email]" id="address[email]" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.email', Arr::get($sessionCheckoutData, 'email')) }}">
                                            {!! Form::error('address.email', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="checkout_input_row">
                                        <div class="check_input @if ($errors->has('address.address')) has-error @endif">
                                            <label>{{ __('Street Address*') }}</label>
                                            <input type="text" name="address[address]" id="address[address]" class="form-control address-control-item checkout-input"
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
                                            <input type="text" name="address[city]" id="address[city]" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.city', Arr::get($sessionCheckoutData, 'city')) }}">
                                            {!! Form::error('address.city', $errors) !!}
                                        </div>
                                        <div class="check_input">
                                            <label>{{ __('Select country...') }}</label>
                                            <select name="address[state]" class="form-control address-control-item @if ($errors->has('address.state')) has-error @endif" id="address_state">
                                                    <option value="">Select a State</option>
                                                    <option value="" disabled>------------------------</option>
                                                    <option value="AL" {{ old('state') == 'AL' ? 'selected' : '' }}>Alabama</option>
                                                    <option value="AK" {{ old('state') == 'AK' ? 'selected' : '' }}>Alaska</option>
                                                    <option value="AZ" {{ old('state') == 'AZ' ? 'selected' : '' }}>Arizona</option>
                                                    <option value="AR" {{ old('state') == 'AR' ? 'selected' : '' }}>Arkansas</option>
                                                    <option value="CA" {{ old('state') == 'CA' ? 'selected' : '' }}>California</option>
                                                    <option value="CO" {{ old('state') == 'CO' ? 'selected' : '' }}>Colorado</option>
                                                    <option value="CT" {{ old('state') == 'CT' ? 'selected' : '' }}>Connecticut</option>
                                                    <option value="DE" {{ old('state') == 'DE' ? 'selected' : '' }}>Delaware</option>
                                                    <option value="DC" {{ old('state') == 'DC' ? 'selected' : '' }}>District Of Columbia</option>
                                                    <option value="FL" {{ old('state') == 'FL' ? 'selected' : '' }}>Florida</option>
                                                    <option value="GA" {{ old('state') == 'GA' ? 'selected' : '' }}>Georgia</option>
                                                    <option value="HI" {{ old('state') == 'HI' ? 'selected' : '' }}>Hawaii</option>
                                                    <option value="ID" {{ old('state') == 'ID' ? 'selected' : '' }}>Idaho</option>
                                                    <option value="IL" {{ old('state') == 'IL' ? 'selected' : '' }}>Illinois</option>
                                                    <option value="IN" {{ old('state') == 'IN' ? 'selected' : '' }}>Indiana</option>
                                                    <option value="IA" {{ old('state') == 'IA' ? 'selected' : '' }}>Iowa</option>
                                                    <option value="KS" {{ old('state') == 'KS' ? 'selected' : '' }}>Kansas</option>
                                                    <option value="KY" {{ old('state') == 'KY' ? 'selected' : '' }}>Kentucky</option>
                                                    <option value="LA" {{ old('state') == 'LA' ? 'selected' : '' }}>Louisiana</option>
                                                    <option value="ME" {{ old('state') == 'ME' ? 'selected' : '' }}>Maine</option>
                                                    <option value="MD" {{ old('state') == 'MD' ? 'selected' : '' }}>Maryland</option>
                                                    <option value="MA" {{ old('state') == 'MA' ? 'selected' : '' }}>Massachusetts</option>
                                                    <option value="MI" {{ old('state') == 'MI' ? 'selected' : '' }}>Michigan</option>
                                                    <option value="MN" {{ old('state') == 'MN' ? 'selected' : '' }}>Minnesota</option>
                                                    <option value="MS" {{ old('state') == 'MS' ? 'selected' : '' }}>Mississippi</option>
                                                    <option value="MO" {{ old('state') == 'MO' ? 'selected' : '' }}>Missouri</option>
                                                    <option value="MT" {{ old('state') == 'MT' ? 'selected' : '' }}>Montana</option>
                                                    <option value="NE" {{ old('state') == 'NE' ? 'selected' : '' }}>Nebraska</option>
                                                    <option value="NV" {{ old('state') == 'NV' ? 'selected' : '' }}>Nevada</option>
                                                    <option value="NH" {{ old('state') == 'NH' ? 'selected' : '' }}>New Hampshire</option>
                                                    <option value="NJ" {{ old('state') == 'NJ' ? 'selected' : '' }}>New Jersey</option>
                                                    <option value="NM" {{ old('state') == 'NM' ? 'selected' : '' }}>New Mexico</option>
                                                    <option value="NY" {{ old('state') == 'NY' ? 'selected' : '' }}>New York</option>
                                                    <option value="NC" {{ old('state') == 'NC' ? 'selected' : '' }}>North Carolina</option>
                                                    <option value="ND" {{ old('state') == 'ND' ? 'selected' : '' }}>North Dakota</option>
                                                    <option value="OH" {{ old('state') == 'OH' ? 'selected' : '' }}>Ohio</option>
                                                    <option value="OK" {{ old('state') == 'OK' ? 'selected' : '' }}>Oklahoma</option>
                                                    <option value="OR" {{ old('state') == 'OR' ? 'selected' : '' }}>Oregon</option>
                                                    <option value="PA" {{ old('state') == 'PA' ? 'selected' : '' }}>Pennsylvania</option>
                                                    <option value="RI" {{ old('state') == 'RI' ? 'selected' : '' }}>Rhode Island</option>
                                                    <option value="SC" {{ old('state') == 'SC' ? 'selected' : '' }}>South Carolina</option>
                                                    <option value="SD" {{ old('state') == 'SD' ? 'selected' : '' }}>South Dakota</option>
                                                    <option value="TN" {{ old('state') == 'TN' ? 'selected' : '' }}>Tennessee</option>
                                                    <option value="TX" {{ old('state') == 'TX' ? 'selected' : '' }}>Texas</option>
                                                    <option value="UT" {{ old('state') == 'UT' ? 'selected' : '' }}>Utah</option>
                                                    <option value="VT" {{ old('state') == 'VT' ? 'selected' : '' }}>Vermont</option>
                                                    <option value="VA" {{ old('state') == 'VA' ? 'selected' : '' }}>Virginia</option>
                                                    <option value="WA" {{ old('state') == 'WA' ? 'selected' : '' }}>Washington</option>
                                                    <option value="WV" {{ old('state') == 'WV' ? 'selected' : '' }}>West Virginia</option>
                                                    <option value="WI" {{ old('state') == 'WI' ? 'selected' : '' }}>Wisconsin</option>
                                                    <option value="WY" {{ old('state') == 'WY' ? 'selected' : '' }}>Wyoming</option>
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
                                            accept our <a href="/terms-of-use#terms_conditions" target="_blank">Terms & Conditions</a>,
                                            <a href="/terms-of-use#refund_policy" target="_blank">Return
                                                Policy</a> and <a
                                                href="/terms-of-use#privacy_policy" target="_blank">Privacy Policy</a>.</p>
                                    </div>
                                    <label class="check_btn_div "> Use this address as my billing address
                                        <input type="checkbox" checked="checked use_as_billing_address">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if (isset($products) && $products)
                            <div class="col-md-4">

                                <div class="payment_btn_row">
                                    <button type="button" class="btn" onclick="$( '#payment-tub' ).trigger( 'click' )">COUNTINUE</button>
                                </div>
                            </div>
                        @endif
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
                                                <input type="radio" id="card" name="payment_method" value="stripe">
                                                <label for="card">Credit Card
                                                    <div class="cards_img">
                                                        <img class="master" src="{!! Theme::asset()->url('/pipes/images/cards.png') !!}">
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
                                        @if (setting('payment_paypal_status') == 1)
                                            <div class="payment_list_row payment_check">
                                                <div class="payment_list payment_input">
                                                    <input type="radio" id="paypal" name="payment_method" value="paypal"
                                                           @if (setting('default_payment_method') == \Botble\Payment\Enums\PaymentMethodEnum::PAYPAL) checked @endif>
                                                    <label for="paypal">PayPal Express
                                                        <div class="cards_img2">
                                                            <img class="paypal" src="{!! Theme::asset()->url('/pipes/images/paypal-express@2x.png') !!}">
                                                        </div>
                                                    </label>
                                                    <div class="check"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                            </div>
                        </div>
                        @if (isset($products) && $products)
                            <div class="col-md-4">
                                @include(Theme::getThemeNamespace() . '::views/ecommerce/orders/partisals/chechout-order-details', $products)
                                <div class="payment_btn_row">
                                    <button class="btn payment-checkout-btn payment-checkout-btn-step"  data-processing-text="{{ __('Processing. Please wait...') }}" data-error-header="{{ __('Error') }}">
                                        {{ __('PLACE ORDER') }}
                                    </button>
                                </div>
                            </div>
                        @endif
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
