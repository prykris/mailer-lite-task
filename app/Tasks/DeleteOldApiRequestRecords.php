<?php

namespace App\Tasks;

use App\Models\ApiRequest;
use Carbon\Carbon;
use Log;
use Throwable;

/**
 * Delete old api request records and keep only those who were added since last minute ago
 */
class DeleteOldApiRequestRecords
{
    public function __invoke(): void
    {
        try {
            ApiRequest::where('created_at', '>=', Carbon::now()->subMinute())->deleteOrFail();
        } catch (Throwable $e) {
            Log::warning('Error occurred while deleting old entries from `api_requests` table', [
                'exception' => $e
            ]);
        }
    }

}
