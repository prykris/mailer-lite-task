<?php

namespace App\Services;

use App\Events\ApiRequestSent;
use App\Models\ApiKey;
use DateTimeInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use JsonException;

class MailerLiteService
{
    public const BASE_URI = 'https://connect.mailerlite.com/api/';

    private readonly Client $client;

    public function __construct(private ?string $apiKey)
    {
        if ($this->apiKey) {
            $this->setApiKey($apiKey);
        }
    }

    public function readApiKeyForCurrentUser(): ?ApiKey
    {
        $visitorUuid = Session::get('visitor_uuid');

        if (null === $visitorUuid) {
            return null;
        }

        $savedApiKey = ApiKey::where(['visitor_uuid' => $visitorUuid])->first();

        if (null === $savedApiKey) {
            return null;
        }

        return $savedApiKey;
    }

    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;

        $this->createClient();
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    private function createClient(): void
    {
        $this->client = new Client([
            'base_uri' => static::BASE_URI,
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

    public function ready(): bool
    {
        return isset($this->client);
    }

    /**
     * null will be returned on error and exception logged otherwise expect to receive original response
     *
     * @param string $method
     * @param string $path
     * @param array $parameters
     * @return array|null
     */
    private function request(string $method, string $path, array $parameters = []): ?array
    {
        if (false === $this->ready()) {
            return null;
        }

        $parameters = $this->prepareParameters($parameters);

        try {
            $response = $this->client->$method($path, [
                'json' => $parameters
            ]);

            $decodedResponse = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);

            ApiRequestSent::dispatch(
                $method,
                'https://connect.mailerlite.com/api/' . $path,
                $parameters,
                $decodedResponse,
                $this->apiKey
            );

            return $decodedResponse;
        } catch (GuzzleException $exception) {
            Log::error($exception->getMessage(), [
                'parameters' => $parameters
            ]);
        } catch (JsonException $exception) {
            Log::error($exception->getMessage(), [
                'parameters' => $parameters
            ]);
        }

        return null;
    }

    /**
     * Convert values to json safe format
     */
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
     * @return array [ "total" => int ]
     */
    public function getTotalSubscribers(): array
    {
        return $this->request('get', 'subscribers', ['limit' => 0]);
    }

    /**
     * @param array $filter ['status'] Must be one of the possible statuses: active, unsubscribed, unconfirmed, bounced or junk.
     * @param int|null $limit Defaults to 25
     * @param string|null $cursor Defaults to first page. Cursor value available in response body
     * @return array|null
     */
    public function getSubscribers(array $filter = [], ?int $limit = null, ?string $cursor = null): ?array
    {
        return $this->request('get', 'subscribers', get_defined_vars());
    }

    /**
     * @param string $email Valid email address as per RFC 2821
     * @param array $fields Object keys must correspond to default or custom field name. Values can only be added this way and will not be removed by omission.
     * @param array $groups array must contain existing group ids. Subscriber can only be added for groups this way and will not be removed by omission
     * @param string $status Can be one of the following: active, unsubscribed, unconfirmed, bounced, junk
     * @param DateTimeInterface|null $subscribedAt
     * @param string|null $ipAddress Must be a valid ip address
     * @param DateTimeInterface|null $opted_in_at Must be a valid date in the format yyyy-MM-dd HH:mm:ss
     * @param string|null $optinIp Must be a valid ip address
     * @param DateTimeInterface|null $unsubscribedAt Must be a valid date in the format yyyy-MM-dd HH:mm:ss
     * @return array|null
     */
    public function createSubscriber(
        string             $email,
        array              $fields = [],
        array              $groups = [],
        string             $status = 'active',
        ?DateTimeInterface $subscribedAt = null,
        string             $ipAddress = null,
        ?DateTimeInterface $opted_in_at = null,
        ?string            $optinIp = null,
        ?DateTimeInterface $unsubscribedAt = null
    ): ?array {
        return $this->request('post', 'subscribers', get_defined_vars());
    }

    /**
     * Delete subscriber by id. Returns empty response on success
     */
    public function deleteSubscriber(string $id): ?array
    {
        return $this->request('delete', "subscribers/$id");
    }

    /**
     * Similar to create subscriber
     */
    public function updateSubscriber(
        string             $id,
        array              $fields = [],
        array              $groups = [],
        string             $status = 'active',
        ?DateTimeInterface $subscribedAt = null,
        string             $ipAddress = null,
        ?DateTimeInterface $opted_in_at = null,
        ?string            $optinIp = null,
        ?DateTimeInterface $unsubscribedAt = null
    ): ?array {
        return $this->request('put', "subscribers/$id", get_defined_vars());
    }

}
