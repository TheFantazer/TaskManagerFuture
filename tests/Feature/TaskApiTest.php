<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_task(): void
    {
        $payload = [
            'title' => 'Test Task',
            'description' => 'This is a test task.',
            'due_date' => '2025-01-25T18:00:00',
            'create_date' => '2025-01-20T18:00:00',
            'status' => 'не выполнена',
            'priority' => 'средний',
            'category' => 'Работа',
        ];

        $response = $this->postJson('/api/tasks', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'message']);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
        ]);
    }

    /** @test */
    public function it_can_list_tasks(): void
    {
        Task::factory()->create(['title' => 'Task A', 'due_date' => now()->addDays(1)]);
        Task::factory()->create(['title' => 'Task B', 'due_date' => now()->addDays(2)]);

        $response = $this->getJson('/api/tasks?sort=due_date');

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Task A'])
            ->assertJsonFragment(['title' => 'Task B']);
    }

    /** @test */
    public function it_can_show_a_single_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(['id' => $task->id, 'title' => $task->title]);
    }

    /** @test */
    public function it_can_update_a_task(): void
    {
        $task = Task::factory()->create(['title' => 'Old Title']);

        $payload = ['title' => 'Updated Title'];

        $response = $this->putJson("/api/tasks/{$task->id}", $payload);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Task updated successfully']);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
        ]);
    }

    /** @test */
    public function it_can_delete_a_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Task deleted successfully']);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
