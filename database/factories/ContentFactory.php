<?php

namespace Database\Factories;

use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Content::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'release_date' => $this->faker->date(),
            'content_type' => $this->faker->randomElement(['movie','tv_show','short_film','mini_tv_show']),
            'genre'  => '{"genre1": "' . $this->faker->word . '", "genre2": "' . $this->faker->word . '"}',
            'tags'  => '{"tag1": "' . $this->faker->word . '", "tag2": "' . $this->faker->word . '"}',
            'runtime' => $this->faker->numberBetween(1,200),
            'short_description' =>  $this->faker->text,
            'cast'  => '{"starring1": "' . $this->faker->name . '", "starring2": "' . $this->faker->name . '"}',
            'directors' => '{"director1": "' . $this->faker->name . '", "director2": "' . $this->faker->name . '"}',
            'age_restriction' => $this->faker->randomElement(['0','6','12','16','18']),
            'poster_url' =>  $this->faker->url,
            'youtube_trailer_url' =>  $this->faker->url,
            'production_company' => $this->faker->company,
            'seasons' => $this->faker->numberBetween(1,50),
            'average_episode_count' => $this->faker->numberBetween(1, 30),
        ];
    }
}
