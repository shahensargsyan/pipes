@php
    $crossSellProducts = [];
    Theme::layout('pipes');
@endphp


<div class="thk_page">
    <div class="thk_page_content">
        <h2>Thank you!</h2>
        <p>Your order is approved!</p>
        <img src="{!! Theme::asset()->url('/pipes/images/order-approved.svg') !!}">
    </div>
</div>
