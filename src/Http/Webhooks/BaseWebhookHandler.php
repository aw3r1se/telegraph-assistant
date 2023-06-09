<?php

namespace Aw3r1se\TelegraphAssistant\Http\Webhooks;

use Illuminate\Support\Stringable;

class BaseWebhookHandler extends WebhookHandler
{
    /**
     * @param Stringable $text
     * @return void
     */
    protected function handleUnknownCommand(Stringable $text): void
    {
        $this->reply("I can't understand your command: $text");
    }
}
