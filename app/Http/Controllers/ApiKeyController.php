<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiKeyRequest;
use App\Models\ApiKey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ApiKeyController extends Controller
{

    public function index(): View
    {
        return view('api-key');
    }

    public function store(ApiKeyRequest $request): RedirectResponse
    {
        // Prioritize text input for arbitrary reasons
        $apiKey = $request->get('api-key-raw') ?? file_get_contents($request->file('api-key-file')->getRealPath());

        $apiKeyModel = ApiKey::firstOrCreate(['api_key' => $apiKey]);

        Session::put('visitor_uuid', $apiKeyModel->visitor_uuid);

        return redirect('subscribers');
    }

}
