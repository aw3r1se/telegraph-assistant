<?php

namespace Aw3r1se\TelegraphAssistant\Example;

use Aw3r1se\TelegraphAssistant\Http\Webhooks\WebhookHandler;

class ExampleWebhookHandler extends WebhookHandler
{
    /**
     * @return void
     */
    public function execHi(): void
    {
        $this->reply('Hi!');
    }
}
