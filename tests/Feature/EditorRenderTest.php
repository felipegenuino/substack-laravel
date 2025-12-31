<?php

use App\Models\User;
use App\Http\Livewire\Editor;
use Livewire\Livewire;

it('mounts the editor component', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(Editor::class)
        ->assertSee('textarea')
        ->assertSee('Preview');
});
