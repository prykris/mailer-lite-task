<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ApiKeyController extends Controller
{

    public function index(): View
    {
        return view('api-key');
    }

    public function store(): RedirectResponse
    {

    }

}
