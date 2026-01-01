<?php

use App\Models\User;

it('shows a link to create a new note on the dashboard for authenticated users', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertStatus(200);
    $response->assertSee('Nova Note');
});
