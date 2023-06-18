<?php

declare(strict_types=1);

namespace App\Utils;

use DateTimeImmutable;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class GeneralUtil implements GeneralUtilInterface
{
    public function __construct(
        private HttpClientInterface $carApiClient,
        private CacheInterface $cache,
        ParameterBagInterface $params,
    ) {
        $this->params = $params;
    }

    /**
     * @param $cache
     * @param $carApiClient
     *
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function getBearerToken($cache, $carApiClient)
    {
        return $cache->get('carapi_bearer_token', function (ItemInterface $item) use($carApiClient) {
            $tokenValue = GeneralUtil::callBearerToken($carApiClient);
            $tokenParts = explode(".", $tokenValue);
            $tokenPayload = base64_decode($tokenParts[1]);
            $jwtPayloadValues = json_decode($tokenPayload, true);
            $expiration = $jwtPayloadValues['exp']; // 1685321850
            $date = new DateTimeImmutable();
            $date->setTimestamp($expiration);
            $expirationDate = $date->format('Y-m-d');
            $item->expiresAt(new \DateTimeImmutable($expirationDate));
            return $tokenValue;
        });

    }

    /**
     * @return string
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function callBearerToken($carApiClient)
    {
        $bearer = $carApiClient->request('POST', '/api/auth/login', [
            'body' => [
                'api_token' => $_ENV['CAR_APT_TOKEN'],
                'api_secret'=> $_ENV['CAR_API_SECRET'],
            ]
        ]);

        return $bearer->getContent();
    }

}
