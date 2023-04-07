<?php

namespace App\Http\Controllers;

use App\Models\ApiRequest;
use App\Services\MailerLiteService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiRequestController extends Controller
{
    /**
     * Returns number of requests made in the last minute
     *
     * @param MailerLiteService $mailerLiteService
     * @param Request $request
     * @return JsonResponse
     */
    public function index(MailerLiteService $mailerLiteService, Request $request): JsonResponse
    {
        return new JsonResponse([
            'count' => $mailerLiteService->ready()

                ? ApiRequest::whereApiKey($mailerLiteService->getApiKey())
                    ->where('created_at', '>=', Carbon::now()->subMinutes(
                        (int)$request->get('minutes', 1)
                    ))
                    ->count()

                // Fallback to zero when no api key is present
                : 0
        ]);
    }

}
