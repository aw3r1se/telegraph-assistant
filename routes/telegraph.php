<?php

use Aw3r1se\TelegraphAssistant\Example\ExampleWebhookHandler;
use Aw3r1se\TelegraphAssistant\Facades\TelegraphRoute;

TelegraphRoute::middleware('example')->handle('Hi', [ExampleWebhookHandler::class, 'execHi']);
