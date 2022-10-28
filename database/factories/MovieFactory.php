<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'summary' => $this->faker->text,
            'cover_image' => $this->faker->imageUrl(640, 460, 'movie'),
            'author' => $this->faker->name,
            'imdb_rating' => rand(1, 10),
            'user_id' => User::all()->random()->id
        ];
    }
}
