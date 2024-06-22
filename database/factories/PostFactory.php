<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->realTextBetween(6, 40),
            'content' => $this->faker->realTextBetween(50, 200),
            'image' => fake()->imageUrl,
        //            'author_id' => RoleUser::whereIn('role_id', function ($query){
        //                $query->select('id')
        //                    ->from(with(new Role)->getTable())
        //                    ->where('name', 'author');
        //            })->get()->random()->user_id,
            'author_id' => User::get()->random()->id,
        ];
    }
}
