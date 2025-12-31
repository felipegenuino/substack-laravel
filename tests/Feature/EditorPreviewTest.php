<?php

use App\Models\User;
use App\Http\Livewire\Editor;
use Livewire\Livewire;

it('renders markdown preview when content changes', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(Editor::class)
        ->set('content', '# Hello **World**')
        ->call('renderPreview')
        ->assertSeeHtml('<h1>Hello <strong>World</strong></h1>');
});
