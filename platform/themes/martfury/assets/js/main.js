(function($) {
    'use strict';
    function masonry($selector) {
        var masonry = $($selector);
        if (masonry.length > 0) {
            if (masonry.hasClass('filter')) {
                masonry.imagesLoaded(function() {
                    masonry.isotope({
                        columnWidth: '.grid-sizer',
                        itemSelector: '.grid-item',
                        isotope: {
                            columnWidth: '.grid-sizer',
                        },
                        filter: '*',
                    });
                });
                var filters = masonry
                    .closest('.masonry-root')
                    .find('.ps-masonry-filter > li > a');
                filters.on('click', function(e) {
                    e.preventDefault();
                    var selector = $(this).attr('href');
                    filters.find('a').removeClass('current');
                    $(this)
                        .parent('li')
                        .addClass('current');
                    $(this)
                        .parent('li')
                        .siblings('li')
                        .removeClass('current');
                    $(this)
                        .closest('.masonry-root')
                        .find('.ps-masonry')
                        .isotope({
                            itemSelector: '.grid-item',
                            isotope: {
                                columnWidth: '.grid-sizer',
                            },
                            filter: selector,
                        });
                    return false;
                });
            } else {
                masonry.imagesLoaded(function() {
                    masonry.masonry({
                        columnWidth: '.grid-sizer',
                        itemSelector: '.grid-item',
                    });
                });
            }
        }
    }



    function slickConfig() {
        var product = $('.ps-product--detail');
        if (product.length > 0) {
            var primary = product.find('.ps-product__gallery'),
                second = product.find('.ps-product__variants'),
                vertical = product
                    .find('.ps-product__thumbnail')
                    .data('vertical');
            primary.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: '.ps-product__variants',
                fade: true,
                dots: false,
                infinite: false,
                arrows: primary.data('arrow'),
                prevArrow: "<a href='#'><i class='fa fa-angle-left'></i></a>",
                nextArrow: "<a href='#'><i class='fa fa-angle-right'></i></a>",
            });
            second.slick({
                slidesToShow: second.data('item'),
                slidesToScroll: 1,
                infinite: false,
                arrows: second.data('arrow'),
                focusOnSelect: true,
                prevArrow: "<a href='#'><i class='fa fa-angle-up'></i></a>",
                nextArrow: "<a href='#'><i class='fa fa-angle-down'></i></a>",
                asNavFor: '.ps-product__gallery',
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
    }



    $(function() {
        masonry('.ps-masonry');
        slickConfig();
    });

    $('#product-quickview').on('shown.bs.modal', function(e) {
        $('.ps-product--quickview .ps-product__images').slick('setPosition');
    });

    $(window).on('load', function() {
        $('body').addClass('loaded');
    });
})(jQuery);
