<?php

use App\Models\User;

it('shows a link to create a new note on the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get(route('dashboard'))
        ->assertStatus(200)
        ->assertSee('Nova Note');
});
