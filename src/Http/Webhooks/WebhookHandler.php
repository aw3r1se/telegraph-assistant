<?php

namespace Aw3r1se\TelegraphAssistant\Http\Webhooks;

use Aw3r1se\TelegraphAssistant\Facades\TelegraphRoute;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;
use ReflectionException;
use ReflectionMethod;

class WebhookHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    /**
     * @throws ReflectionException
     */
    private function handleCommand(Stringable $text): void
    {
        Log::debug('handled');

        $command = (string) $text->after('/')->before(' ')->before('@');
        $parameter = (string) $text->after('@')->after(' ');

        if (!$this->canHandle($command)) {
            $this->handleUnknownCommand($text);

            return;
        }

        TelegraphRoute::forward($command, $parameter);
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
