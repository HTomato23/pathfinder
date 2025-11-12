<?php

namespace Database\Seeders;

use App\Models\LikertScale;
use Illuminate\Database\Seeder;

class LikertScaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $likertValues = [
            ['value' => 1, 'likert' => 'Strongly Disagree'],
            ['value' => 2, 'likert' => 'Disagree'],
            ['value' => 3, 'likert' => 'Neutral'],
            ['value' => 4, 'likert' => 'Agree'],
            ['value' => 5, 'likert' => 'Strongly Agree'],
        ];

        foreach ($likertValues as $item) {
            LikertScale::create($item);
        }
    }
}
