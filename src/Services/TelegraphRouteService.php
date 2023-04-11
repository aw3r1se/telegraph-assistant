<?php

namespace Aw3r1se\TelegraphAssistant\Services;

use Aw3r1se\TelegraphAssistant\Classes\TelegraphRouter;
use Aw3r1se\TelegraphAssistant\Exceptions\IncorrectMethodWebhookHandler;
use Aw3r1se\TelegraphAssistant\Exceptions\IncorrectWebhookHandler;
use Aw3r1se\TelegraphAssistant\Exceptions\InvalidTelegraphRouteFile;
use Aw3r1se\TelegraphAssistant\Http\Webhooks\WebhookHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TelegraphRouteService
{
    protected TelegraphRouter $router;

    public function __construct(TelegraphRouter $router)
    {
        $this->router = $router;
    }

    /**
     * @throws InvalidTelegraphRouteFile
     */
    public function register(string $path): void
    {
        if ($this->router->isNotEmpty()) {
            return;
        }

        if (!Storage::exists($path)) {
            return;
        }

        try {
            include_once $path;
        } catch (\Throwable) {
            throw new InvalidTelegraphRouteFile();
        }
    }

    /**
     * @param string $command
     * @param string $arguments
     * @return void
     */
    public function forward(string $command, string $arguments): void
    {
        Log::debug('test');

        $route = $this->router->findByCommand($command);
        $handler = $route->getHandler();
        $method = $route->getMethod();

//        $method
//            ? app($handler)->$method($arguments)
//            : app()->call($handler);
    }

    public function middleware(): static
    {
        //TODO заебашить смачного посредника

        return $this;
    }

    /**
     * @param string $command
     * @param array|string $action
     * @return void
     * @throws IncorrectMethodWebhookHandler
     * @throws IncorrectWebhookHandler
     */
    public function handle(string $command, mixed $action): void
    {
        $handler = is_array($action)
            ? $action[0]
            : $action;

        $method = is_array($action)
            ? $action[1]
            : null;

        if (!is_subclass_of($handler, WebhookHandler::class)) {
            throw new IncorrectWebhookHandler();
        }

        if ($method && !method_exists($handler, $method)) {
            throw new IncorrectMethodWebhookHandler();
        }

        $this->router->add($command, $handler, $method);
    }
}
