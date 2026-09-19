<?php

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

pest()->use(RefreshDatabase::class);

test('authenticated user can create category', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->postJson('/api/categories', [
        'name' => 'Backend Development',
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.name', 'Backend Development');

    $this->assertDatabaseHas('categories', [
        'user_id' => $user->id,
        'name' => 'Backend Development',
    ]);
});

test('category name is required', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->postJson('/api/categories', [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['name']);
});

test('authenticated user can list own categories', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    Category::factory()->count(2)->for($user)->create();
    Category::factory()->count(4)->for($other)->create();

    Sanctum::actingAs($user);

    $this->getJson('/api/categories')
        ->assertOk()
        ->assertJsonCount(2, 'data');
});

test('task can belong to category', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $category = Category::factory()->for($user)->create(['name' => 'Software Engineering']);

    $response = $this->postJson('/api/tasks', [
        'title' => 'Complete Lab 04',
        'category_id' => $category->id,
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.category_id', $category->id);

    $this->assertDatabaseHas('tasks', [
        'user_id' => $user->id,
        'title' => 'Complete Lab 04',
        'category_id' => $category->id,
    ]);
});

test('invalid category id rejected', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $this->postJson('/api/tasks', [
        'title' => 'Task with invalid category',
        'category_id' => 999999,
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['category_id']);
});

test('user cannot assign another users category', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $otherCategory = Category::factory()->for($other)->create();

    Sanctum::actingAs($user);

    $this->postJson('/api/tasks', [
        'title' => 'Trying to use others category',
        'category_id' => $otherCategory->id,
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['category_id']);
});
