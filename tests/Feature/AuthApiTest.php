<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

pest()->use(RefreshDatabase::class);

test('user can register via api and receives token', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Ahmed Student',
        'email' => 'ahmed@example.com',
        'password' => 'password123',
    ]);

    $response->assertCreated()
        ->assertJsonStructure(['message', 'user' => ['id', 'name', 'email'], 'token']);

    $this->assertDatabaseHas('users', ['email' => 'ahmed@example.com']);
});

test('user cannot register with duplicate email', function () {
    User::factory()->create(['email' => 'duplicate@example.com']);

    $this->postJson('/api/register', [
        'name' => 'Second Student',
        'email' => 'duplicate@example.com',
        'password' => 'password123',
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});

test('user can login with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'developer@example.com',
        'password' => Hash::make('secret123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'developer@example.com',
        'password' => 'secret123',
    ]);

    $response->assertOk()
        ->assertJsonStructure(['message', 'user', 'token']);
});

test('user cannot login with invalid credentials', function () {
    User::factory()->create([
        'email' => 'developer@example.com',
        'password' => Hash::make('secret123'),
    ]);

    $this->postJson('/api/login', [
        'email' => 'developer@example.com',
        'password' => 'wrong-password',
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});

test('authenticated user can view profile via me endpoint', function () {
    $user = User::factory()->create(['name' => 'Salim Dev']);
    Sanctum::actingAs($user);

    $this->getJson('/api/me')
        ->assertOk()
        ->assertJsonPath('data.name', 'Salim Dev')
        ->assertJsonPath('data.email', $user->email);
});

test('authenticated user can logout and revoke token', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test_token')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/logout');

    $response->assertOk()
        ->assertJsonPath('message', 'Logged out successfully');

    expect($user->tokens()->count())->toBe(0);
});
