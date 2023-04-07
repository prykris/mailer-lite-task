<?php

namespace App\Listeners;

use App\Events\ApiRequestSent;
use Log;

class LogApiRequests
{
    /**
     * Handle the event.
     */
    public function handle(ApiRequestSent $event): void
    {
        Log::debug(strtoupper($event->method) . ': ' . $event->endpoint, [
            'parameters' => $event->parameters,
            'apiKey' => $event->apiKey,
            'response' => $event->response
        ]);
    }
}
