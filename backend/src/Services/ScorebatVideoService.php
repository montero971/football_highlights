<?php

declare(strict_types=1);

namespace App\Services;

use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ScorebatVideoService
{
    const API_URL = 'https://www.scorebat.com/video-api/v3/feed/?token=';
    const CACHE_TTL = 3600;

    public function __construct(
        private HttpClientInterface $httpClientInterface,
        private RedisAdapter $redisCache,
        private string $apiAccessToken,
        private string $cacheKey,
        private LoggerInterface $logger
    ) {
        $this->httpClientInterface = $httpClientInterface;
        $this->redisCache = $redisCache;
        $this->apiAccessToken = $apiAccessToken;
        $this->cacheKey = $cacheKey;
        $this->logger = $logger;
    }

    public function getRecentFeed()
    {
        try {
            $cachedData = $this->redisCache->getItem($this->cacheKey)->get();

            if (!is_null($cachedData)) {
                return $cachedData;
            }

            $responseData = $this->httpClientInterface->request(
                'GET',
                self::API_URL . $this->apiAccessToken
            )->toArray();

            $filteredData = array_map(function ($item) {
                return [
                    'title' => $item['title'],
                    'competition' => $item['competition'],
                    'videos' => [
                        'embed' => $item['videos'][0]['embed']
                    ]
                ];
            }, $responseData['response']);

            $cacheItem = $this->redisCache->getItem($this->cacheKey)->set($filteredData)->expiresAfter(self::CACHE_TTL);
            $this->redisCache->save($cacheItem);

            return $filteredData;
        } catch (ClientException $e) {
            $this->logger->error('Error during HTTP request: ' . $e->getMessage(), ['exception' => $e]);
            throw $e;
        }
    }
}
