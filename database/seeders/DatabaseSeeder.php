<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Admin;
use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hardcoded Administrator Account
        Admin::create([
            'first_name' => 'Lanz',
            'last_name' => 'Bautista',
            'email' => 'bautista_lanzryan@plpasig.edu.ph',
            'role' => 'Administrator',
            'password' => Hash::make('Ryan4565$'),
        ]);

        Admin::create([
            'first_name' => 'Florence',
            'last_name' => 'Cariño',
            'email' => 'carino_florenceguiller@plpasig.edu.ph',
            'role' => 'Administrator',
            'password' => Hash::make('123456Pogi'),
        ]);

        Admin::create([
            'first_name' => 'Trixcy',
            'last_name' => 'Bucad',
            'email' => 'bucad_trixcymae@plpasig.edu.ph',
            'role' => 'Administrator',
            'password' => Hash::make('acceptance1234!'),
        ]);

        $authors = Author::factory(5)->create();

        Blog::factory(20)->create([
            'author_id' => fn() => $authors->random()->id,
        ]);

        // Likert Seeder
        $this->call([
            DatasetSeeder::class,
            JobPortalSeeder::class,
            SkillScaleSeeder::class,
            LikertScaleSeeder::class,
            ConsultationSeeder::class,
            SoftSkillTestSeeder::class,
            SkillScaleTestSeeder::class,
            PersonalityTestSeeder::class,
            SkillScaleTestHmSeeder::class,
        ]);
    }
}
