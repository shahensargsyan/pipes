

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
                                <input class="apply-coupon-code" value="Apply" data-url="{{ route('public.coupon.apply') }}" type="button"> <i>{{ __('Apply') }}</i>

{{--                                <button class="btn btn-md btn-gray btn-info apply-coupon-code float-right" data-url="{{ route('public.coupon.apply') }}" type="button"> {{ __('Apply') }}</button>--}}
                            </div>
                        </div>
                    </div>
                    <div class="coupon-error-msg">
                        <span class="text-danger"></span>
                    </div>
                </div>



