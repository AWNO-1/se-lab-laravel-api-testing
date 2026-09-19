<?php

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

pest()->use(RefreshDatabase::class);

test('guest cannot access tasks', function () {
    $this->getJson('/api/tasks')->assertUnauthorized();
});

test('user can list own tasks', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    Task::factory()->count(3)->for($user)->create();
    Task::factory()->count(5)->for($other)->create();
    Sanctum::actingAs($user);

    $this->getJson('/api/tasks')
        ->assertOk()
        ->assertJsonCount(3, 'data');
});

test('user can create a task', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->postJson('/api/tasks', [
        'title' => 'Study Laravel API',
        'description' => 'Learn Feature Testing',
        'status' => 'pending',
        'due_date' => '2026-09-10',
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.title', 'Study Laravel API')
        ->assertJsonPath('data.status', 'pending');

    $this->assertDatabaseHas('tasks', [
        'user_id' => $user->id,
        'title' => 'Study Laravel API',
        'status' => 'pending',
    ]);
});

test('title is required', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->postJson('/api/tasks', ['status' => 'pending'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['title']);
});

test('status must be valid', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->postJson('/api/tasks', ['title' => 'Valid Title', 'status' => 'wrong_status'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['status']);
});

test('user can view own task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->for($user)->create(['title' => 'Laravel Lecture']);
    Sanctum::actingAs($user);

    $this->getJson("/api/tasks/{$task->id}")
        ->assertOk()
        ->assertJsonPath('data.id', $task->id)
        ->assertJsonPath('data.title', 'Laravel Lecture');
});

test('missing task returns 404', function () {
    Sanctum::actingAs(User::factory()->create());
    $this->getJson('/api/tasks/999999')->assertNotFound();
});

test('user cannot view another users task', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $task = Task::factory()->for($other)->create();
    Sanctum::actingAs($user);

    $this->getJson("/api/tasks/{$task->id}")->assertForbidden();
});

test('user can update own task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->for($user)->create(['status' => 'pending']);
    Sanctum::actingAs($user);

    $this->patchJson("/api/tasks/{$task->id}", ['status' => 'completed'])
        ->assertOk()
        ->assertJsonPath('data.status', 'completed');

    $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'completed']);
});

test('user cannot update another users task', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $task = Task::factory()->for($other)->create(['status' => 'pending']);
    Sanctum::actingAs($user);

    $this->patchJson("/api/tasks/{$task->id}", ['status' => 'completed'])
        ->assertForbidden();

    expect($task->fresh()->status)->toBe('pending');
});

test('user can delete own task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->for($user)->create();
    Sanctum::actingAs($user);

    $this->deleteJson("/api/tasks/{$task->id}")->assertNoContent();
    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});

test('tasks can be filtered by status', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    Task::factory()->count(3)->for($user)->create(['status' => 'pending']);
    Task::factory()->count(2)->for($user)->create(['status' => 'completed']);

    $this->getJson('/api/tasks?status=completed')
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonPath('data.0.status', 'completed');
});

test('tasks can be filtered by category', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $category1 = Category::factory()->for($user)->create(['name' => 'Backend']);
    $category2 = Category::factory()->for($user)->create(['name' => 'Design']);

    Task::factory()->count(3)->for($user)->create(['category_id' => $category1->id]);
    Task::factory()->count(2)->for($user)->create(['category_id' => $category2->id]);

    $this->getJson("/api/tasks?category_id={$category1->id}")
        ->assertOk()
        ->assertJsonCount(3, 'data')
        ->assertJsonPath('data.0.category_id', $category1->id);
});

test('tasks can be searched', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    Task::factory()->for($user)->create(['title' => 'Learn Laravel']);
    Task::factory()->for($user)->create(['title' => 'Learn Flutter']);

    $this->getJson('/api/tasks?search=Laravel')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.title', 'Learn Laravel');
});

test('tasks are paginated', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    Task::factory()->count(15)->for($user)->create();

    $this->getJson('/api/tasks')
        ->assertOk()
        ->assertJsonCount(10, 'data')
        ->assertJsonStructure(['data', 'links', 'meta']);
});

test('user can mark task as complete via bonus endpoint', function () {
    $user = User::factory()->create();
    $task = Task::factory()->for($user)->create([
        'status' => 'pending',
        'is_completed' => false,
    ]);
    Sanctum::actingAs($user);

    $response = $this->patchJson("/api/tasks/{$task->id}/complete");

    $response->assertOk()
        ->assertJsonPath('data.is_completed', true)
        ->assertJsonPath('data.status', 'completed');

    expect($task->fresh()->is_completed)->toBeTrue()
        ->and($task->fresh()->status)->toBe('completed');
});

test('user cannot mark another users task as complete', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $task = Task::factory()->for($other)->create([
        'status' => 'pending',
        'is_completed' => false,
    ]);
    Sanctum::actingAs($user);

    $this->patchJson("/api/tasks/{$task->id}/complete")->assertForbidden();

    expect($task->fresh()->is_completed)->toBeFalse();
});
