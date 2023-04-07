<?php

namespace App\Http\Middleware;

use App\Services\MailerLiteService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Protected routes if api key is not present
 */
class EnsureApiKeyIsSet
{
    public function __construct(private readonly MailerLiteService $mailerLiteService)
    {
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (false === $this->mailerLiteService->ready()) {
            redirect(route('api-key'));
        }

        return $next($request);
    }

}
