try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {
}

import {CheckoutAddress} from './partials/address';
import {DiscountManagement} from './partials/discount';

class MainCheckout {
    constructor() {
        new CheckoutAddress().init();
        new DiscountManagement().init();
    }

    static showNotice(messageType, message, messageHeader = '') {
        toastr.clear();

        toastr.options = {
            closeButton: true,
            positionClass: 'toast-bottom-right',
            onclick: null,
            showDuration: 1000,
            hideDuration: 1000,
            timeOut: 10000,
            extendedTimeOut: 1000,
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };

        if (!messageHeader) {
            switch (messageType) {
                case 'error':
                    messageHeader = window.messages.error_header;
                    break;
                case 'success':
                    messageHeader = window.messages.success_header;
                    break;
            }
        }
        toastr[messageType](message, messageHeader);
    }

    init() {

        let loadShippingFeeAtTheFirstTime = function () {
            let shippingMethod = $(document).find('input[name=shipping_method]').first();

            if (shippingMethod.length) {
                shippingMethod.trigger('click');

                let target = '#main-checkout-product-info';
                if ($('#main-checkout-product-info').is(':hidden')) {
                    target = '#main-checkout-product-info-mobile';
                }

                $('.payment-info-loading').show();

                $('.mobile-total').text('...');

                $(target).load(window.location.href
                    + '?shipping_method=' + shippingMethod.val()
                    + '&shipping_option=' + shippingMethod.data('option')
                    + ' ' + target + ' > *', () => {
                    $('.payment-info-loading').hide();
                });
            }
        }

        loadShippingFeeAtTheFirstTime();

        $(document).on('change', 'input[name=shipping_method]', event => {
            // Fixed: set shipping_option value based on shipping_method change:
            $('input[name=shipping_option]').val($(event.currentTarget).data('option'));

            let target = '#main-checkout-product-info';
            if ($('#main-checkout-product-info').is(':hidden')) {
                target = '#main-checkout-product-info-mobile';
            }

            $('.payment-info-loading').show();

            $('.mobile-total').text('...');

            $(target).load(window.location.href
                + '?shipping_method=' + $(event.currentTarget).val()
                + '&shipping_option=' + $(event.currentTarget).data('option')
                + ' ' + target + ' > *', () => {
                $('.payment-info-loading').hide();
            });
        });

        $(document).on('change', '.customer-address-payment-form .address-control-item', function () {
            let _self = $(this);
            if ($('#address_id').val() || ($('#address_country').val() && $('#address_state').val() && $('#address_city').val() && $('#address_address').val())) {
                $.ajax({
                    type: 'POST',
                    cache: false,
                    url: $('#save-shipping-information-url').val(),
                    data: new FormData(_self.closest('form')[0]),
                    contentType: false,
                    processData: false,
                    success: res => {
                        if (!res.error) {
                            $('.shipping-info-loading').show();
                            $('#shipping-method-wrapper').load(window.location.href + ' #shipping-method-wrapper > *', () => {
                                $(document).find('input[name=shipping_method]:first-child').trigger('click');
                                $('.shipping-info-loading').hide();
                            });
                        }
                    },
                    error: res => {
                        console.log(res);
                    }
                });
            }
        });

        // $('.disabled-tab').click(function(e) {
        //     e.preventDefault()
        //     e.stopPropagation()
        //     return false;
        // });
        // $(document).on('click', '.disabled-tab', function (e) {
        //     e.preventDefault()
        //     e.stopPropagation()
        //     return false;
        // });
        $('.nav-tabs > li:nth-child(2) > a').click(function() {
            $('.checkout-next-step').trigger('click')
        });
        $('.nav-tabs > li:nth-child(1) > a').click(function() {
            $('#customer-info').css('display','block')
            $('#payment').css('display','none')

            var $curr = $(".process-model  a[href='#customer-info']").parent();

            $('.process-model li').removeClass();

            $curr.addClass("active");
            $curr.prevAll().addClass("visited");
        });
        $(document).on('click', '.checkout-next-step', function () {
            let _self = $(this);
            if ($('#address_id').val() || ($('#address_country').val() && $('#address_state').val() && $('#address_city').val() && $('#address_address').val())) { }
                $.ajax({
                    type: 'POST',
                    cache: false,
                    url: '/checkout/validate',
                    data: new FormData(_self.closest('form')[0]),
                    contentType: false,
                    processData: false,
                    success: res => {
                        jQuery(".text-danger").remove();
                        //$('.nav-tabs > li:nth-child(2) > a').click();
                        $('#customer-info').css('display','none')
                        $('#payment').css('display','block')

                        var $curr = $(".process-model  a[href='#payment']").parent();

                        $('.process-model li').removeClass();

                        $curr.addClass("active");
                        $curr.prevAll().addClass("visited");

                        if (!res.errors) {
                            // $curr.addClass("active");
                            // $curr.prevAll().addClass("visited");
                        }
                    },
                    error: res => {
                        jQuery(".text-danger").remove()
                        $.each(res.responseJSON.errors, function (error, message) {
                            //toastr.error(message)
                            var res = error.replace(".", "[");
                            jQuery("input[name='"+res+"]']").parent( ".check_input" ).addClass('has-error');
                            jQuery("input[name='"+res+"]']").after('<div class="text-danger" > <small>'+message+'</small></div>');
                            jQuery("select[name='"+res+"]']").after('<div class="text-danger" > <small> '+message+'</small></div>');
                        })
                            $('.nav-tabs > li:first-child > a').click();
                    }
                });

        });
    }
}

$(document).ready(() => {
    new MainCheckout().init();

    window.MainCheckout = MainCheckout;
});
