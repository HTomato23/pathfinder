<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_id'   => Author::factory(), // Automatically creates an author if none exists
            'title'       => $this->faker->unique()->sentence(6),
            'description' => $this->faker->paragraph(3),
            'status'      => $this->faker->randomElement(['Draft', 'Published', 'Archived']),

            'header_1'    => $this->faker->sentence(4),
            'header_2'    => $this->faker->sentence(4),
            'header_3'    => $this->faker->sentence(4),
            'header_4'    => $this->faker->sentence(4),
            'header_5'    => $this->faker->sentence(4),
            'header_6'    => $this->faker->sentence(4),

            'content_1'   => $this->faker->paragraphs(3, true),
            'content_2'   => $this->faker->paragraphs(3, true),
            'content_3'   => $this->faker->paragraphs(3, true),
            'content_4'   => $this->faker->paragraphs(3, true),
            'content_5'   => $this->faker->paragraphs(3, true),
            'content_6'   => $this->faker->paragraphs(3, true),
        ];
    }
}
