<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Blog\Database\Traits\HasBlogSeeder;
use Illuminate\Support\Facades\File;

class BlogSeeder extends BaseSeeder
{
    use HasBlogSeeder;

    public function run(): void
    {
        $this->uploadFiles('blog');

        $categories = [
            [
                'name' => 'Ecommerce',
            ],
            [
                'name' => 'Fashion',
            ],
            [
                'name' => 'Electronic',
            ],
            [
                'name' => 'Commercial',
            ],
        ];

        $this->createBlogCategories($categories);

        $tags = [
            [
                'name' => 'General',
            ],
            [
                'name' => 'Design',
            ],
            [
                'name' => 'Fashion',
            ],
            [
                'name' => 'Branding',
            ],
            [
                'name' => 'Modern',
            ],
        ];

        $this->createBlogTags($tags);

        $posts = [
            [
                'name' => '4 Expert Tips On How To Choose The Right Men’s Wallet',
            ],
            [
                'name' => 'Sexy Clutches: How to Buy & Wear a Designer Clutch Bag',
            ],
            [
                'name' => 'The Top 2020 Handbag Trends to Know',
            ],
            [
                'name' => 'How to Match the Color of Your Handbag With an Outfit',
            ],
            [
                'name' => 'How to Care for Leather Bags',
            ],
            [
                'name' => "We're Crushing Hard on Summer's 10 Biggest Bag Trends",
            ],
            [
                'name' => 'Essential Qualities of Highly Successful Music',
            ],
            [
                'name' => '9 Things I Love About Shaving My Head',
            ],
            [
                'name' => 'Why Teamwork Really Makes The Dream Work',
            ],
            [
                'name' => 'The World Caters to Average People',
            ],
            [
                'name' => 'The litigants on the screen are not actors',
            ],
        ];

        foreach ($posts as $index => &$item) {
            $item['image'] = 'blog/' . ($index + 1) . '.jpg';
            $item['content'] = File::get(database_path('seeders/contents/post.html'));
        }

        $this->createBlogPosts($posts);
    }
}
