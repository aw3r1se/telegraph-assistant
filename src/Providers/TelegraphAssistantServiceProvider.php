<?php

namespace Aw3r1se\TelegraphAssistant\Providers;

use Aw3r1se\TelegraphAssistant\Facades\TelegraphRoute;
use Illuminate\Support\ServiceProvider;

class TelegraphAssistantServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../routes/telegraph.php' =>
                    base_path('routes/telegraph.php'),
            ], 'routes');
        }

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/telegraph_assistant.php',
            'telegraph_assistant',
        );

        TelegraphRoute::register(config('telegraph_assistant.route_path'));
    }
}
