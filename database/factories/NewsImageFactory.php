<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsImage>
 */
class NewsImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $news_IDs = News::pluck('id');
        return [
            'news_id' => fake()->randomElement($news_IDs),
            'url' => 'News/news.jpeg'
        ];
    }
}
