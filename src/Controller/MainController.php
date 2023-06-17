<?php

declare(strict_types=1);

namespace App\Controller;

use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MainController extends AbstractController
{

    public function __construct(
        private HttpClientInterface $carApiClient,
        private CacheInterface $cache,
        ParameterBagInterface $params,
    ) {
        $this->params = $params;
    }

    /**
     * @param  HttpClientInterface  $carApiClient
     * @param  CacheInterface       $cache
     *
     * @return Response
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    #[Route('vin', name: 'vin')]
    public function index(
        HttpClientInterface $carApiClient,
        CacheInterface $cache,
//        HttpClientInterface $githubContentClient
    ): Response {

        $token = $this->getBearerToken($cache);

//        echo $this->getBearerToken($cache);
//        die;

//        $vinNumber = $request->get('vin');
        $vinNumber = 'KNDJ23AU4N7154467';
        $response = $carApiClient->request('GET', 'https://carapi.app/api/vin/' . $vinNumber, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

//        $response = $githubContentClient->request('GET', '/SymfonyCasts/vinyl-mixes/main/mixes.json');
//            $response = $carApiClient->request('GET', '/api/vin/KNDJ23AU4N7154467');


        print_r($response->toArray());
//        die;

        return new Response(
            'Check out that car!',
            Response::HTTP_OK
        );
    }

    /**
     * @param $cache
     *
     * @return string
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getBearerToken($cache): string
    {

        return $cache->get('carapi_bearer_token', function (ItemInterface $item) {

            $tokenValue = $this->callBearerToken();

            $tokenParts = explode(".", $tokenValue);
//            $tokenHeader = base64_decode($tokenParts[0]);
            $tokenPayload = base64_decode($tokenParts[1]);
//            $jwtHeader = json_decode($tokenHeader);
//            $jwtPayload = json_decode($tokenPayload);
            $jwtPayloadValues = json_decode($tokenPayload, true);
            $expiration = $jwtPayloadValues['exp']; // 1685321850
//            $issuedTime = $jwtPayloadValues['iat']; // 1684717050

            $date = new DateTimeImmutable();
            $date->setTimestamp($expiration);
            $expirationDate = $date->format('Y-m-d');

//            $item->expiresAfter(3600);
            $item->expiresAt(new DateTimeImmutable($expirationDate));

//            echo 'here';
//            die;
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
    public function callBearerToken(): string
    {
        $bearer = $this->carApiClient->request('POST', '/api/auth/login', [
            'body' => [
                'api_token' => $this->params->get('app.carapi.api_token'),
                'api_secret' => $this->params->get('app.carapi.api_secret')
            ]
        ]);

        return $bearer->getContent();
    }

}
