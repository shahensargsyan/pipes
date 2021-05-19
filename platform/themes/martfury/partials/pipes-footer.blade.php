@if(!in_array(Route::current()->uri, ["cart","checkout/{token}", "checkout/{token}/success", ]))
<footer class="footer_banner">
    <div class="footer_top_div">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="f_right_div">
                        <div class="logo"><a href="{{ url('/') }}"><img src="{!! Theme::asset()->url('/pipes/images/wash-pipe-pro-logo-ff.svg') !!}"></a></div>
                        <div class="logo_mob"><a href="{{ url('/') }}"><img src="{!! Theme::asset()->url('/pipes/images/logo-mob2.svg') !!}"></a></div>
                        <div class="footer_soc_links">
                            @for($i = 1; $i <= 5; $i++)
                                @if(theme_option('social-name-' . $i) && theme_option('social-url-' . $i) && theme_option('social-icon-' . $i))

                                        <a href="{{ theme_option('social-url-' . $i) }}" target="_blank"
                                           title="{{ theme_option('social-name-' . $i) }}" style="color: {{ theme_option('social-color-' . $i) }}">
                                            <i class="fab {{ theme_option('social-icon-' . $i) }}"></i>
                                        </a>

                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Navigation</h5>
                            <ul class="f_menu">
                                <li><a href="/#shop_product">Shop product</a></li>
                                <li><a href="/#faq">FAQ</a></li>
                                <li><a href="/#review">Review</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h5>Information</h5>
                            <ul class="f_menu @if(Route::current()->uri == "{slug?}") terms @endif">
                                <li><a href="@if(Route::current()->uri !== "{slug?}") /terms-of-use @endif#terms_conditions" tab="#terms_conditions">Terms and Conditions</a></li>
                                <li><a href="@if(Route::current()->uri !== "{slug?}") /terms-of-use @endif#privacy_policy" tab="#privacy_policy">Privacy Policy</a></li>
                                <li><a href="@if(Route::current()->uri !== "{slug?}") /terms-of-use @endif#refund_policy" tab="#refund_policy">Refund Policy</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="f-contact_info">
                                <h5>Contact information</h5>
                                <ul>
                                    <li><a href="mailto:{{ theme_option('email') }}"><img src="{!! Theme::asset()->url('/pipes/images/mail.svg') !!}">
                                            {{ theme_option('email') }}</a></li>
                                    <li><a href="tel:{{ theme_option('hotline') }}"><img src="{!! Theme::asset()->url('/pipes/images/phone.svg') !!}">
                                            {{ theme_option('hotline') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="footer_bottom_div">
        <div class="container">
            <div class="copyright_text"><p>{{ theme_option('copyright') }}</p></div>
            <div class="payments_img"><img src="{!! Theme::asset()->url('/pipes/images/payment-menthods@2x.webp') !!}"></div>
        </div>
    </div>
</footer>
@endif
{{--{!! Theme::get('bottomFooter') !!}--}}
<script>
    window.trans = {
        "View All": "{{ __('View All') }}",
    }
    window.siteUrl = "{{ url('') }}";


</script>

{!! Theme::footer() !!}
@if (session()->has('success_msg') || session()->has('error_msg') || (isset($errors) && $errors->count() > 0) || isset($error_msg))
    <script type="text/javascript">
        $(document).ready(function () {
            @if (session()->has('success_msg'))
            window.showAlert('alert-success', '{{ session('success_msg') }}');
            @endif

            @if (session()->has('error_msg'))
            window.showAlert('alert-danger', '{{ session('error_msg') }}');
            @endif

            @if (isset($error_msg))
            window.showAlert('alert-danger', '{{ $error_msg }}');
            @endif

            @if (isset($errors))
            @foreach ($errors->all() as $error)
            window.showAlert('alert-danger', '{{ $error }}');
            @endforeach
            @endif
        });
    </script>
@endif

<script src="{!! Theme::asset()->url('pipes/lib/js/jquery-3.3.1.min.js') !!}"></script>
<script src="{!! Theme::asset()->url('pipes/lib/bootstrap/js/bootstrap.min.js') !!}"></script>
<script src="{!! Theme::asset()->url('pipes/lib/js/slick.js') !!}"></script>
<!-- Main JS -->
<script src="{!! Theme::asset()->url('pipes/js/main-js.js') !!}"></script>

{{--<script src="https://wchat.freshchat.com/js/widget.js"></script>--}}
<script>
    jQuery(function(){

        var hash = window.location.hash;
        hash && jQuery('ul.nav a[href="' + hash + '"]').tab('show');

        @if(Route::current()->uri == "{slug?}")

            $(document).on('click',".terms li a",function(e)  {
                e.stopPropagation()

                let id = $(this).attr('tab')+'_tab';
                $(id).trigger('click');
            })

        @endif

    });
    // $(document).ready(function(){
    //     window.fcWidget.init({
    //         token: "677676e1-0a48-4440-8476-e5ae23b28f04",
    //         host: "https://wchat.freshchat.com"
    //     });
    // });




    function initFreshChat() {
        window.fcWidget.init({
            token: "677676e1-0a48-4440-8476-e5ae23b28f04",
            host: "https://wchat.freshchat.com"
        });
    }
    setTimeout(function(){
    (function(d, id) {
        var fcJS;
        if (d.getElementById(id)) {
            initFreshChat();
            return;
        }
        fcJS = d.createElement('script');
        fcJS.id = id;
        fcJS.async = true;
        fcJS.src = 'https://wchat.freshchat.com/js/widget.js';
        fcJS.onload = initFreshChat;
        d.head.appendChild(fcJS);
    }(document, 'freshchat-js-sdk'));
    }, 5000);
</script>
<!-- End Facebook Pixel Code -->
</body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXX"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</html>


<script>

</script>
