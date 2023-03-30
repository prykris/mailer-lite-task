<?php

namespace App\Services;

use DateTimeInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\App;

class MailerLiteService
{

    private readonly Client $client;

    public function __construct(private readonly string $apiKey)
    {
        $this->client = new Client([
            'base_uri' => 'https://connect.mailerlite.com/api/',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $this->apiKey",
            ],
            'curl' => App::environment('development', 'local')
                ? [
                    CURLOPT_SSL_VERIFYPEER => false
                ]
                : []
        ]);
    }

    private function request(string $method, string $path, array $parameters = []): array
    {
        try {
            $response = $this->client->get($method, [
                'json' => $this->prepareParameters($parameters)
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            return [];
        }
    }

    private function prepareParameters(array $parameters): array
    {
        return collect($parameters)->map(function ($value) {
            if ($value instanceof DateTimeInterface) {
                return $value->format('y-m-d H:m:s');
            }

            return $value;
        })->toArray();
    }

    /**
     * @param string|null $filter Must be one of the possible statuses: active, unsubscribed, unconfirmed, bounced or junk.
     * @param int|null $limit Defaults to 25
     * @param string|null $cursor Defaults to first page. Cursor value available in response body
     * @return array
     */
    public function getSubscribers(?string $filter = null, ?int $limit = null, ?string $cursor = null): array
    {
        return $this->request('get', 'subscribers', func_get_args());
    }

    /**
     * @param string $email Valid email address as per RFC 2821
     * @param array $fields Object keys must correspond to default or custom field name. Values can only be added this way and will not be removed by omission.
     * @param array $groups array must contain existing group ids. Subscriber can only be added for groups this way and will not be removed by omission
     * @param string $status Can be one of the following: active, unsubscribed, unconfirmed, bounced, junk
     * @param DateTimeInterface $subscribedAt
     * @param string $ipAddress Must be a valid ip address
     * @param DateTimeInterface $opted_in_at Must be a valid date in the format yyyy-MM-dd HH:mm:ss
     * @param string $optinIp Must be a valid ip address
     * @param DateTimeInterface $unsubscribedAt Must be a valid date in the format yyyy-MM-dd HH:mm:ss
     * @return array
     */
    public function createSubscriber(string            $email,
                                     array             $fields,
                                     array             $groups,
                                     string            $status,
                                     DateTimeInterface $subscribedAt,
                                     string            $ipAddress,
                                     DateTimeInterface $opted_in_at,
                                     string            $optinIp,
                                     DateTimeInterface $unsubscribedAt): array
    {
        return $this->request('post', 'subscribers', func_get_args());
    }

}
