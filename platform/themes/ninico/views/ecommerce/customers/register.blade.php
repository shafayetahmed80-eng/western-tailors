<section class="track-area">
    {!!
        $form
            ->modify('submit', 'submit', [
                'attr' => [
                    'class' => 'tptrack__submition',
                ],
            ])
            ->renderForm()
    !!}
</section>
