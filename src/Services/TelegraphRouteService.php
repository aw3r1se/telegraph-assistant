<?php

namespace Aw3r1se\TelegraphAssistant\Services;

use Aw3r1se\TelegraphAssistant\Classes\TelegraphRouter;
use Aw3r1se\TelegraphAssistant\Exceptions\IncorrectMethodWebhookHandler;
use Aw3r1se\TelegraphAssistant\Exceptions\IncorrectWebhookHandler;
use Aw3r1se\TelegraphAssistant\Exceptions\InvalidTelegraphRouteFile;
use Aw3r1se\TelegraphAssistant\Http\Webhooks\WebhookHandler;

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

        try {
            include_once $path;
        } catch (\Throwable) {
            throw new InvalidTelegraphRouteFile();
        }
    }

    /**
     * @param string $command
     * @param array $arguments
     * @return void
     */
    public function forward(string $command, array $arguments): void
    {
        $route = $this->router->findByCommand($command);
        $method = $route->getMethod();
        app($route->getHandler())->$method($arguments);
    }

    public function middleware(): static
    {
        //TODO заебашить смачного посредника

        return $this;
    }

    /**
     * @param string $command
     * @param array<string> $action
     * @return void
     * @throws IncorrectMethodWebhookHandler
     * @throws IncorrectWebhookHandler
     */
    public function handle(string $command, array $action): void
    {
        if (!is_subclass_of($action[0], WebhookHandler::class)) {
            throw new IncorrectWebhookHandler();
        }

        if (!method_exists($action[0], $action[1])) {
            throw new IncorrectMethodWebhookHandler();
        }

        $this->router->add($command, $action[0], $action[1]);
    }
}
