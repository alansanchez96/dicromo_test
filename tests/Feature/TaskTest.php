<?php

namespace Tests\Feature;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Modules\Tasks\Infrastructure\Database\Task;
use Src\Modules\Auth\Infrastructure\Database\AuthDB;

class TaskTest extends TestCase
{
    // use RefreshDatabase;

    #[Test]
    public function a_user_can_create_a_task()
    {
        $auth = AuthDB::factory()->create();

        $token = auth()->guard()->login($auth);

        $payload = [
            "name" => "nueva tarea",
            "description" => "descr",
            "status" => true
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/tasks', $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tasks', $payload);

        $response->assertJsonStructure([
            'message',
            'data' => [
                'userId',
                'name',
                'status',
                'description'
            ]
        ]);
    }

    #[Test]
    public function a_user_consults_his_tasks()
    {
        $auth = AuthDB::factory()->create();
        $tasks = Task::factory(5)->create(['user_id' => $auth->_id]);
        $token = auth()->guard()->login($auth);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get(sprintf('/api/tasks?user_id=%s', $auth->_id));


        $response->assertOk();

        $response->assertJsonStructure([
            'message',
            'data' => [
                ['userId', 'name', 'description', 'status']
            ]
        ]);

        $response->assertJsonCount(5, 'data');

        $response->assertJsonFragment([
            'message' => 'Se ha obtenido correctamente.'
        ]);
    }

    #[Test]
    public function a_user_update_one_task()
    {
        $auth = AuthDB::factory()->create();
        $token = auth()->guard()->login($auth);

        $tasks = Task::factory(5)->create(['user_id' => $auth->_id]);
        $name = 'nueva tarea';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put(sprintf('/api/tasks/%s?user_id=%s', $tasks->first()->_id, $auth->_id), [
            'name' => $name,
            'description' => $name,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tasks', [
            'name' => $name,
            'description' => $name,
        ]);
        
        $response->assertJsonStructure([
            'message',
            'data' => [
                'id', 'userId', 'name', 'description', 'status'
            ]
        ]);

        $response->assertJsonFragment([
            'message' => 'Se ha actualizado correctamente.'
        ]);
    }

    #[Test]
    public function a_user_delete_one_task()
    {
        $this->withoutExceptionHandling();

        $auth = AuthDB::factory()->create();
        $token = auth()->guard()->login($auth);

        $name = 'tarea que se debe eliminar';
        $task = Task::factory()->create(['name' => $name, 'user_id' => $auth->_id]);

        $this->assertDatabaseHas('tasks', ['name' => $name]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete(sprintf('/api/tasks/%s?user_id=%s', $task->_id, $auth->_id));

        $response->assertStatus(201);

        $this->assertDatabaseMissing('tasks', ['_id' => $task->id]);
        
        $response->assertExactJsonStructure(['message']);

        $response->assertJsonFragment([
            'message' => 'Se ha eliminado correctamente.'
        ]);
    }
}
