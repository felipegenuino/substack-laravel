<?php

namespace App\Console\Commands;

use App\Models\Content;
use Illuminate\Console\Command;

class PublishScheduledContents extends Command
{
    protected $signature = 'contents:publish-scheduled';

    protected $description = 'Publish scheduled contents whose publish_at <= now and status is draft';

    public function handle()
    {
        $contents = Content::where('status', 'draft')
            ->whereNotNull('publish_at')
            ->where('publish_at', '<=', now())
            ->get();

        foreach ($contents as $content) {
            $content->status = 'published';
            $content->save();
            $this->info("Published content: {$content->id}");
        }

        return 0;
    }
}
