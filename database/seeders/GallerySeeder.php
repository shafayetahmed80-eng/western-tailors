<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Gallery\Database\Traits\HasGallerySeeder;

class GallerySeeder extends BaseSeeder
{
    use HasGallerySeeder;

    public function run(): void
    {
        $this->uploadFiles('galleries');

        $galleries = [
            [
                'name' => 'Perfect',
            ],
            [
                'name' => 'New Day',
            ],
            [
                'name' => 'Happy Day',
            ],
            [
                'name' => 'Nature',
            ],
            [
                'name' => 'Morning',
            ],
            [
                'name' => 'Photography',
            ],
        ];

        $faker = $this->fake();

        $images = [];
        foreach ($this->getFilesFromPath('galleries') as $item) {
            $images[] = [
                'img' => $item,
                'description' => $faker->text(150),
            ];
        }

        foreach ($galleries as $index => &$item) {
            $item['image'] = $this->filePath('galleries/' . ($index + 1) . '.jpg');
            $item['is_featured'] = true;
        }

        $this->createGalleries($galleries, $images);
    }
}
