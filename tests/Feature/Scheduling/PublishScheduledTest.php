<?php

use App\Models\Content;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

it('publishes scheduled contents when the command runs', function () {
    $user = User::factory()->create();

    $scheduled = Content::factory()->create([
        'user_id' => $user->id,
        'status' => 'draft',
        'publish_at' => now()->subMinute(),
    ]);

    // Run the command that should publish scheduled contents
    Artisan::call('contents:publish-scheduled');

    $this->assertDatabaseHas('contents', [
        'id' => $scheduled->id,
        'status' => 'published',
    ]);
});
