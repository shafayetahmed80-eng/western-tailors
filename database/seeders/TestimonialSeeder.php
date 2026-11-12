<?php

namespace Database\Seeders;

use Botble\Base\Facades\MetaBox;
use Botble\Base\Supports\BaseSeeder;
use Botble\Testimonial\Models\Testimonial;
use Illuminate\Support\Arr;

class TestimonialSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('testimonials');

        $testimonials = [
            [
                'name' => 'Guy Hawkins',
                'company' => 'Bank of America',
                'content' => 'Five stars! Their cosmetics are magic. Transformed my skin, enhanced my beauty. A go-to for quality and results ⭐⭐⭐⭐⭐',
                'title' => 'Satisfied client testimonial',
            ],
            [
                'name' => 'Eleanor Pena',
                'company' => 'Nintendo',
                'content' => 'Top-notch! 5 stars. Makeup, skincare, all exceptional. Delighted with my purchases. A must-visit for every beauty enthusiast! ⭐⭐⭐⭐⭐',
                'title' => '98% of residents recommend us',
            ],
            [
                'name' => 'Cody Fisher',
                'company' => 'Starbucks',
                'content' => 'Thrilled with results! 5 stars. Solved my sensitive skin issues. The cosmetics shop is a gem. Highly recommended. ⭐⭐⭐⭐⭐',
                'title' => 'Our success stories',
            ],
            [
                'name' => 'Albert Flores',
                'company' => 'Bank of America',
                'content' => 'Wedding day savior! 5 stars. Their bridal collection is a game-changer. Made me feel like a star. Impressed beyond words. ⭐⭐⭐⭐⭐',
                'title' => 'This is simply unbelievable',
            ],
        ];

        Testimonial::query()->truncate();

        foreach ($testimonials as $index => $item) {
            $item['image'] = sprintf('testimonials/avatar-%d.png', $index + 1);

            $testimonial = Testimonial::query()->create(Arr::except($item, ['title']));

            MetaBox::saveMetaBoxData($testimonial, 'title', Arr::get($item, 'title'));
            MetaBox::saveMetaBoxData($testimonial, 'star', 5);
        }
    }
}
