<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubscriber;
use App\Http\Requests\DeleteSubscriber;
use App\Http\Requests\UpdateSubscriber;
use App\Services\MailerLiteService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SubscriberDataController extends Controller
{

    public function __construct(protected MailerLiteService $mailerLiteService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $response = $this->mailerLiteService->getSubscribers(
            limit: (int)$request->get('length')
        );

        $totalSubscribers = $this->mailerLiteService->getTotalSubscribers()['total'] ?? 0;

        if (null === $response) {
            return new JsonResponse([
                'draw' => $request->get('draw'),
                'error' => $this->mailerLiteService->ready()
                    ? 'Error occurred while sending api request, check logs'
                    : 'The API key is missing'
            ]);
        }

        /**
         * Just so you know, this is terrible idea! Your api and datatables are not compatible without horrible hacks
         */
        $search = $request->get('search');

        if (!empty($search['value'])) {
            $needle = strtolower(trim($search['value']));

            $response['data'] = array_filter($response['data'], function (array $row) use ($needle) {
                return str_contains($row['email'], $needle);
            });
        }

        return new JsonResponse([
            'draw' => $request->get('draw'),
            'recordsTotal' => $totalSubscribers,
            'recordsFiltered' => $totalSubscribers,
            ...$response
        ]);
    }

    public function delete(DeleteSubscriber $request): JsonResponse
    {
        return new JsonResponse($this->mailerLiteService->deleteSubscriber(
            id: $request->get('id')
        ));
    }

    public function create(CreateSubscriber $request): JsonResponse
    {
        return new JsonResponse($this->mailerLiteService->createSubscriber(
            email: $request->request->get('email'),
            fields: [
                'country' => $request->get('country')
            ]
        ));
    }

    public function update(UpdateSubscriber $request): JsonResponse
    {
        return new JsonResponse($this->mailerLiteService->updateSubscriber(
            id: $request->get('id'),
            fields: [
                'name' => $request->get('name'),
                'country' => $request->get('country')
            ]
        ));
    }

}
