<?php

namespace Database\Seeders;

use App\Models\SkillScale;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SkillScaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skillScaleValue = [
            ['value' => 0, 'dreyfus' => '0 - No knowledge'],
            ['value' => 1, 'dreyfus' => '1 - Novice'],
            ['value' => 2, 'dreyfus' => '2 - Beginner'],
            ['value' => 3, 'dreyfus' => '3 - Intermediate'],
            ['value' => 4, 'dreyfus' => '4 - Advanced'],
            ['value' => 5, 'dreyfus' => '5 - Expert'],
        ];

        foreach ($skillScaleValue as $item) {
            SkillScale::create($item);
        }
    }
}
