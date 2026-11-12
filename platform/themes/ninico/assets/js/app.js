$(document).ready(() => {
    window.Theme = window.Theme || {}
    window.Theme.isRtl = () => $('body').prop('dir') === 'rtl'

    const $categoryLabel = $('.product-category-label .form-label')

    $(document).on('change', '.product-category-select', function () {
        $categoryLabel.text($.trim($(this).find('option:selected').text()))
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').prop('content'),
        },
    })
})
