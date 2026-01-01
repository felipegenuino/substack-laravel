<?php

namespace Tests\Feature\UI;

use Tests\TestCase;
use Livewire\Livewire;

class CommandPaletteTest extends TestCase
{
    public function test_can_toggle_command_palette()
    {
        Livewire::test('command-palette')
            ->call('open')
            ->assertSet('open', true)
            ->call('close')
            ->assertSet('open', false);
    }

    public function test_run_redirects()
    {
        $this->withoutExceptionHandling();

        $test = Livewire::test('command-palette')
            ->call('run', 'dashboard');

        // run should redirect to /dashboard
        $test->assertRedirect('/dashboard');
    }
}
