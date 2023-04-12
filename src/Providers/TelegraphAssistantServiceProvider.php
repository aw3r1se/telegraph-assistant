<?php

namespace Aw3r1se\TelegraphAssistant\Providers;

use Aw3r1se\TelegraphAssistant\Classes\TelegraphRouter;
use Aw3r1se\TelegraphAssistant\Console\Commands\MakeWebhookHandler;
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

            $this->publishes([
                __DIR__ . '/../Http/Webhooks/stubs/BaseWebhookHandler.stub' =>
                    app_path('Http/Webhooks/BaseWebhookHandler.php')
            ], 'handlers');

            $this->publishes([
                __DIR__ . '/../../config/telegraph_assistant.php' =>
                    config_path('telegraph_assistant.php'),
            ], 'config');
        }

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/telegraph_assistant.php',
            'telegraph_assistant',
        );

        $this->commands([
           MakeWebhookHandler::class,
        ]);

        $this->app->singleton(TelegraphRouter::class);
        TelegraphRoute::register(config('telegraph_assistant.route_path'));
    }
}
