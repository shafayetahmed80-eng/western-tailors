class Ecommerce {
    $body = $(document.body)
    upsellRefreshUrl = null

    init() {
        this.$body
            .on('click', '.add-to-cart:not(.cart-form button[type=submit])', (event) => {
                this.addToCart(event)
            })
            .on('click', '.remove-cart-item', (event) => {
                this.removeFromCart(event)
            })
            .on('click', '.btn-apply-coupon-code', (event) => {
                this.applyCouponCode(event)
            })
            .on('click', '.btn-remove-coupon-code', (event) => {
                this.removeCouponCode(event)
            })
            .on('click', '.product-quantity span', (event) => {
                this.changeCartQuantity(event)
            })
            .on('keyup', '.product-quantity input', (event) => {
                this.onChangeQuantityInput(event)
            })
            .on('click', '.add-to-compare', (event) => {
                this.addToCompare(event)
            })
            .on('click', '.js-sale-popup-quick-view-button', (event) => {
                this.quickView(event)
            })
            .on('click', '.tpproduct .quickview', (event) => {
                this.quickView(event)
            })
            .on('click', '.tpproduct .button-quick-shop', (event) => {
                this.quickShop(event)
            })
            .on('click', '[data-bb-toggle="quick-shop"]', (event) => {
                this.quickShop(event)
            })
            .on('click', '.remove-compare-item', (event) => {
                this.removeFromCompare(event)
            })
            .on('click', '.add-to-wishlist', (event) => {
                this.addToWishlist(event)
            })
            .on('click', '.remove-wishlist-item', (event) => {
                this.removeFromWishlist(event)
            })
            .on('click', '.product-area .basic-pagination ul li a', (event) => {
                this.handleProductsPagination(event)
            })
            .on('change', '.product-area .tp-shop-selector select[name="sort-by"]', (event) => {
                this.handleProductsSorting(event)
            })
            .on('change', '.product-area .tp-shop-selector select[name="per-page"]', (event) => {
                this.handleProductsPerPage(event)
            })
            .on('click', '.product-area .product-filter-nav button', (event) => {
                this.handleProductsLayout(event)
            })
            .on('change', '.bb-product-form-filter select, input', (event) => {
                if ($(event.currentTarget).closest('#quick-shop-popup').length) {
                    return
                }

                this.$body.find('.bb-product-form-filter').trigger('submit')
            })
            .on('click', '.product-filter-button', () => {
                this.$body.find('.product-filter-mobile').addClass('active')
            })
            .on('click', '.product-filter-mobile .backdrop, .close-product-filter-mobile', () => {
                this.$body.find('.product-filter-mobile').removeClass('active')
            })
            .on('click', 'form.cart-form button[type=submit]', (event) => {
                this.addProductToCart(event)
            })
            .on('click', '.tpproduct-details__reviewers', () => {
                this.$body.find('.tpproduct-details__nav #reviews-tab').trigger('click')
                const $navTab = $('.tpproduct-details__navtab');

                if ($navTab.length) {
                    $('html, body').animate({
                        scrollTop: $navTab.offset().top - 100,
                    })
                }
            })
            .on('click', '.product-sidebar__list .f-right', (event) => {
                event.preventDefault()

                $(event.currentTarget).closest('.category-filter').find('.product-sidebar__list').slideToggle()
            })

        this.priceFilter()
        this.productGallery($('.product-gallery'))
        this.quickSearchProducts()

        const _this = this

        window.onBeforeChangeSwatches = function(data, $attrs) {
            const $product = $attrs.closest('.tpproduct-details__content')
            const $form = $product.find('.cart-form')

            $product.find('.error-message').hide()
            $product.find('.success-message').hide()
            $product.find('.number-items-available').html('').hide()
            const $submit = $form.find('button[type=submit]')

            if (data) {
                $submit.prop('disabled', true)
            }
        }

        window.onChangeSwatchesSuccess = function(response, $attrs) {
            const $product = $attrs.closest('.tpproduct-details__content')
            const $form = $product.find('.cart-form')
            const $footerCartForm = $('.footer-cart-form')

            if (!response) {
                return
            }

            const $submit = $form.find('button[type=submit]')

            if (response.error) {
                $submit.prop('disabled', true)
                $product
                    .find('.number-items-available')
                    .html(`<span class='text-danger'>(${response.message})</span>`)
                    .show()
                $form.find('.hidden-product-id').val('')
                $footerCartForm.find('.hidden-product-id').val('')
            } else {
                const data = response.data
                const $price = $product.find('.tpproduct-details__price')
                const $salePrice = $price.find('.product-price-sale')
                const $originalPrice = $price.find('.product-price-original')

                if (data.sale_price !== data.price) {
                    $originalPrice.removeClass('d-none')
                } else {
                    $originalPrice.addClass('d-none')
                }

                $salePrice.text(data.display_sale_price)
                $originalPrice.text(data.display_price)

                if (data.sku) {
                    $product.find('.meta-sku .meta-value').text(data.sku)
                    $product.find('.meta-sku').removeClass('d-none')
                } else {
                    $product.find('.meta-sku').addClass('d-none')
                }

                $form.find('.hidden-product-id').val(data.id)
                $footerCartForm.find('.hidden-product-id').val(data.id)
                $submit.prop('disabled', false)

                if (data.error_message) {
                    $submit.prop('disabled', true)
                    $product
                        .find('.number-items-available')
                        .html(`<span class='text-danger'>(${data.error_message})</span>`)
                        .show()
                } else if (data.success_message) {
                    $product.find('.number-items-available').html(response.data.stock_status_html).show()
                } else {
                    $product.find('.number-items-available').html('').hide()
                }

                $product.find('.tpproduct-details__stock').html(data.stock_status_html)

                const unavailableAttributeIds = data.unavailable_attribute_ids || []
                $product.find('.attribute-swatch-item').removeClass('disabled')
                $product.find('.product-filter-item option').prop('disabled', false)

                if (unavailableAttributeIds && unavailableAttributeIds.length) {
                    unavailableAttributeIds.map(function(id) {
                        let $item = $product.find(`.attribute-swatch-item[data-id="${id}"]`)
                        if ($item.length) {
                            $item.addClass('disabled')
                            $item.find('input').prop('checked', false)
                        } else {
                            $item = $product.find(`.product-filter-item option[data-id="${id}"]`)
                            if ($item.length) {
                                $item.prop('disabled', 'disabled').prop('selected', false)
                            }
                        }
                    })
                }

                const $gallery = $product.closest('.product-area').find('.product-gallery')

                let imageHtml = ''

                data.image_with_sizes.origin.forEach(function(item) {
                    imageHtml += `<a href='${item}'>
                        <img title='${data.name}' title='${data.name}' src='${
                        siteConfig.img_placeholder ? siteConfig.img_placeholder : item
                    }' data-lazy='${item}'>
                    </a>`
                })

                $gallery.find('.product-gallery__wrapper').slick('unslick').html(imageHtml)

                let thumbHtml = ''

                data.image_with_sizes.thumb.forEach(function(item) {
                    thumbHtml += `<img alt='${data.name}' title='${data.name}' src='${
                        siteConfig.img_placeholder ? siteConfig.img_placeholder : item
                    }' data-src='${item}' data-lazy='${item}'>`
                })

                $gallery.find('.product-thumbnails').slick('unslick').html(thumbHtml)

                _this.productGallery($gallery)

                setTimeout(function() {
                    const $productGalleryWrapper = $('.product-gallery__wrapper')

                    if ($productGalleryWrapper.length && !$productGalleryWrapper.width()) {
                        _this.productGallery($gallery)
                    }
                }, 1500)
            }
        }
    }

    productGallery($gallery) {
        if (!$gallery.length) {
            return
        }

        const first = $gallery.find('.product-gallery__wrapper')
        const thumbnails = $gallery.find('.product-thumbnails')

        if (first.length) {
            if (first.hasClass('slick-initialized')) {
                first.slick('unslick')
            }

            first.slick({
                rtl: Theme.isRtl(),
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: false,
                dots: false,
                arrows: false,
                lazyLoad: 'ondemand',
            })
        }

        if (thumbnails.length) {
            if (thumbnails.hasClass('slick-initialized')) {
                thumbnails.slick('unslick')
            }

            thumbnails.slick({
                rtl: Theme.isRtl(),
                slidesToShow: 6,
                slidesToScroll: 1,
                infinite: false,
                focusOnSelect: true,
                asNavFor: first,
                vertical: thumbnails.data('vertical') === 1,
                nextArrow: '<button class="slick-next slick-arrow"><i class="fas fa-chevron-down"></i></button>',
                prevArrow: '<button class="slick-prev slick-arrow"><i class="fas fa-chevron-up"></i></button>',
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 4,
                            vertical: false,
                        },
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 3,
                            vertical: false,
                        },
                    },
                ],
            })
        }

        this.lightGallery($gallery)
    }

    quickSearchProducts() {
        const quickSearch = '.form--quick-search'
        const $quickSearch = $('.form--quick-search')
        $('body').on('click', function(e) {
            if (!$(e.target).closest(quickSearch).length) {
                $('.panel--search-result').removeClass('active')
            }
        })

        let currentRequest = null
        $quickSearch.on('keyup', '.input-search-product', function() {
            const $form = $(this).closest('form')
            ajaxSearchProduct($form)
        })

        $quickSearch.on('change', '.product-category-select', function() {
            const $form = $(this).closest('form')
            ajaxSearchProduct($form)
        })

        $quickSearch.on('click', '.loadmore', function(e) {
            e.preventDefault()
            const $form = $(this).closest('form')
            $(this).addClass('loading')
            ajaxSearchProduct($form, $(this).attr('href'))
        })

        function ajaxSearchProduct($form, url = null) {
            const $panel = $form.find('.panel--search-result')
            const k = $form.find('.input-search-product').val()
            if (!k) {
                $panel.html('').removeClass('active')
                return
            }

            $quickSearch.find('.input-search-product').val(k)
            const $button = $form.find('button[type=submit]')

            currentRequest = $.ajax({
                type: 'GET',
                url: url || $form.data('url'),
                dataType: 'json',
                data: url ? [] : $form.serialize(),
                beforeSend: function() {
                    $button.addClass('loading')

                    if (currentRequest !== null) {
                        currentRequest.abort()
                    }
                },
                success: ({ error, data }) => {
                    if (!error) {
                        if (url) {
                            const $content = $(`<div>${data}</div>`)
                            $panel.find('.panel__content').find('.loadmore-container').remove()
                            $panel.find('.panel__content').append($content.find('.panel__content p-3').contents())
                        } else {
                            $panel.html(data).addClass('active')
                        }

                        return
                    }

                    $panel.html('').removeClass('active')
                },
                complete: () => {
                    $button.removeClass('loading')
                },
            })
        }
    }

    addToCart(event) {
        event.preventDefault()

        const $currentTarget = $(event.currentTarget)

        $.ajax({
            url: $currentTarget.data('url'),
            method: 'POST',
            data: {
                id: $currentTarget.data('id'),
            },
            dataType: 'json',
            beforeSend: () => {
                $currentTarget.addClass('loading')
            },
            success: ({ error, message }) => {
                if (error) {
                    Theme.showError(message)
                    return
                }

                this.loadAjaxCart()
                this.$body.find('.tp-cart-toggle').trigger('click')
            },
            error: (error) => Theme.handleError(error),
            complete: () => {
                $currentTarget.removeClass('loading')
            },
        })
    }

    addProductToCart(event) {
        event.preventDefault()

        const $button = $(event.currentTarget)
        const $form = $button.closest('form.cart-form')

        const data = $form.serializeArray()
        data.push({ name: 'checkout', value: $button.prop('name') === 'checkout' ? 1 : 0 })

        $.ajax({
            type: 'POST',
            url: $form.prop('action'),
            data: $.param(data),
            beforeSend: () => {
                $button.addClass('button-loading')
            },
            success: ({ error, message, data }) => {
                if (error) {
                    Theme.showError(message)
                    if (data?.next_url !== undefined) {
                        setTimeout(() => {
                            window.location.href = data.next_url
                        }, 500);
                    }

                    return
                }

                if (data?.next_url !== undefined) {
                    window.location.href = data.next_url

                    return
                }

                this.$body.find('.tp-cart-toggle').trigger('click')

                this.loadAjaxCart()

                document.dispatchEvent(new CustomEvent('ecommerce.cart.added', {
                    detail: { element: $form[0] }
                }))
            },
            error: (error) => {
                Theme.handleError(error)
            },
            complete: () => {
                $button.removeClass('button-loading')
            },
        })
    }

    addToCompare(event) {
        event.preventDefault()

        const $currentTarget = $(event.currentTarget)

        $.ajax({
            url: $currentTarget.data('url'),
            method: 'POST',
            beforeSend: () => {
                $currentTarget.addClass('loading')
            },
            success: (response) => {
                const { error, data, message } = response

                if (error) {
                    Theme.showError(message)
                } else {
                    Theme.showSuccess(message)
                    $('.header-cart .tp-product-compare-count').text(data.count)
                }
            },
            error: (error) => {
                Theme.handleError(error)
            },
            complete: () => {
                $currentTarget.removeClass('loading')
            },
        })
    }

    removeFromCompare(event) {
        event.preventDefault()

        const $currentTarget = $(event.currentTarget)

        $.ajax({
            url: $currentTarget.data('url'),
            method: 'POST',
            data: {
                _method: 'DELETE',
            },
            success: (response) => {
                const { error, data, message } = response

                if (error) {
                    Theme.showError(message)
                } else {
                    Theme.showSuccess(message)
                    $('.header-cart .tp-product-compare-count').text(data.count)
                    $('.compare-area').load(window.location.href + ' .compare-area > *')
                }
            },
            error: (error) => {
                Theme.handleError(error)
            },
        })
    }

    removeFromCart(event) {
        event.preventDefault()

        const $currentTarget = $(event.currentTarget)

        $.ajax({
            url: $currentTarget.data('url'),
            method: 'GET',
            beforeSend: () => {
                $currentTarget.addClass('loading')
            },
            success: (response) => {
                if (response.error) {
                    Theme.showError(response.message)
                    return
                }

                const $cartArea = $('.cart-area')

                if ($cartArea.length && window.siteConfig?.cartUrl) {
                    $cartArea.load(window.siteConfig.cartUrl + ' .cart-area > *')
                }

                this.loadAjaxCart()

                document.dispatchEvent(new CustomEvent('ecommerce.cart.removed', {
                    detail: { element: $currentTarget[0] }
                }))
            },
            error: (res) => {
                Theme.showError(res.message)
            },
            complete: () => {
                $currentTarget.removeClass('loading')
            },
        })
    }

    addToWishlist(event) {
        event.preventDefault()

        const $currentTarget = $(event.currentTarget)

        $.ajax({
            url: $currentTarget.data('url'),
            method: 'POST',
            beforeSend: () => {
                $currentTarget.addClass('loading')
            },
            success: (response) => {
                const { error, message, data } = response

                if (error) {
                    Theme.showError(message)
                } else {
                    Theme.showSuccess(message)
                    $('.header-cart .tp-product-wishlist-count').text(data.count)
                    if (data.added) {
                        $currentTarget.find('i').removeClass('fal').addClass('fas')
                    } else {
                        $currentTarget.find('i').removeClass('fas').addClass('fal')
                    }
                }
            },
            error: (error) => {
                Theme.handleError(error)
            },
            complete: () => {
                $currentTarget.removeClass('loading')
            },
        })
    }

    removeFromWishlist(event) {
        event.preventDefault()

        const $currentTarget = $(event.currentTarget)

        $.ajax({
            url: $currentTarget.data('url'),
            method: 'POST',
            data: {
                _method: 'DELETE',
            },
            success: (response) => {
                if (response.error) {
                    Theme.showError(response.message)
                } else {
                    Theme.showSuccess(response.message)
                    $('.header-cart .tp-product-wishlist-count').text(response.data.count)
                    $('.wishlist-area').load(window.location.href + ' .wishlist-area > *')
                }
            },
            error: (error) => {
                Theme.handleError(error)
            },
        })
    }

    loadAjaxCart() {
        if (window.siteConfig?.ajaxCart) {
            $.ajax({
                url: window.siteConfig.ajaxCart,
                method: 'GET',
                success: (response) => {
                    const { data, error } = response
                    if (!error) {
                        this.$body.find('.tpcartinfo .tpcart__product').html(data.html)
                        this.$body.find('.header-cart .tp-product-count').text(data.count)
                    }
                },
            })
        }
    }

    applyCouponCode(event) {
        event.preventDefault()

        const $currentTarget = $(event.currentTarget)

        const couponCode = $currentTarget.closest('.coupon').find('#coupon_code').val()

        $.ajax({
            url: $currentTarget.data('url'),
            type: 'POST',
            data: {
                coupon_code: couponCode,
            },
            beforeSend: () => {
                $currentTarget.prop('disabled', true).addClass('button-loading')
            },
            success: (response) => {
                if (!response.error) {
                    $('.cart-area').load(window.location.href + '?applied_coupon=1 .cart-area > *', function() {
                        $currentTarget.prop('disabled', false).removeClass('button-loading')
                        Theme.showSuccess(response.message)
                    })
                } else {
                    Theme.showError(response.message)
                }
            },
            error: (error) => {
                Theme.handleError(error)
            },
            complete: (response) => {
                if (!(response.status === 200 && !response?.responseJSON?.error)) {
                    $currentTarget.prop('disabled', false).removeClass('button-loading')
                }
            },
        })
    }

    removeCouponCode(event) {
        event.preventDefault()

        const $currentTarget = $(event.currentTarget)
        const buttonText = $currentTarget.text()

        $currentTarget.text($currentTarget.data('loading-text'))

        $.ajax({
            url: $currentTarget.data('url'),
            type: 'POST',
            success: (response) => {
                if (!response.error) {
                    $('.cart-area').load(window.location.href + ' .cart-area > *', function() {
                        $currentTarget.text(buttonText)
                    })
                } else {
                    Theme.showError(response.message)
                }
            },
            error: (error) => {
                Theme.handleError(error)
            },
            complete: (response) => {
                if (!(response.status === 200 && !response?.responseJSON?.error)) {
                    $currentTarget.text(buttonText)
                }
            },
        })
    }

    changeCartQuantity(event) {
        const $target = $(event.target)

        const $quantity = $target.parent().find('input')
        const step = parseInt($quantity.attr('step'), 10)
        const min = parseInt($quantity.attr('min'), 10)
        const max = parseInt($quantity.attr('max'), 10)
        const current = parseInt($quantity.val(), 10)

        if ($target.hasClass('cart-minus') && current > min) {
            $quantity.val(current - step)
            $quantity.trigger('change')
        }

        if ($target.hasClass('cart-plus') && current < max) {
            $quantity.val(current + step)
            $quantity.trigger('change')
        }

        this.updateCart(event)
    }

    onChangeQuantityInput(event) {
        const $target = $(event.target)

        const min = parseInt($target.attr('min'), 10)
        const max = parseInt($target.attr('max'), 10)
        const current = parseInt($target.val(), 10)

        if (current < min) {
            $target.val(min)
        }

        if (current > max) {
            $target.val(max)
        }

        this.updateCart(event)
    }

    updateCart(event) {
        event.preventDefault()

        const $form = this.$body.find('.cart-form')

        if (!$form.length) {
            return
        }

        $.ajax({
            type: 'POST',
            cache: false,
            url: $form.prop('action'),
            data: new FormData($form[0]),
            contentType: false,
            processData: false,
            success: (response) => {
                const { error, message } = response

                if (error) {
                    Theme.showError(message)
                } else {
                    $('.cart-area').load(window.siteConfig.cartUrl + ' .cart-area > *')

                    this.loadAjaxCart()

                    Theme.showSuccess(message)
                }
            },
            error: (error) => {
                Theme.handleError(error)
            },
        })
    }

    handleProductsPagination(event) {
        event.preventDefault()

        const url = new URL($(event.currentTarget).attr('href'))
        const page = url.searchParams.get('page')

        this.$body.find('.bb-product-form-filter').find('input[name="page"]').val(page).trigger('change')
    }

    handleProductsSorting(event) {
        const $currentTarget = $(event.currentTarget)

        this.$body.find('.bb-product-form-filter').find('input[name="sort-by"]').val($currentTarget.val()).trigger('change')
    }

    handleProductsPerPage(event) {
        const $currentTarget = $(event.currentTarget)

        this.$body.find('.bb-product-form-filter').find('input[name="per-page"]').val($currentTarget.val()).trigger('change')
    }

    handleProductsLayout(event) {
        const $currentTarget = $(event.currentTarget)

        $currentTarget.addClass('active')
        $currentTarget.siblings().removeClass('active')

        this.$body.find('.bb-product-form-filter').find('input[name="layout"]').val($currentTarget.data('type')).trigger('change')
    }

    priceFilter() {
        const $sliderRange = $(document).find('#slider-range')

        if ($sliderRange.length) {
            const min = $sliderRange.data('min')
            const max = $sliderRange.data('max')
            const $priceFilter = $(document).find('.price-filter')
            $sliderRange.slider({
                range: true,
                min: min,
                max: max,
                values: [
                    $priceFilter.find('input[name="min_price"]').val(),
                    $priceFilter.find('input[name="max_price"]').val(),
                ],
                slide: function(event, ui) {
                    $priceFilter.find('#amount').text(`${ui.values[0].format_price()} - ${ui.values[1].format_price()}`)
                },
                change: (event, ui) => {
                    $priceFilter.find('input[name="min_price"]').val(ui.values[0])
                    $priceFilter.find('input[name="max_price"]').val(ui.values[1]).trigger('change')
                },
            })

            $priceFilter
                .find('#amount')
                .text(
                    `${$sliderRange.slider('values', 0).format_price()} - ${$sliderRange
                        .slider('values', 1)
                        .format_price()}`,
                )
        }
    }

    /**
     @param {jQuery} element
     */
    lightGallery(element) {
        if (element.data('lightGallery')) {
            element.data('lightGallery').destroy(true)
        }

        element.lightGallery({
            selector: 'a',
            thumbnail: true,
            share: false,
            fullScreen: false,
            autoplay: false,
            autoplayControls: false,
            actualSize: false,
        })
    }

    quickView(event) {
        event.preventDefault()

        const $this = $(event.currentTarget)

        $.ajax({
            url: $this.data('url'),
            type: 'GET',
            beforeSend: () => {
                $this.addClass('loading')
            },
            success: ({ data }) => {
                $('#quick-view-popup').html(data)

                $.magnificPopup.open({
                    items: {
                        src: '#quick-view-popup',
                    },
                    type: 'inline',
                })

                $('.thumbnails .images').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: true,
                    adaptiveHeight: false,
                    rtl: Theme.isRtl(),
                })
            },
            error: function(error) {
                Theme.handleError(error)
            },
            complete: () => {
                $this.removeClass('loading')
            },
        })
    }

    quickShop(event) {
        event.preventDefault()

        const $this = $(event.currentTarget)

        $.ajax({
            url: $this.data('url'),
            type: 'GET',
            beforeSend: () => {
                $this.addClass('loading')
            },
            success: ({ data }) => {
                $('#quick-shop-popup').html(data)

                $.magnificPopup.open({
                    items: {
                        src: '#quick-shop-popup',
                    },
                    type: 'inline',
                })
            },
            error: function(error) {
                Theme.handleError(error)
            },
            complete: () => {
                $this.removeClass('loading')
            },
        })
    }

    initBlockLazyLoading() {
        const _this = this
        $(document).find('[data-bb-toggle="block-lazy-loading"]').each(function () {
            const $element = $(this)
            const url = $element.data('url')

            if (!url) return

            if (url.includes('up-sale-products')) {
                _this.upsellRefreshUrl = url
            }

            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    const data = response.data || response
                    $element.replaceWith(data)

                    if (typeof window.LazyLoad !== 'undefined' && window.lazyLoadInstance) {
                        window.lazyLoadInstance.update()
                    }

                    _this.initSlickCarousel()
                    _this.initUpSaleBundle()
                }
            })
        })
    }

    refreshUpSaleSection() {
        if (!this.upsellRefreshUrl) return

        const $section = $('[data-upsale-bundle]')
        if ($section.length === 0) return

        const _this = this
        $section.css('opacity', '0.5')

        $.ajax({
            url: this.upsellRefreshUrl,
            type: 'GET',
            success: function (response) {
                const data = response.data || response
                $section.replaceWith(data)
                _this.initUpSaleBundle()
            }
        })
    }

    initUpSaleBundle() {
        const _this = this
        const $section = $('[data-upsale-bundle]')
        if ($section.length === 0) return

        const $checkboxes = $section.find('[data-upsale-checkbox]')
        const $totalPrice = $section.find('[data-upsale-total-price]')
        const $addAllBtn = $section.find('[data-upsale-add-all]')

        const formatPrice = function(price) {
            const config = $section.data('currency-config') || window.currencies || {}
            const symbol = config.symbol || '$'
            const isPrefix = config.is_prefix !== false
            const decimals = config.decimals ?? 2
            const thousandsSep = config.thousands_separator || ','
            const decimalSep = config.decimal_separator || '.'

            const formatted = parseFloat(price)
                .toFixed(decimals)
                .replace('.', decimalSep)
                .replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSep)

            return isPrefix ? symbol + formatted : formatted + symbol
        }

        const updateTotal = function() {
            let total = 0
            let count = 0

            $checkboxes.filter(':checked').each(function() {
                total += parseFloat($(this).attr('data-price')) || 0
                count++
            })

            $totalPrice.text(formatPrice(total))
            $addAllBtn.prop('disabled', count === 0)
        }

        $checkboxes.off('change.upsale').on('change.upsale', updateTotal)

        $section.find('[data-upsale-add-btn]').off('click.upsale').on('click.upsale', function(e) {
            e.preventDefault()

            const $btn = $(this)
            const $item = $btn.closest('[data-upsale-bundle-item]')
            const $checkbox = $item.find('[data-upsale-checkbox]')
            const parentProduct = $addAllBtn.data('parent-product') || $btn.data('parent-product')
            const productId = $btn.attr('data-id')
            const addUrl = $btn.data('url')

            $btn.addClass('loading').prop('disabled', true)

            $.ajax({
                url: addUrl,
                type: 'POST',
                data: {
                    id: productId,
                    reference_product_for_upsale: parentProduct,
                },
                success: function(response) {
                    if (response.error) {
                        Theme.showError(response.message || 'Failed to add product')
                        $btn.removeClass('loading').prop('disabled', false)
                        return
                    }

                    if (response.message) {
                        Theme.showSuccess(response.message)
                    }

                    $checkbox.prop('checked', true)
                    updateTotal()

                    _this.loadAjaxCart()

                    document.dispatchEvent(new CustomEvent('ecommerce.cart.added', {
                        detail: { data: response.data, element: $btn[0] }
                    }))

                    _this.refreshUpSaleSection()
                },
                complete: function() {
                    $btn.removeClass('loading').prop('disabled', false)
                }
            })
        })

        $addAllBtn.off('click.upsale').on('click.upsale', function(e) {
            e.preventDefault()

            const $btn = $(this)
            const selectedProducts = []
            const parentProduct = $btn.data('parent-product')

            $checkboxes.filter(':checked').each(function() {
                selectedProducts.push($(this).attr('data-id'))
            })

            if (selectedProducts.length === 0) return

            $btn.addClass('loading').prop('disabled', true)

            let index = 0
            let successCount = 0
            const addNextProduct = function() {
                if (index >= selectedProducts.length) {
                    $btn.removeClass('loading')
                    _this.loadAjaxCart()
                    _this.refreshUpSaleSection()

                    if (successCount > 0) {
                        Theme.showSuccess(`Added ${successCount} item(s) to cart`)
                    }
                    return
                }

                $.ajax({
                    url: $btn.data('url'),
                    type: 'POST',
                    data: {
                        id: selectedProducts[index],
                        reference_product_for_upsale: parentProduct,
                    },
                    success: function() {
                        successCount++
                    },
                    complete: function() {
                        index++
                        addNextProduct()
                    }
                })
            }

            addNextProduct()
        })

        $section.find('.ec-upsell-attributes .product-filter-item').off('change.upsale').on('change.upsale', function() {
            if ($(this).prop('disabled')) return

            const $attrs = $(this).closest('.ec-upsell-attributes')
            const $item = $attrs.closest('[data-upsale-bundle-item]')
            const url = $attrs.data('target')

            if (!url) return

            const data = { attributes: {} }
            $attrs.find('.product-filter-item:checked').each(function() {
                const slug = $(this).closest('.ec-upsell-attribute-group, .attribute-swatches-wrapper').data('slug')
                if (slug) {
                    data.attributes[slug] = $(this).val()
                }
            })

            $.ajax({
                url: url,
                type: 'GET',
                data: data,
                success: function(response) {
                    if (response.data) {
                        const variationId = response.data.id
                        let price = response.data.sale_price || response.data.price
                        const errorMessage = response.data.error_message
                        const unavailableAttrIds = response.data.unavailable_attribute_ids || []

                        $attrs.find('.ec-upsell-attribute-option').each(function() {
                            const $option = $(this)
                            const attrId = parseInt($option.data('id'))
                            const $input = $option.find('input[type="radio"]')

                            if (unavailableAttrIds.includes(attrId)) {
                                $option.addClass('disabled').attr('title', 'Not available')
                                $input.prop('disabled', true)
                            } else {
                                $option.removeClass('disabled').removeAttr('title')
                                $input.prop('disabled', false)
                            }
                        })

                        if (variationId && !errorMessage) {
                            $item.find('.ec-upsell-variation-id').val(variationId)
                            $item.find('[data-upsale-checkbox]').attr('data-id', variationId)
                            $item.find('[data-upsale-add-btn]').attr('data-id', variationId).prop('disabled', false)

                            if (price) {
                                const $checkbox = $item.find('[data-upsale-checkbox]')
                                const bundleDiscount = parseFloat($checkbox.attr('data-bundle-discount')) || 0
                                const bundleDiscountType = $checkbox.attr('data-bundle-discount-type')

                                if (bundleDiscount > 0) {
                                    if (bundleDiscountType === 'percent') {
                                        price = price - (price * bundleDiscount / 100)
                                    } else {
                                        price = Math.max(0, price - bundleDiscount)
                                    }
                                }

                                $checkbox.attr('data-price', price)
                                updateTotal()
                            }
                        } else if (errorMessage) {
                            $item.find('[data-upsale-add-btn]').prop('disabled', true)
                        }
                    }
                }
            })
        })

        updateTotal()
    }

    initSlickCarousel() {
        const $carousel = $('.ec-cross-sale-carousel')
        if ($carousel.length && !$carousel.hasClass('slick-initialized')) {
            $carousel.slick({
                rtl: Theme.isRtl(),
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: false,
                arrows: true,
                dots: false,
                appendArrows: $carousel.closest('.ec-cross-sale-slider').find('.ec-cross-sale-arrows'),
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                        },
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                        },
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1,
                        },
                    },
                ],
            })
        }
    }
}

