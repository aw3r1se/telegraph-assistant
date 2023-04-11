<?php

namespace Aw3r1se\TelegraphAssistant\Http\Webhooks;

use Aw3r1se\TelegraphAssistant\Facades\TelegraphRoute;

abstract class WebhookHandler
{
    /**
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public function __call(string $name, array $arguments)
    {
        TelegraphRoute::forward($name, ...$arguments);
    }
}
