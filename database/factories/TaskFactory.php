<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Modules\Tasks\Infrastructure\Database\Task;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Src\Modules\Tasks\Infrastructure\Database>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'status' => fake()->boolean(),
            'user_id' => 1,
        ];
    }
}
