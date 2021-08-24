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

<link rel="stylesheet" href="{{ asset('vendor/core/plugins/payment/libraries/card/card.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/core/plugins/payment/css/payment.css') }}?v=1.0.2">



<section class="design-process-section cart_page" id="process-tab">
    <div class="container">
        @if (Cart::instance('cart')->count() > 0)
            <div class="cart_page">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="cart_product">

                                <form class="form--shopping-cart" method="post" action="{{ route('public.cart.update') }}">
                                    @csrf
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
                                    @if (isset($products) && $products)
                                        @foreach(Cart::instance('cart')->content() as $key => $cartItem)
                                            @php
                                                $product = $products->where('id', $cartItem->id)->first();
                                                if (!empty($product)) {
                                                    $crossSellProducts = array_unique(array_merge($crossSellProducts, get_cross_sale_products($product->original_product)));
                                                }
                                            @endphp

                                            @if (!empty($product))
                                                <div class="cart_product_item">
                                                    <div class="prod_img cart_img">
                                                        <a href="{{ $product->original_product->url }}">
                                                            <img src="{{ $cartItem->options['image'] }}" alt="{{ $product->name }}" />
                                                        </a>
                                                    </div>
                                                    <div class="prod_info">



                                                        <h3 class="prod_name">{{ $product->name }}</h3>
                                                        <span class="prod_price">{{ format_price($cartItem->price) }}</span>
                                                        <div class="quant_btn_row">
                                                            <div class="quantity product__qty">
                                                                <div class="custom_qty "><span
                                                                        class="product_count_numb product_count_numb_min minus down" key="{{ $key }}" id="mins">-</span> <label
                                                                        class="screen-reader-text" for="quantity"></label>
                                                                    <input type="number" id="quantity_{{ $key }}" class="input-text qty text" min="1" max="" readonly
                                                                           name="items[{{ $key }}][values][qty]" value="{{ $cartItem->qty }}" title="Qty" size="4" placeholder=""/>
                                                                    <span class="product_count_numb product_count_numb_plus plus up" key="{{ $key }}" id="plus">+</span></div>
                                                                {{--                                                                <input type="text" class="form-control qty-input" value="{{ $cartItem->qty }}" title="{{ __('Qty') }}"  >--}}
                                                            </div>
                                                            @if (Cart::instance('cart')->count() > 0)
                                                                <button type="submit" name="add-to-cart" value="" class="single_add_to_cart_button button_update_curt button">{{ __('Update cart') }}</button>
                                                            @endif
                                                        </div>


                                                        <input type="hidden" name="items[{{ $key }}][rowId]" value="{{ $cartItem->rowId }}">

                                                        <td><a href="{{ route('public.cart.remove', $cartItem->rowId) }}" class="remove-cart-button"><i class="icon-cross"></i></a></td>





                                                    </div>
                                                    <div class="cart_delete_btn">
                                                        <a href="{{ route('public.cart.remove', $cartItem->rowId) }}" class="remove-cart-button"><img src="{!! Theme::asset()->url('/pipes/images/delete.svg') !!}"></a>
                                                    </div>
                                                </div>


                                            @endif
                                        @endforeach
                                    @endif
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4 cart_page_right_steps">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs process-model more-icon-preocess" role="tablist">
                                <li role="presentation" class="active tab-customer-info">
                                    <a href="#customer-info"  aria-controls="customer-info" role="tab" data-toggle="tab"><span>1</span>
                                        <p>CUSTOMER INFO</p>
                                    </a>
                                </li>
                                <li role="presentation" class ="checkout-next-step">
                                    <a href="#payment" id="payment-tub" aria-controls="payment" role="tab" data-toggle="tab" ><span>2</span>
                                        <p>PAYMENT METHOD</p>
                                    </a>
                                </li>
                            </ul>
                            <!-- end design process steps-->
                        </div>
                    </div>
                </div>

        @else
            <p class="text-center">{{ __('Your cart is empty!') }}</p>
        @endif
    {!! Form::open(['route' => ['public.checkout.process', $token], 'class' => 'checkout-form payment-checkout-form', 'id' => 'checkout-form']) !!}
        <input type="hidden" name="checkout-token" id="checkout-token" value="{{ $token }}">
        <input type="hidden" name="create_account" id="create_account" value="0">


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
                                            <input type="text" name="address[first_name]" id="address.first_name" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.first_name', Arr::get($sessionCheckoutData, 'first_name')) }}">
                                            {!! Form::error('address.first_name', $errors) !!}
                                        </div>
                                        <div class="check_input @if ($errors->has('address.last_name')) has-error @endif">
                                            <label>{{ __('Last Name') }}</label>
                                            <input type="text" name="address[last_name]" id="address.last_name" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.last_name', Arr::get($sessionCheckoutData, 'last_name')) }}">
                                            {!! Form::error('address.last_name', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="checkout_input_row">
                                        <div class="check_input @if ($errors->has('address.company_name')) has-error @endif">
                                            <label>{{ __('Company Name') }}</label>
                                            <input type="text" name="address[company_name]" id="address.company_name" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.company_name', Arr::get($sessionCheckoutData, 'company_name')) }}">
                                            {!! Form::error('address.company_name', $errors) !!}
                                        </div>
                                        <div class="check_input @if ($errors->has('address.email')) has-error @endif">
                                            <label>{{ __('Email Address*') }}</label>
                                            <input type="text" name="address[email]" id="address.email" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.email', Arr::get($sessionCheckoutData, 'email')) }}">
                                            {!! Form::error('address.email', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="checkout_input_row">
                                        <div class="check_input @if ($errors->has('address.address')) has-error @endif">
                                            <label>{{ __('Street Address*') }}</label>
                                            <input type="text" name="address[address]" id="address.address" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.address', Arr::get($sessionCheckoutData, 'address')) }}">
                                            {!! Form::error('address.address', $errors) !!}
                                        </div>

                                        <div class="check_input @if ($errors->has('address.apartment')) has-error @endif">
                                            <label>{{ __('Apartment') }}</label>
                                            <input type="text" name="address[apartment]" id="address.apartment" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.apartment', Arr::get($sessionCheckoutData, 'address')) }}">
                                            {!! Form::error('address.apartment', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="checkout_input_row">
                                        <div class="check_input @if ($errors->has('address.city')) has-error @endif">
                                            <label>{{ __('Town / City*') }}</label>
                                            <input type="text" name="address[city]" id="address.city" class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.city', Arr::get($sessionCheckoutData, 'city')) }}">
                                            {!! Form::error('address.city', $errors) !!}
                                        </div>
                                        <div class="check_input">
                                            <label>{{ __('Select country...') }}</label>
                                            <input type="hidden" name="address[country]" id="create_account" value="US">
                                            <select name="address[country]" class="form-control address-control-item @if ($errors->has('address.country')) has-error @endif" id="address.country">
                                                @foreach($countries as $code=>$country)
                                                    <option value="{{ $code }}" {{ old('state') == $code ? 'selected' : '' }}>{{ $country }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        {!! Form::error('address.country', $errors) !!}
                                    </div>
                                    <div class="checkout_input_row">
                                        <div class="check_input @if ($errors->has('address.zip_code')) has-error @endif">
                                            <label>{{ __('Post Code*') }}</label>
                                            <input type="text" name="address[zip_code]" id="address.zip_code"  class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.zip_code', Arr::get($sessionCheckoutData, 'zip_code')) }}">
                                            {!! Form::error('address.zip_code', $errors) !!}
                                        </div>
                                        <div class="check_input">
                                            <label>{{ __('Phone') }}</label>
                                            <input type="text" name="address[phone]" id="address.phone"  class="form-control address-control-item checkout-input"
                                                   value="{{ old('address.phone', Arr::get($sessionCheckoutData, 'phone')) }}">
                                            {!! Form::error('address.phone', $errors) !!}
                                        </div>
                                    </div>
                                    <div class="check_input">
                                        <label for="description" class="control-label">{{ __('Order Notes') }}</label>
                                        <textarea name="description" id="address.description" rows="3" class="form-control" placeholder="{{ __('Note') }}...">{{ old('description') }}</textarea>
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
                                    <button type="button" class="btn checkout-next-step">COUNTINUE</button>
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
