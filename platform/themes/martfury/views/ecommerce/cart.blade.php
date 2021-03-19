@php
    $crossSellProducts = [];
    Theme::layout('pipes');
@endphp

<div class="cart_page">
    <div class="container">
        <h2 class="cart_title">{{ __('YOUR CAR') }}T</h2>
        <div class="row">
            @if (Cart::instance('cart')->count() > 0)
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

{{--                                                                    <div class="ps-product__content">--}}
{{--                                                                        <a href="{{ $product->original_product->url }}">{{ $product->name }}</a>--}}
{{--                                                                        <p class="mb-0"><small>{{ $cartItem->options['attributes'] ?? '' }}</small></p>--}}
{{--                                                                        @if (!empty($cartItem->options['extras']) && is_array($cartItem->options['extras']))--}}
{{--                                                                            @foreach($cartItem->options['extras'] as $option)--}}
{{--                                                                                @if (!empty($option['key']) && !empty($option['value']))--}}
{{--                                                                                    <p class="mb-0"><small>{{ $option['key'] }}: <strong> {{ $option['value'] }}</strong></small></p>--}}
{{--                                                                                @endif--}}
{{--                                                                            @endforeach--}}
{{--                                                                        @endif--}}
{{--                                                                    </div>--}}
{{--                                                            <td class="price">{{ format_price($cartItem->price) }}</td>--}}


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
            <div class="col-md-4">
                <div class="cart_totals-list">
                    <h3 class="order_title">Order Details</h3>
                    <div class="table_div">
                        <table class="table-module">
                            <tbody>
                            <tr class="cart-subtotal">
                                <th>Subtotal</th>
                                <td>
                                    <span class="Price-amount amount">
{{--                                        <span class="Price-currencySymbol">$</span>--}}
                                        {{ format_price(Cart::instance('cart')->rawSubTotal()) }}</span>
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
                                <td>
                                    <strong>
                                        <span class="Price-amount amount">
        {{--                                <span class="Price-currencySymbol">$</span>--}}
                                            {{ format_price(Cart::instance('cart')->rawSubTotal()) }}
                                        </span>
                                    </strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card_checkout_btn">
                    <a href="{{ route('public.checkout.information', OrderHelper::getOrderSessionToken()) }}">{{ __('Proceed to checkout') }}</a>
                </div>
            </div>
            @else
                <p class="text-center">{{ __('Your cart is empty!') }}</p>
            @endif
        </div>
    </div>
</div>
