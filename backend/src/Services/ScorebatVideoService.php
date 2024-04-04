<?php

declare(strict_types=1);

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ScorebatVideoService
{
    const API_URL = 'https://www.scorebat.com/video-api/v3/feed/?token=';

    public function __construct(
        private HttpClientInterface $httpClientInterface,
        private string $apiAccessToken
    ) {
        $this->httpClientInterface = $httpClientInterface;
        $this->apiAccessToken = $apiAccessToken;
    }

    public function getRecentFeed()
    {
        return $this->httpClientInterface->request(
            'GET',
            self::API_URL . $this->apiAccessToken
        )->toArray();
    }
}
