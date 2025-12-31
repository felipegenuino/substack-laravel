<?php

use App\Models\User;
use App\Http\Livewire\Editor;
use Livewire\Livewire;

it('saves a new draft content to the database', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(Editor::class)
        ->set('title', 'My post')
        ->set('content', 'Hello world')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('contents', [
        'title' => 'My post',
        'body' => 'Hello world',
        'status' => 'draft',
        'user_id' => $user->id,
    ]);
});