$(() => {
    const AppEcommerce = new Ecommerce()

    AppEcommerce.init()

    window.NinicoApp = {
        showSuccess: Theme.showSuccess,
        showError: Theme.showError,
        loadAjaxCart: () => AppEcommerce.loadAjaxCart(),
        initBlockLazyLoading: () => AppEcommerce.initBlockLazyLoading(),
        initUpSaleBundle: () => AppEcommerce.initUpSaleBundle(),
        refreshUpSaleSection: () => AppEcommerce.refreshUpSaleSection(),
    }

    window.showSuccess = Theme.showSuccess
    window.showError = Theme.showError
    window.loadAjaxCart = () => AppEcommerce.loadAjaxCart()

    AppEcommerce.initBlockLazyLoading()

    document.addEventListener('ecommerce.cart.added', () => AppEcommerce.refreshUpSaleSection())
    document.addEventListener('ecommerce.cart.removed', () => AppEcommerce.refreshUpSaleSection())

    setTimeout(function() {
        const $productGalleryWrapper = $('.product-gallery__wrapper')

        if ($productGalleryWrapper.length && !$productGalleryWrapper.width()) {
            AppEcommerce.productGallery($('.product-gallery'))
        }
    }, 1500)

    $.each($('.product-sidebar__list .category-filter input[type="checkbox"]:checked'), function() {
        $(this).closest('.product-sidebar__list').show()
    })

    const $productListing = $(document).find('.product-sidebar__product-item');

    document.addEventListener('ecommerce.product-filter.before', () => {
        $productListing.find('.loading-spinner').removeClass('d-none');
    })

    document.addEventListener('ecommerce.product-filter.success', (event) => {
        $('.product-filter-content .product-item-count span').html(event.detail.data.message)

        $productListing.find('.loading-spinner').addClass('d-none');
    })

    $(document).on('click', '[data-bb-toggle="scroll-to-review"]', (e) => {
        e.preventDefault()

        scrollToReviewTab()
    })

    function scrollToReviewTab() {
        if ($('.nav-tabs button#reviews-tab').length) {
            const $tab = $('.nav-tabs button#reviews-tab')
            const $container = $('.product-review-container')

            if ($tab.length && $container.length) {
                $tab.tab('show')

                $('html, body').animate({
                    scrollTop: $container.offset().top - 120,
                })
            }
        }
    }

    if (window.location.href.indexOf('#reviews') !== -1) {
        scrollToReviewTab()
    }
})
