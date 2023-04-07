<?php

namespace App\Http\Middleware;

use App\Services\MailerLiteService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Read saved API Key for current visitor otherwise redirect to input page
 */
class RestoreApiKey
{

    public function __construct(private readonly ?MailerLiteService $mailerLiteService)
    {
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentApiKey = $this->mailerLiteService->readApiKeyForCurrentUser();

        if ($currentApiKey) {
            $this->mailerLiteService->setApiKey($currentApiKey->api_key);
        }

        return $next($request);
    }

}
