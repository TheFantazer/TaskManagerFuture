<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'create_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'status' => $this->faker->randomElement(['выполнена', 'не выполнена']),
            'priority' => $this->faker->randomElement(['низкий', 'средний', 'высокий']),
            'category' => $this->faker->randomElement(['Работа', 'Дом', 'Личное']),
        ];
    }
}
