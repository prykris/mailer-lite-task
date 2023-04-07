<?php

namespace App\Listeners;

use App\Events\ApiRequestSent;
use App\Models\ApiRequest;

class CountApiRequest
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ApiRequestSent $event): void
    {
        ApiRequest::create(['api_key' => $event->apiKey])->save();
    }

}
