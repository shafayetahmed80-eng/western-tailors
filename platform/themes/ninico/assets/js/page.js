$(document).ready(() => {
    const $pageForm = $(document).find('#botble-page-forms-page-form')

    const fieldsToToggle = [
        'footer_background_color',
        'footer_text_color',
        'footer_text_muted_color',
        'footer_logo',
        'footer_border_color',
        'footer_bottom_background_color',
    ]

    $pageForm.on('change', 'select[name="customize_footer"]', function () {
        fieldsToToggle.forEach((field) => {
            $pageForm
                .find(`[name="${field}"]`)
                .closest('.meta-boxes')
                .css('display', $(this).val() === 'custom' ? 'block' : 'none')
        })
    })

    $pageForm.find('select[name="customize_footer"]').trigger('change')
})
