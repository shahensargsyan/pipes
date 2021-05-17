(function ($) {
    'use strict';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    window.botbleCookieNewsletter = (() => {

        const COOKIE_VALUE = 1;
        const COOKIE_NAME = 'botble_cookie_newsletter';
        const COOKIE_DOMAIN = $('div[data-session-domain]').data('session-domain');
        const COOKIE_MODAL = $('#subscribe');
        const COOKIE_MODAL_TIME = COOKIE_MODAL.data('time');

        function newsletterWithCookies(expirationInDays) {
            setCookie(COOKIE_NAME, COOKIE_VALUE, expirationInDays);
        }

        function cookieExists(name) {
            return document.cookie.split('; ').indexOf(name + '=' + COOKIE_VALUE) !== -1;
        }

        function hideCookieDialog() {
            if (!cookieExists(COOKIE_NAME) && $('#dont_show_again').is(':checked')) {
                newsletterWithCookies(3);
            } else {
                newsletterWithCookies(1 / 24);
            }
        }

        function setCookie(name, value, expirationInDays) {
            const date = new Date();
            date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
            document.cookie = name + '=' + value
                + ';expires=' + date.toUTCString()
                + ';domain=' + COOKIE_DOMAIN
                + ';path=/';
        }

        if (!cookieExists(COOKIE_NAME)) {
            setTimeout(function () {
                if (COOKIE_MODAL.length > 0) {
                    COOKIE_MODAL.addClass('active');
                    $('body').css('overflow', 'hidden');
                }
            }, COOKIE_MODAL_TIME);
        }

        return {
            newsletterWithCookies: newsletterWithCookies,
            hideCookieDialog: hideCookieDialog
        };
    })();

    var showError = message => {
        window.showAlert('alert-danger', message);
    }

    var showSuccess = message => {
        window.showAlert('alert-success', message);
    }

    var handleError = data => {
        if (typeof (data.errors) !== 'undefined' && data.errors.length) {
            handleValidationError(data.errors);
        } else if (typeof (data.responseJSON) !== 'undefined') {
            if (typeof (data.responseJSON.errors) !== 'undefined') {
                if (data.status === 422) {
                    handleValidationError(data.responseJSON.errors);
                }
            } else if (typeof (data.responseJSON.message) !== 'undefined') {
                showError(data.responseJSON.message);
            } else {
                $.each(data.responseJSON, (index, el) => {
                    $.each(el, (key, item) => {
                        showError(item);
                    });
                });
            }
        } else {
            showError(data.statusText);
        }
    }

    var handleValidationError = errors => {
        let message = '';
        $.each(errors, (index, item) => {
            if (message !== '') {
                message += '<br />';
            }
            message += item;
        });
        showError(message);
    }

    window.showAlert = (messageType, message) => {
        if (messageType && message !== '') {
            let alertId = Math.floor(Math.random() * 1000);

            let html = `<div class="alert ${messageType} alert-dismissible" id="${alertId}">
                            <span class="close icon-cross2" data-dismiss="alert" aria-label="close"></span>
                            <i class="icon-` + (messageType === 'alert-success' ? 'checkmark-circle' : 'cross-circle') + ` message-icon"></i>
                            ${message}
                        </div>`;

            $('#alert-container').append(html).ready(() => {
                window.setTimeout(() => {
                    $(`#alert-container #${alertId}`).remove();
                }, 6000);
            });
        }
    }

    $(document).ready(function () {
        window.onBeforeChangeSwatches = function () {
            $('.add-to-cart-form button[type=submit]').prop('disabled', true).addClass('btn-disabled');
        }

        window.onChangeSwatchesSuccess = function (res) {
            $('.add-to-cart-form .error-message').hide();
            $('.add-to-cart-form .success-message').hide();
            if (res.error) {
                $('.add-to-cart-form button[type=submit]').prop('disabled', true).addClass('btn-disabled');
                $('.number-items-available').html('<span class="">(' + res.message + ')</span>').show();
                $('.hidden-product-id').val('');
            } else {
                $('.add-to-cart-form').find('.error-message').hide();
                $('.Price-amount').text(res.data.display_sale_price);
                if (res.data.sale_price !== res.data.price) {
                    $('.was_price-amount').text(res.data.display_price).show();
                } else {
                    $('.ps-product__price del').hide();
                }

                $('.ps-product__specification #product-sku').text(res.data.sku);

                $('.hidden-product-id').val(res.data.id);
                $('.add-to-cart-form button[type=submit]').prop('disabled', false).removeClass('btn-disabled');
                $('.number-items-available').html('<span class="">(' + res.message + ')</span>').show();

                // let slider = $(document).find('.ps-product--quickview .ps-product__images');
                var slider = $("#gallery-slider1 .gallery-slider__images>div");


                if (slider.length) {
                    slider.slick('unslick');

                    let imageHtml = '';
                    res.data.image_with_sizes.origin.forEach(function (item) {
                        imageHtml += '<div class="item"><img src="' + item + '" alt="image"/></div>'
                    });

                    slider.html(imageHtml);

                    slider.slick({
                        slidesToShow: slider.data('item'),
                        slidesToScroll: 1,
                        infinite: false,
                        arrows: slider.data('arrow'),
                        focusOnSelect: true,
                        prevArrow: "<a href='#'><i class='fa fa-angle-left'></i></a>",
                        nextArrow: "<a href='#'><i class='fa fa-angle-right'></i></a>",
                    });
                }

                var product = $('.ps-product--detail');


                    // let primary = product.find('.ps-product__gallery');
                    // let second = product.find('.ps-product__variants');
                    let second = jQuery("#gallery-slider1 .gallery-slider__thumbnails>div");
                    let vertical = product
                        .find('.ps-product__thumbnail')
                        .data('vertical');
                    var primary = jQuery("#gallery-slider1 .gallery-slider__images>div");

                    if (primary.length) {
                        primary.slick('unslick');

                        let imageHtml = '';
                        res.data.image_with_sizes.origin.forEach(function (item) {
                            imageHtml += '<div class="item"><img src="' + item + '" alt="image"/></div>'
                        });

                        primary.html(imageHtml);

                        primary.slick({
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            asNavFor: '.ps-product__variants',
                            fade: true,
                            dots: true,
                            infinite: false,
                            arrows: primary.data('arrow'),
                            prevArrow: "<a href='#'><i class='fa fa-angle-left'></i></a>",
                            nextArrow: "<a href='#'><i class='fa fa-angle-right'></i></a>",
                        });
                    }
                    if (second.length) {

                        second.slick('unslick');

                        let thumbHtml = '';
                        res.data.image_with_sizes.thumb.forEach(function (item) {
                            thumbHtml += '<div class="item"><img src="' + item + '" alt="image"/></div>'
                        });

                        second.html(thumbHtml);

                        second.slick({
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            dots: true,
                            infinite: false,
                            arrows: second.data('arrow'),
                            focusOnSelect: true,
                            prevArrow: "<a href='#'><i class='fa fa-angle-up'></i></a>",
                            nextArrow: "<a href='#'><i class='fa fa-angle-down'></i></a>",
                            asNavFor: "#gallery-slider1 .gallery-slider__images>div",
                            vertical: vertical,
                            responsive: [
                                {
                                    breakpoint: 1200,
                                    settings: {
                                        arrows: second.data('arrow'),
                                        slidesToShow: 4,
                                        vertical: false,
                                        prevArrow:
                                            "<a href='#'><i class='fa fa-angle-left'></i></a>",
                                        nextArrow:
                                            "<a href='#'><i class='fa fa-angle-right'></i></a>",
                                    },
                                },
                                {
                                    breakpoint: 992,
                                    settings: {
                                        arrows: second.data('arrow'),
                                        slidesToShow: 4,
                                        vertical: false,
                                        prevArrow:
                                            "<a href='#'><i class='fa fa-angle-left'></i></a>",
                                        nextArrow:
                                            "<a href='#'><i class='fa fa-angle-right'></i></a>",
                                    },
                                },
                                {
                                    breakpoint: 480,
                                    settings: {
                                        slidesToShow: 3,
                                        vertical: false,
                                        prevArrow:
                                            "<a href='#'><i class='fa fa-angle-left'></i></a>",
                                        nextArrow:
                                            "<a href='#'><i class='fa fa-angle-right'></i></a>",
                                    },
                                },
                            ],
                        });
                    }


                $(window).trigger('resize');

                if (product.length > 0) {
                    product.find('.ps-product__gallery').data('lightGallery').destroy(true);
                    product.find('.ps-product__gallery').lightGallery({
                        selector: '.item a',
                        thumbnail: true,
                        share: false,
                        fullScreen: false,
                        autoplay: false,
                        autoplayControls: false,
                        actualSize: false,
                    });
                }
            }
        };







        $(document).on('change', '.switch-currency', function () {
            $(this).closest('form').submit();
        });

        $(document).on('change', '.product-filter-item', function () {
            $(this).closest('form').submit();
        });





        $(document).on('click', '.add-to-cart-button', function (event) {
            event.preventDefault();
            let _self = $(this);

            _self.prop('disabled', true).addClass('button-loading');

            $.ajax({
                url: _self.prop('href'),
                method: 'POST',
                data: {
                    id: _self.data('id')
                },
                dataType: 'json',
                success: res => {
                    _self.prop('disabled', false).removeClass('button-loading').addClass('active');

                    if (res.error) {
                        window.showAlert('alert-danger', res.message);
                        return false;
                    }

                    window.showAlert('alert-success', res.message);

                    if (_self.prop('name') === 'checkout' && res.data.next_url !== undefined) {
                        window.location.href = res.data.next_url;
                    } else {
                        $.ajax({
                            url: window.siteUrl + '/ajax/cart',
                            method: 'GET',
                            success: response => {
                                if (!response.error) {
                                    $('.ps-cart--mobile').html(response.data.html);
                                    $('.btn-shopping-cart span i').text(response.data.count);
                                }
                            }
                        });
                    }
                },
                error: res => {
                    _self.prop('disabled', false).removeClass('button-loading');
                    window.showAlert('alert-danger', res.message);
                }
            });
        });

        $(document).on('click', '.remove-cart-item', function (event) {
            event.preventDefault();
            let _self = $(this);

            _self.closest('.ps-product--cart-mobile').addClass('content-loading');

            $.ajax({
                url: _self.prop('href'),
                method: 'GET',
                success: res => {
                    _self.closest('.ps-product--cart-mobile').removeClass('content-loading');

                    if (res.error) {
                        window.showAlert('alert-danger', res.message);
                        return false;
                    }

                    $.ajax({
                        url: window.siteUrl + '/ajax/cart',
                        method: 'GET',
                        success: response => {
                            if (!response.error) {
                                $('.ps-cart--mobile').html(response.data.html);
                                $('.btn-shopping-cart span i').text(response.data.count);
                                window.showAlert('alert-success', res.message);
                            }
                        }
                    });
                },
                error: res => {
                    _self.closest('.ps-product--cart-mobile').removeClass('content-loading');
                    window.showAlert('alert-danger', res.message);
                }
            });
        });

        $(document).on('click', '#buyNowBtn', function (event) {
            $('.add-to-cart-form button[type=submit]').click();
        });

        $(document).on('click', '.add-to-cart-form button[type=submit]', function (event) {
            event.preventDefault();
            event.stopPropagation();

            let _self = $(this);

            if (!$('.hidden-product-id').val()) {
                _self.prop('disabled', true).addClass('btn-disabled');
                return;
            }

            _self.prop('disabled', true).addClass('btn-disabled').addClass('button-loading');

            _self.closest('form').find('.error-message').hide();
            _self.closest('form').find('.success-message').hide();

            $.ajax({
                type: 'POST',
                cache: false,
                url: _self.closest('form').prop('action'),
                data: new FormData(_self.closest('form')[0]),
                contentType: false,
                processData: false,
                success: res => {
                    _self.prop('disabled', false).removeClass('btn-disabled').removeClass('button-loading');

                    if (res.error) {
                        _self.removeClass('button-loading');
                        window.showAlert('alert-danger', res.message);
                        return false;
                    }

                    //window.showAlert('alert-success', res.message);

                    dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
                    let products = [];
                    $.each(res.data.content, (key,row) => {
                        console.log(row)
                        products.push({
                            'name': row.name,
                            'id': row.id,
                            'price': row.price,
                            'brand': row.brand,
                            'category': row.category,
                            'variant': row.options.attributes,
                            'quantity': row.qty
                        });
                    });

                    dataLayer.push({
                        'event': 'addToCart',
                        'ecommerce': {
                            'currencyCode': res.data.currencyCode,
                            'add': {
                                'products': products
                            }
                        }
                    });

                    if (_self.prop('name') === 'checkout' && res.data.next_url !== undefined) {
                        window.location.href = res.data.next_url;
                    } else {
                        window.location.href = '/cart'
                       /*$.ajax({
                            url: window.siteUrl + '/ajax/cart',
                            method: 'GET',
                            success: function (response) {
                                if (!response.error) {
                                    $('.ps-cart--mobile').html(response.data.html);
                                    $('.btn-shopping-cart span i').text(response.data.count);
                                    $('.cart_itemCount').text(response.data.count);
                                }
                            }
                        });*/
                    }
                },
                error: res => {
                    _self.prop('disabled', false).removeClass('btn-disabled').removeClass('button-loading');
                    handleError(res, _self.closest('form'));
                }
            });
        });

        $(document).on('change', '.submit-form-on-change', function () {
            $(this).closest('form').submit();
        });

        $(document).on('click', '.form-review-product button[type=submit]', function (event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).prop('disabled', true).addClass('btn-disabled').addClass('button-loading');

            $.ajax({
                type: 'POST',
                cache: false,
                url: $(this).closest('form').prop('action'),
                data: new FormData($(this).closest('form')[0]),
                contentType: false,
                processData: false,
                success: res => {
                    if (!res.error) {
                        $(this).closest('form').find('select').val(0);
                        $(this).closest('form').find('textarea').val('');

                        showSuccess(res.message);

                         setTimeout(function () {
                             window.location.reload();
                         }, 1500);
                    } else {
                        showError(res.message);
                    }

                    $(this).prop('disabled', false).removeClass('btn-disabled').removeClass('button-loading');
                },
                error: res => {
                    $(this).prop('disabled', false).removeClass('btn-disabled').removeClass('button-loading');
                    handleError(res, $(this).closest('form'));
                }
            });
        });

        $('.form-coupon-wrapper .coupon-code').keypress(event => {
            if (event.keyCode === 13) {
                $('.apply-coupon-code').trigger('click');
                event.preventDefault();
                event.stopPropagation();
                return false;
            }
        });

        $(document).on('click', '.btn-apply-coupon-code', event => {
            event.preventDefault();
            let _self = $(event.currentTarget);
            _self.prop('disabled', true).addClass('btn-disabled').addClass('button-loading');

            $.ajax({
                url: _self.data('url'),
                type: 'POST',
                data: {
                    coupon_code: _self.closest('.form-coupon-wrapper').find('.coupon-code').val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: res => {
                    if (!res.error) {
                        $('.ps-section--shopping').load(window.location.href + '?applied_coupon=1 .ps-section--shopping > *', function () {
                            _self.prop('disabled', false).removeClass('btn-disabled').removeClass('button-loading');
                            window.showAlert('alert-success', res.message);
                        });
                    } else {
                        window.showAlert('alert-danger', res.message);
                        _self.prop('disabled', false).removeClass('btn-disabled').removeClass('button-loading');
                    }
                },
                error: data => {
                    if (typeof (data.responseJSON) !== 'undefined') {
                        if (data.responseJSON.errors !== 'undefined') {
                            $.each(data.responseJSON.errors, (index, el) => {
                                $.each(el, (key, item) => {
                                    window.showAlert('alert-danger', item);
                                });
                            });
                        } else if (typeof (data.responseJSON.message) !== 'undefined') {
                            window.showAlert('alert-danger', data.responseJSON.message);
                        }
                    } else {
                        window.showAlert('alert-danger', data.status.text);
                    }
                    _self.prop('disabled', false).removeClass('btn-disabled').removeClass('button-loading');
                }
            });
        });

        $(document).on('click', '.btn-remove-coupon-code', event => {
            event.preventDefault();
            let _self = $(event.currentTarget);
            let buttonText = _self.text();
            _self.text(_self.data('processing-text'));

            $.ajax({
                url: _self.data('url'),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: res => {
                    if (!res.error) {
                        $('.ps-section--shopping').load(window.location.href + ' .ps-section--shopping > *', function () {
                            _self.text(buttonText);
                        });
                    } else {
                        window.showAlert('alert-danger', res.message);
                        _self.text(buttonText);
                    }
                },
                error: data => {
                    if (typeof (data.responseJSON) !== 'undefined') {
                        if (data.responseJSON.errors !== 'undefined') {
                            $.each(data.responseJSON.errors, (index, el) => {
                                $.each(el, (key, item) => {
                                    window.showAlert('alert-danger', item);
                                });
                            });
                        } else if (typeof (data.responseJSON.message) !== 'undefined') {
                            window.showAlert('alert-danger', data.responseJSON.message);
                        }
                    } else {
                        window.showAlert('alert-danger', data.status.text);
                    }
                    _self.text(buttonText);
                }
            });
        });









    });

})(jQuery);
