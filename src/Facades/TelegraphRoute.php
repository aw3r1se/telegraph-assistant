<?php

namespace Aw3r1se\TelegraphAssistant\Facades;

use Aw3r1se\TelegraphAssistant\Services\TelegraphRouteService;
use Illuminate\Support\Facades\Facade;

/**
 * @TelegraphRoute
 * @method static bool hasRoute(string $command)
 * @method static void register(string $path)
 * @method static void forward(string $command, string $parameters)
 * @method static static middleware(string $constraint)
 * @method static void handle(string $command, mixed $action)
 */
class TelegraphRoute extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return TelegraphRouteService::class;
    }
}
