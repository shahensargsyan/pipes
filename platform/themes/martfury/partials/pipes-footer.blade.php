<footer class="footer_banner">
    <div class="footer_top_div">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="f_right_div">
                        <div class="logo"><a href=""><img src="{!! Theme::asset()->url('/pipes/images/wash-pipe-pro-logo-ff.svg') !!}"></a></div>
                        <div class="logo_mob"><a href=""><img src="{!! Theme::asset()->url('/pipes/images/logo-mob2.svg') !!}"></a></div>
                        <div class="footer_soc_links">
                            <a href="" target="_blank"> <i class="fab fa-facebook-f"></i></a>
                            <a href="" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="" target="_blank"><i class="fab fa-pinterest-p"></i></a>
                            <a href="" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="" target="_blank"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Navigation</h5>
                            <ul class="f_menu">
                                <li><a href="/#shop_product">Shop product</a></li>
                                <li><a href="/#benefits">Benefits</a></li>
                                <li><a href="/#faq">FAQ</a></li>
                                <li><a href="/#review">Review</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h5>Information</h5>
                            <ul class="f_menu">
                                <li><a href="/terms-of-use#terms_conditions">Terms and Conditions</a></li>
                                <li><a href="/terms-of-use#privacy_policy">Privacy Policy</a></li>
                                <li><a href="/terms-of-use#refund_policy">Refund Policy</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="f-contact_info">
                                <h5>Contact information</h5>
                                <ul>
                                    <li><a href="mailto:info@washpipepro.com"><img src="{!! Theme::asset()->url('/pipes/images/phone.svg') !!}">
                                            info@washpipepro.com</a></li>
                                    <li><a href="tel:+(323) 673-2495"><img src="{!! Theme::asset()->url('/pipes/images/mail.svg') !!}">
                                            (323) 673-2495</a>
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
            <div class="copyright_text"><p>© Copyright 2020 Wash Pipe Pro. All Rights Reserved</p></div>
            <div class="payments_img"><img src="{!! Theme::asset()->url('/pipes/images/payment-menthods@2x.png') !!}"></div>
        </div>
    </div>
</footer>
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

<script src="{!! Theme::asset()->url('/pipes/lib/js/jquery-3.3.1.min.js') !!}"></script>
<script src="{!! Theme::asset()->url('/pipes/lib/bootstrap/js/bootstrap.min.js') !!}"></script>
<script src="{!! Theme::asset()->url('/pipes/lib/js/slick.js') !!}"></script>
<!-- Main JS -->
<script src="{!! Theme::asset()->url('/pipes/js/main-js.js') !!}"></script>
<script>
    jQuery(function(){
        console.log('sd')
        var hash = window.location.hash;
        hash && jQuery('ul.nav a[href="' + hash + '"]').tab('show');
    });
</script>

</body>
</html>
