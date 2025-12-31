<?php

namespace Database\Factories;

use App\Models\Content;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContentFactory extends Factory
{
    protected $model = Content::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['post', 'note', 'video', 'tutorial']),
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraphs(3, true),
            'status' => 'draft',
            'visibility' => 'public',
            'publish_at' => null,
        ];
    }
}
