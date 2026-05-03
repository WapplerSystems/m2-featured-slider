define(['jquery', 'swiper'], function ($, Swiper) {
    'use strict';

    return function (config, element) {
        var $el = $(element);
        var $swiper = $el.find('.fslider-swiper').get(0);
        if (!$swiper) {
            return;
        }

        var options = {
            loop: !!config.loop,
            slidesPerView: config.slidesPerView || 1,
            spaceBetween: config.spaceBetween || 0,
            breakpoints: config.breakpoints || {},
            grabCursor: true,
            watchOverflow: true
        };

        if (config.autoplay) {
            options.autoplay = config.autoplay;
        }
        if (config.pagination) {
            options.pagination = {
                el: $el.find('.swiper-pagination').get(0),
                clickable: true
            };
        }
        if (config.navigation) {
            options.navigation = {
                nextEl: $el.find('.swiper-button-next').get(0),
                prevEl: $el.find('.swiper-button-prev').get(0)
            };
        }

        new Swiper($swiper, options);
    };
});
