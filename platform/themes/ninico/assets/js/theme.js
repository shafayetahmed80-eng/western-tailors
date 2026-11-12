$(() => {
    'use strict'

    const windowOn = $(window)

    $(window).on('load', function() {
        $('#preloader').delay(350).fadeOut('slow')
        $('body').delay(350).css({ overflow: 'visible' })
    })

    windowOn.on('scroll', function() {
        const scroll = $(window).scrollTop()
        if (scroll < 100) {
            $('#header-sticky,#header-mob-sticky,#header-tab-sticky').removeClass('header-sticky')
        } else {
            $('#header-sticky,#header-mob-sticky,#header-tab-sticky').addClass('header-sticky')
        }
    })

    windowOn.on('scroll', function() {
        const scroll = windowOn.scrollTop()
        if (scroll < 245) {
            $('.scroll-to-target').removeClass('open')
        } else {
            $('.scroll-to-target').addClass('open')
        }
    })

    Number.prototype.format_price = function(n, x) {
        let currencies = window.currencies || {}
        if (!n) {
            n = currencies.number_after_dot !== undefined ? currencies.number_after_dot : 2
        }
        let re = '\\d(?=(\\d{' + (x || 3) + '})+$)'
        let priceUnit = ''
        let price = this
        if (currencies.show_symbol_or_title) {
            priceUnit = currencies.symbol || currencies.title
        }
        if (currencies.display_big_money) {
            if (price >= 1000000 && price < 1000000000) {
                price = price / 1000000
                priceUnit = currencies.million + (priceUnit ? ' ' + priceUnit : '')
            } else if (price >= 1000000000) {
                price = price / 1000000000
                priceUnit = currencies.billion + (priceUnit ? ' ' + priceUnit : '')
            }
        }
        price = price.toFixed(Math.max(0, ~~n))
        price = price.toString().split('.')
        price =
            price[0].toString().replace(new RegExp(re, 'g'), '$&' + currencies.thousands_separator) +
            (price[1] ? currencies.decimal_separator + price[1] : '')
        if (currencies.show_symbol_or_title) {
            if (currencies.is_prefix_symbol) {
                price = priceUnit + price
            } else {
                price = price + priceUnit
            }
        }
        return price
    }

    if ($('.scroll-to-target').length) {
        $('.scroll-to-target').on('click', function() {
            const target = $(this).attr('data-target')
            // animate
            $('html, body').animate(
                {
                    scrollTop: $(target).offset().top,
                },
                100,
            )
        })
    }

    $('[data-background]').each(function() {
        $(this).css('background-image', 'url( ' + $(this).attr('data-background') + '  )')
    })

    $('[data-width]').each(function() {
        $(this).css('width', $(this).attr('data-width'))
    })

    $('[data-bg-color]').each(function() {
        $(this).css('background-color', $(this).attr('data-bg-color'))
    })

    $('.tp-shop-selector select').niceSelect()

    $('.mobile-menu-nav ul').hide()

    $('.mobile-menu-nav ul ul').each(function() {
        if ($(this).children().length) {
            $(this, 'li:first')
                .parent()
                .append(
                    '<a class="mobile-menu-exapand" href="#" title="expand/collapse" style="font-size: 18px"><i class="fal fa-plus"></i></a>',
                )
        }
    })

    $('.mobile-menu-exapand').on('click', function(e) {
        e.preventDefault()

        $(this)
            .prev('ul')
            .slideToggle(300, function() {
            })

        $(this).parent().toggleClass('dropdown-opened')

        $(this).toggleClass('mobile-menu-clicked')
    })

    $('.js-tp-cat-toggle').on('click', function() {
        $('.category-menu').slideToggle(500)
    })

    $('.tp-menu-toggle').on('click', function() {
        $('.tpsideinfo:not(.tpsidecategories):not(.tpsidesearch)').addClass('tp-sidebar-opened')
        $('.body-overlay').addClass('opened')
    })

    $('.tp-categories-sidebar-toggle').on('click', function() {
        $('.tpsidecategories').addClass('tp-sidebar-opened')
        $('.body-overlay').addClass('opened')
    })

    $('.tp-search-sidebar-toggle').on('click', function() {
        $('.tpsidesearch').addClass('tp-sidebar-opened')
        $('.body-overlay').addClass('opened')
    })

    $('.tpsideinfo__close').on('click', function() {
        $('.tpsideinfo').removeClass('tp-sidebar-opened')
        $('.body-overlay').removeClass('opened')
    })

    $('.body-overlay').on('click', function() {
        $('.tpsideinfo').removeClass('tp-sidebar-opened')
        $('.body-overlay').removeClass('opened')
    })

    $('.tp-cart-toggle').on('click', function() {
        $('.tp-cart-info-area').addClass('tp-sidebar-opened')
        $('.cartbody-overlay').addClass('opened')
    })

    $('.tpcart__close').on('click', function() {
        $('.tp-cart-info-area').removeClass('tp-sidebar-opened')
        $('.cartbody-overlay').removeClass('opened')
    })

    $('.cartbody-overlay').on('click', function() {
        $('.tp-cart-info-area').removeClass('tp-sidebar-opened')
        $('.cartbody-overlay').removeClass('opened')
    })

    $('#showlogin').on('click', function() {
        $('#checkout-login').slideToggle(900)
    })

    $('#showcoupon').on('click', function() {
        $('#checkout_coupon').slideToggle(900)
    })

    $('#cbox').on('click', function() {
        $('#cbox_info').slideToggle(900)
    })

    $('#ship-box').on('click', function() {
        $('#ship-box-info').slideToggle(1000)
    })

    let initSlider = function() {
        new Swiper('.slider-active', {
            loop: true,
            slidesPerView: 1,
            effect: 'fade',
            autoplay: {
                delay: 4500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.slider-pagination',
                clickable: true,
            },
        })

        new Swiper('.greenslider-active', {
            loop: true,
            slidesPerView: 1,
            fade: 'effect',
            effect: 'fade',
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.greenslider-pagination',
                clickable: true,
            },
        })

        new Swiper('.slidertwo-active', {
            loop: true,
            slidesPerView: 1,
            effect: 'fade',
            autoplay: {
                delay: 5500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.slidertwo_pagination',
                clickable: true,
            },
        })

        new Swiper('.sliderthree-active', {
            loop: false,
            effect: 'fade',
            slidesPerView: 1,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.tpsliderthree__pagination',
                clickable: true,
            },
        })

        new Swiper('.shopslider-active', {
            loop: true,
            slidesPerView: 6,
            spaceBetween: 25,
            centereMode: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            breakpoints: {
                1400: {
                    slidesPerView: 6,
                },
                1200: {
                    slidesPerView: 5,
                },
                992: {
                    slidesPerView: 4,
                },
                768: {
                    slidesPerView: 3,
                },
                576: {
                    slidesPerView: 2,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        })

        new Swiper('.tp-team-active', {
            loop: false,
            slidesPerView: 4,
            spaceBetween: 25,
            centereMode: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: true,
            },
            breakpoints: {
                1400: {
                    slidesPerView: 4,
                },
                1200: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 2,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        })

        new Swiper('.related-product-active', {
            loop: false,
            slidesPerView: 5,
            spaceBetween: 30,
            autoplay: {
                delay: 3500,
                disableOnInteraction: true,
            },
            breakpoints: {
                1400: {
                    slidesPerView: 5,
                },
                1200: {
                    slidesPerView: 5,
                },
                992: {
                    slidesPerView: 4,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 2,
                },
                0: {
                    slidesPerView: 1,
                },
            },
            navigation: {
                nextEl: '.tprelated__nxt',
                prevEl: '.tprelated__prv',
            },
        })

        new Swiper('.product-active', {
            loop: true,
            slidesPerView: 5,
            spaceBetween: 30,
            autoplay: {
                delay: 3500,
                disableOnInteraction: true,
            },
            breakpoints: {
                1400: {
                    slidesPerView: 5,
                },
                1200: {
                    slidesPerView: 5,
                },
                992: {
                    slidesPerView: 4,
                },
                768: {
                    slidesPerView: 3,
                },
                576: {
                    slidesPerView: 3,
                },
                0: {
                    slidesPerView: 3,
                },
            },
            navigation: {
                nextEl: '.tpproductarrow__nxt',
                prevEl: '.tpproductarrow__prv',
            },
        })

        new Swiper('.brand-active', {
            loop: false,
            slidesPerView: 6,
            spaceBetween: 30,
            freeMode: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: true,
            },
            breakpoints: {
                1400: {
                    slidesPerView: 6,
                },
                1200: {
                    slidesPerView: 4,
                },
                992: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 3,
                },
                576: {
                    slidesPerView: 2,
                },
                0: {
                    slidesPerView: 1,
                },
            },
        })

        new Swiper('.platinam-pro-active', {
            loop: false,
            slidesPerView: 4,
            spaceBetween: 30,
            autoplay: {
                delay: 3000,
                disableOnInteraction: true,
            },
            breakpoints: {
                1400: {
                    slidesPerView: 4,
                },
                1200: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
            // Navigation arrows
            navigation: {
                nextEl: '.tpplatiarrow__nxt',
                prevEl: '.tpplatiarrow__prv',
            },
        })

        new Swiper('.testi-active', {
            // Optional parameters
            loop: false,
            slidesPerView: 3,
            spaceBetween: 30,
            autoplay: {
                delay: 3000,
                disableOnInteraction: true,
            },
            breakpoints: {
                1400: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 1,
                },
                0: {
                    slidesPerView: 1,
                },
            },
            navigation: {
                nextEl: '.tptestiarrow__nxt',
                prevEl: '.tptestiarrow__prv',
            },
        })

        new Swiper('.postbox-active', {
            loop: false,
            slidesPerView: 1,
            spaceBetween: 0,
            autoplay: {
                delay: 4000,
            },
            navigation: {
                nextEl: '.postbox-slider-button-next',
                prevEl: '.postbox-slider-button-prev',
            },
        })

        new Swiper('.swiper--top', {
            spaceBetween: 0,
            centeredSlides: true,
            speed: 30000,
            autoplay: {
                delay: 1,
            },
            loop: false,
            freeMode: true,
            slidesPerView: 'auto',
            allowTouchMove: false,
            disableOnInteraction: true,
        })

        const serviceSlider = $('.service-active')

        let slidersPerView = serviceSlider.attr('data-sliders-per-view') ? serviceSlider.attr('data-sliders-per-view') : 4

        if (serviceSlider.length > 0) {
            new Swiper('.service-active', {
                loop: false,
                slidesPerView: slidersPerView,
                spaceBetween: 30,
                freeMode: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: true,
                },
                breakpoints: {
                    1400: {
                        slidesPerView: slidersPerView,
                    },
                    900: {
                        slidesPerView: 2,
                    },
                    576: {
                        slidesPerView: 1,
                    },
                },
            })
        }

        if ($('.flash-sale-slider').length) {
            new Swiper('.flash-sale-slider', {
                slidesPerView: 5,
                spaceBetween: 10,
                slidesPerColumn: 2,
                slidesPerColumnFill: 'row',
                breakpoints: {
                    1200: {
                        slidesPerView: 5,
                    },
                    992: {
                        slidesPerView: 4,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    576: {
                        slidesPerView: 2,
                    },
                    0: {
                        slidesPerView: 1,
                    },
                },
            })
        }
    }

    let initCountdown = function() {
        if (! $.fn.countdown) {
            return
        }

        $(document).find('[data-countdown]').each(function() {
            const $this = $(this),
                finalDate = $(this).data('countdown')
            $this.countdown(finalDate, function(event) {
                $this.html(
                    event.strftime(
                        '<span class="cdown days"><span class="time-count">%-D</span> <p>Days</p></span> <span class="cdown hour"><span class="time-count">%-H</span> <p>Hour</p></span> <span class="cdown minutes"><span class="time-count">%M</span> <p>Minute</p></span> <span class="cdown second"> <span><span class="time-count">%S</span> <p>Second</p></span>',
                    ),
                )
            })
        })
    }

    initCountdown()

    initSlider()

    document.addEventListener('shortcode.loaded', () => {
        initCountdown()
        initSlider()
    })

    $('.popup-video').magnificPopup({
        type: 'iframe',
    })

    $('.popup-image').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true,
        },
    })

    const democol = $('.tpproduct [class*="col"]')
    democol.on({
        mouseenter: function() {
            $(this).siblings().stop().css('z-index', '-1')
        },
        mouseleave: function() {
            $(this).siblings().stop().css('z-index', '1')
        },
    })

    $(document).on('click', '.tpproduct-details__quantity .cart-minus', function() {
        const $input = $(this).parent().find('input')
        let count = parseInt($input.val()) - 1
        count = count < 1 ? 1 : count
        $input.val(count)
        $input.trigger('change')
    })

    $(document).on('click', '.tpproduct-details__quantity .cart-plus', function() {
        const $input = $(this).parent().find('input')
        $input.val(parseInt($input.val()) + 1)
        $input.trigger('change')
    })

    $(document)
        .on('submit', '.newsletter-form, .subscribe-form', function(event) {
            event.preventDefault()
            event.stopPropagation()

            const form = $(this)
            const button = form.find('button[type=submit]')

            $.ajax({
                type: 'POST',
                cache: false,
                url: form.prop('action'),
                data: new FormData(form[0]),
                contentType: false,
                processData: false,
                beforeSend: () => {
                    button.prop('disabled', true)
                    button.find('i').addClass('button-loading')
                },
                success: (response) => {
                    form.find('input[type=email]').val('')

                    Theme.showSuccess(response.message)
                },
                error: (error) => {
                    Theme.handleError(error)
                },
                complete: () => {
                    if (typeof refreshRecaptcha !== 'undefined') {
                        refreshRecaptcha()
                    }

                    button.prop('disabled', false)
                    button.find('i').removeClass('button-loading')
                },
            })
        })
        .on('click', '.product-area #product-type-tab button', function(event) {
            const $target = $(event.target)
            const url = $target.closest('div').data('route')
            const $tabContent = $(document).find('.product-area .tab-content .tab-pane')
            const $loading = $(document).find('.loading-spinner')

            $.ajax({
                url: `${url}?type=${$target.data('type')}&limit=${$target.closest('div').data('limit')}`,
                method: 'GET',
                dataType: 'json',
                beforeSend: () => $loading.removeClass('d-none'),
                success: (response) => {
                    $tabContent.html(response.data)
                },
                error: (error) => {
                    Theme.handleError(error)
                },
                complete: () => $loading.addClass('d-none'),
            })
        })
        .on('submit', '#contact-form', function(event) {
            event.preventDefault()

            const $form = $(event.currentTarget)

            const $button = $form.find('button[type=submit] > i')

            $.ajax({
                type: 'POST',
                cache: false,
                url: $form.prop('action'),
                data: new FormData($form[0]),
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $button.addClass('button-loading')
                },
                success: ({ error, message }) => {
                    if (!error) {
                        $form[0].reset()
                        Theme.showSuccess(message)
                    } else {
                        Theme.showError(message)
                    }
                },
                error: (error) => {
                    Theme.handleError(error)
                },
                complete: () => {
                    if (typeof refreshRecaptcha !== 'undefined') {
                        refreshRecaptcha()
                    }

                    $button.removeClass('button-loading')
                },
            })
        })

    const triggerProductTab = () => {
        $(document).find('.product-area #product-type-tab button[data-type]').first().trigger('click')
    }

    triggerProductTab()

    document.addEventListener('shortcode.loaded', (e) => {
        if (e.detail.name === 'products') {
            triggerProductTab()
        }
    })

    $(document).on('click', '.more-categories', (e) => {
        $(e.currentTarget).toggleClass('show')

        $('.hidden-to-toggle').slideToggle(500)
    })
})
