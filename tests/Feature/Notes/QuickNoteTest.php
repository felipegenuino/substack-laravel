<?php

use App\Models\User;
use App\Models\Content;
use App\Http\Livewire\QuickNote;
use Livewire\Livewire;

it('creates a quick note without title', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(QuickNote::class)
        ->set('body', 'Nota rápida sem título')
        ->call('saveNote')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('contents', [
        'body' => 'Nota rápida sem título',
        'type' => 'note',
        'status' => 'published',
        'user_id' => $user->id,
    ]);
});

it('creates a quick note with title', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(QuickNote::class)
        ->set('title', 'Minha nota')
        ->set('body', 'Conteúdo da nota')
        ->call('saveNote')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('contents', [
        'title' => 'Minha nota',
        'body' => 'Conteúdo da nota',
        'type' => 'note',
        'status' => 'published',
    ]);
});
