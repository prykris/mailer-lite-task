<?php

namespace App\Http\Controllers;

use App\Services\MailerLiteService;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubscriberController extends Controller
{

    public function __construct(protected ?MailerLiteService $mailerLiteService)
    {
//        Session::put('test', new DateTime());
    }

    public function index(): JsonResponse
    {
        dd(Session::all());
    }

}
