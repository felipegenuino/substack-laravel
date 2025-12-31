<?php

use App\Models\User;
use App\Http\Livewire\Editor;
use Livewire\Livewire;

it('autosaves draft content to database', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(Editor::class)
        ->set('content', 'Draft autosave content')
        ->call('autosave')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('contents', [
        'body' => 'Draft autosave content',
        'status' => 'draft',
        'user_id' => $user->id,
    ]);
});
