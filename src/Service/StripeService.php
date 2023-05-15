<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class StripeService
{
//    private $client;
//    private $requestStack;
//
//    public function __construct(HttpClientInterface $client, RequestStack $requestStack)
//    {
//        $this->client = $client;
//        $this->requestStack = $requestStack;
//    }


    public function customerSubscriptionCreated($stripeObject): void
    {
        $stripeEvent = $stripeObject;
        dd($stripeEvent);
    }


    public function chargeFailed($stripeObject): void
    {
        $stripeEvent = $stripeObject;
        dd($stripeEvent);
//        $stripeEvent = $webhook->getStripeObject();
//        $subscriptionStripe = $stripeEvent->data->object;
//        dd($subscriptionStripe);
    }


//    public function fetchGitHubInformation()
//    {
//        $response = $this->client->request(
//            'GET',
//            'http://localhost:8000/webhook'
//        );
//        $session = $this->requestStack->getSession();
//        $session->set('res', $response);
//        $statusCode = $response->getStatusCode();
//        // $statusCode = 200
//        $contentType = $response->getHeaders()['content-type'][0];
//        // $contentType = 'application/json'
//        $content = $response->getContent();
//        // $content = '{"id":521583, "name":"symfony-docs", ...}'
//        $content = $response->toArray();
//        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
//
//        return $content;
//    }
}
