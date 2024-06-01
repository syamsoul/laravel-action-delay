<?php

namespace SoulDoit\ActionDelay\Providers;
 
use Illuminate\Support\ServiceProvider;
use SoulDoit\ActionDelay\Commands\ActionDelayCommand;
 
final class ActionDelayServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->commands(
            commands: [
                ActionDelayCommand::class,
            ],
        );
    }
}