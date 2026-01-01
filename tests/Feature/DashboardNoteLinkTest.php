<?php

use App\Models\User;

it('dashboard shows link to create a new note for authenticated users', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertStatus(200);
    $response->assertSee('Nova Nota');
    $response->assertSee(route('notes.new'));
});
