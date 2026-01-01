<?php

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Kernel;

it('schedules the publish scheduled command', function () {
    $schedule = app(Schedule::class);
    $kernel = app(Kernel::class);

    // Populate schedule events (use reflection to call protected method)
    $method = new \ReflectionMethod(Kernel::class, 'schedule');
    $method->setAccessible(true);
    $method->invoke($kernel, $schedule);

    $events = $schedule->events();

    $found = false;
    foreach ($events as $event) {
        $summary = $event->getSummaryForDisplay();
        if (strpos($summary, 'contents:publish-scheduled') !== false) {
            $found = true;
            break;
        }
    }

    expect($found)->toBeTrue();
});
