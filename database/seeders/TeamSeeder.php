<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Team\Models\Team;

class TeamSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('testimonials');

        Team::query()->truncate();

        $teams = [
            [
                'name' => 'Rosalina D. Willson',
                'title' => 'Founder',
                'location' => 'USA',
            ],
            [
                'name' => 'Ukolilix X. Xilanorix',
                'title' => 'CEO',
                'location' => 'Qatar',
            ],
            [
                'name' => 'Alonso M. Miklonax',
                'title' => 'Designer',
                'location' => 'India',
            ],
            [
                'name' => 'Miranda H. Halim',
                'title' => 'Developer',
                'location' => 'China',
            ],
        ];

        foreach ($teams as $index => $item) {
            Team::query()->create(array_merge($item, [
                'photo' => 'testimonials/team-' . ($index + 1) . '.jpg',
            ]));
        }
    }
}
