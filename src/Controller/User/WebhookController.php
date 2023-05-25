<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Entity\Account;
use App\Repository\AccountRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Fpt\StripeBundle\Event\StripeWebhook;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;
use UnexpectedValueException;

final class WebhookController extends BaseController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/webhook', name: 'webhook')]
    public function stripeWebhookAction(
        UserRepository $userRepository,
        AccountRepository $accountRepository,
        SubscriptionRepository $subscriptionRepository,
        EntityManagerInterface $em
    ) {
        try {
            $stripeAPI = $_ENV['STRIPE_SECRET_KEY'];
            Stripe::setApiKey($stripeAPI);

            $endpoint_secret = $_ENV['STRIPE_WEBHOOK_KEY'];

            $payload = @file_get_contents('php://input');
            $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
            $event = null;

            try {
                $event = \Stripe\Webhook::constructEvent(
                    $payload, $sig_header, $endpoint_secret
                );
            } catch (UnexpectedValueException $e) {
                // Invalid payload
                http_response_code(400);
                exit;
            } catch (\Stripe\Exception\SignatureVerificationException $e) {
                // Invalid signature
                http_response_code(400);
                exit;
            }
            $type = $event->type;
            $object = $event->data->object;

            // Handle the event
            switch ($type) {
                case 'invoice.paid':
                    $user = $userRepository->findOneBy(['email' => $object->customer_email]);
                    $plan = $subscriptionRepository->findOneBy(['stripe_price_id' => $object->lines->data[0]->price->id]);
                    $account = $accountRepository->findOneBy(['primaryUser' => $user->getId()]);
                    if (!$account) {
                        $account = new Account();
                    }
                    $account->setName($object->customer_email);
                    $account->setPrimaryUser($user->getId());
                    $account->setSubscription($plan);
                    $account->setIsSubscriptionActive(true);
                    $em->persist($account);
                    $em->flush();

                    $user->setStrSubscriptionId($object->subscription);
                    
                    $em->persist($user);
                    $em->flush();
                    http_response_code(200);
                    echo json_encode(["status"=>true]);
                    exit();                   
                   // break;
                   
                case 'customer.subscription.deleted':
                    

                    break;
                  
                case 'customer.updated':
                    

                case 'customer.subscription.created':
                    dump($event->data->object);
                    break;

                case 'charge.succeeded':
                    dump($event->data->object);
                   

                    break;

                case 'checkout.session.completed':
                    dump($event->data->object);
                   

                    break;
                    // ... handle other event types

                default:
                    // Unexpected event type

                    return new Response(Response::HTTP_BAD_REQUEST);
            }

            return new Response(Response::HTTP_OK);
        } catch (Throwable $th) {
            return json_encode(['error' => $th->getMessage()]);
        }
    }
}

//public function stripeCustomerSubscriptionCreated(): void
//{
//    $this->stripeService->customerSubscriptionCreated($this->webhook->getStripeObject());
////        $stripeEvent = $webhook->getStripeObject();
////        $subscriptionStripe = $stripeEvent->data->object;
////        dd($subscriptionStripe);
//}
//
//public function stripeCustomerCreated(StripeWebhook $webhook): void
//{
////        /** @var \Stripe\Event $stripeEvent */
//    $stripeEvent = $webhook->getStripeObject();
////        /** @var \Stripe\Subscription $subscriptionStripe */
//    $subscriptionStripe = $stripeEvent->data->object;
//
//    // ... Your custom logic here.
//}
//
//public function stripeChargeFailed(): void
//{
//    $this->stripeService->chargeFailed($this->webhook->getStripeObject());
//}
