<?php

use App\Models\User;
use App\Http\Livewire\Editor;
use Livewire\Livewire;
use App\Models\Content;

it('saves scheduled publish in the future as draft with publish_at set', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $future = now()->addDay()->format('Y-m-d\TH:i');

    Livewire::test(Editor::class)
        ->set('title', 'Scheduled Post')
        ->set('content', 'Scheduled content')
        ->set('publish_at', $future)
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('contents', [
        'title' => 'Scheduled Post',
        'status' => 'draft',
    ]);
});

it('publishes immediately if publish_at is now or past', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $past = now()->subMinute()->format('Y-m-d\TH:i');

    Livewire::test(Editor::class)
        ->set('title', 'Immediate Post')
        ->set('content', 'Now content')
        ->set('publish_at', $past)
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('contents', [
        'title' => 'Immediate Post',
        'status' => 'published',
    ]);
});
