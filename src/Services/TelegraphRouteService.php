<?php

namespace Aw3r1se\TelegraphAssistant\Services;

use Aw3r1se\TelegraphAssistant\Classes\TelegraphRouter;
use Aw3r1se\TelegraphAssistant\Exceptions\IncorrectMethodWebhookHandler;
use Aw3r1se\TelegraphAssistant\Exceptions\InvalidTelegraphRouteFile;
use ReflectionMethod;
use Throwable;

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

        if (!file_exists($path)) {
            return;
        }

        include_once $path;
    }

    /**
     * @param string $command
     * @return bool
     */
    public function hasRoute(string $command): bool
    {
        try {
            $route = $this->router
                ->findByCommand($command);

            $reflector = new ReflectionMethod(
                $route->getHandler(),
                $route->getMethod(),
            );
            if (!$reflector->isPublic()) {
                return false;
            }
        } catch (Throwable) {
            return false;
        }

        return true;
    }

    /**
     * @param string $command
     * @param string $arguments
     * @return void
     */
    public function forward(string $command, string $arguments): void
    {
        $route = $this->router
            ->findByCommand($command);

        $handler = $route->getHandler();
        $method = $route->getMethod();

        $method
            ? app($handler)->$method($arguments)
            : app()->call($handler);
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
     */
    public function handle(string $command, mixed $action): void
    {
        $handler = is_array($action)
            ? $action[0]
            : $action;

        $method = is_array($action)
            ? $action[1]
            : null;

        if ($method && !method_exists($handler, $method)) {
            throw new IncorrectMethodWebhookHandler();
        }

        $this->router->add($command, $handler, $method);
    }
}
