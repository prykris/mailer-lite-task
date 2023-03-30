<?php

namespace App\Http\Middleware;

use App\Services\MailerLiteService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApiKeyIsSet
{

    public function __construct(private readonly ?MailerLiteService $mailerLiteService)
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (null === $this->mailerLiteService) {
            redirect('api-key');
        }

        return $next($request);
    }
}
