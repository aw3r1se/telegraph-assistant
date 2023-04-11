<?php

namespace Aw3r1se\TelegraphAssistant\Http\Webhooks;

use Illuminate\Support\Stringable;

class WebhookHandler extends BaseWebhookHandler
{
    /**
     * @param Stringable $text
     * @return void
     */
    protected function handleUnknownCommand(Stringable $text): void
    {
        $this->reply('Unknown');
    }
}
