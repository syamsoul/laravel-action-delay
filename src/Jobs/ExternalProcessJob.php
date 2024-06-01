<?php

namespace SoulDoit\ActionDelay\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Process;

class ExternalProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $command,
        private int $timeout = 600, // NOTE: in seconds
    ) {
        // $this->queue = 'high';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Process::timeout($this->timeout)->run($this->command);
    }
}
