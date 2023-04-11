<?php

namespace Aw3r1se\TelegraphAssistant\Http\Webhooks;

use Aw3r1se\TelegraphAssistant\Facades\TelegraphRoute;
use Illuminate\Support\Facades\Log;
use ReflectionException;
use ReflectionMethod;

class WebhookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    /**
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public function __call(string $name, array $arguments): void
    {
        Log::debug('call');
        TelegraphRoute::forward($name, $arguments);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public static function __callStatic(string $name, array $arguments): void
    {
        Log::debug('callStatic');
        TelegraphRoute::forward($name, $arguments);
    }

    /**
     * @param string $action
     * @return bool
     * @throws ReflectionException
     */
    protected function canHandle(string $action): bool
    {
        if ($action === 'handle') {
            return false;
        }

        $reflector = new ReflectionMethod($this::class, $action);
        if (!$reflector->isPublic()) {
            return false;
        }

        return true;
    }
}
