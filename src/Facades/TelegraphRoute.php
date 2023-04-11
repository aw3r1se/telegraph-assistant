<?php

namespace Aw3r1se\TelegraphAssistant\Facades;

use Aw3r1se\TelegraphAssistant\Services\TelegraphRouteService;
use Illuminate\Support\Facades\Facade;

/**
 * @TelegraphRoute
 * @method static void register(string $path)
 * @method static void forward(string $command, array $arguments)
 * @method static static middleware(string $constraint)
 * @method void handle(string $command, mixed $action = null)
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
