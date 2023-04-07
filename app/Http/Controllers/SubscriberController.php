<?php

namespace App\Http\Controllers;

use App\Services\MailerLiteService;
use Illuminate\View\View;

class SubscriberController extends Controller
{

    public function __construct(protected MailerLiteService $mailerLiteService)
    {
    }

    public function index(): View
    {
        return view('subscribers');
    }

}
