<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Entity\Account;
use App\Entity\User;
use App\Repository\AccountRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VideoRepository;
use Psr\Log\LoggerInterface;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\RequestStack;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

final class WebhookController extends BaseController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/webhook', name: 'webhook')]
    public function stripeWebhookAction(UserRepository $ur,AccountRepository $ar, SubscriptionRepository $sr,EntityManagerInterface $em, )
    {
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
            } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
            } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
            }
            $type = $event->type;
            $object = $event->data->object;
    
            // Handle the event
            switch ($type) {
    
                case 'invoice.paid':
    
                    $user = $ur->findOneBy(['email' => $object->customer_email]);
                    $plan = $sr->findOneBy(['id' =>2]);
                    $account = new Account();
                    $ar->findOnyBy(["user_id"=>$user->id,'']);
                    $ar->setName($object->customer_email);
                    $ar->setUser($user);
                    $ar->setSubscription($plan);
                    $em->persist($ar);
                    $em->flush();
    
                  //  $user->setSubscription($plan);
                  
                    $user->setStrSubscriptionId($object->subscription);
                  //  $user->setSubscriptionValidUntil(DateTime::createFromFormat('U', $object->lines->data[0]->period->end));
                    $em->persist($user);
                    $em->flush();
                    http_response_code(200);
                    exit();                   
                   // break;
                   
                case 'customer.subscription.deleted':
    
                    // \dump($event->data->object);
    
    
                    break;
                    // ... handle other event types
                case 'customer.updated':
    
                    \dump($event->data->object);
                    // $user = $ur->findOneBy(['email', $object->customer_email]);
                    // $user->setPaymentStatus(\true);
                    // $user->setStrCustomerId($object->customer);
                    // $em->persist($user);
                    // $em->flush();
    
                    break;
                    // ... handle other event types
    
                case 'charge.succeeded':
    
                    \dump($event->data->object);
                    // $user = $ur->findOneBy(['email', $object->customer_email]);
                    // $user->setPaymentStatus(1);
                    // $user->setStrCustomerId($object->customer);
                    // $em->persist($user);
                    // $em->flush();
    
                    break;
                case 'checkout.session.completed':
    
                    \dump($event->data->object);
                    // $user = $ur->findOneBy(['email', $object->customer_email]);
                    // $user->setPaymentStatus(\true);
                    // $user->setStrCustomerId($object->customer);
                    // $em->persist($user);
                    // $em->flush();
    
                    break;
                    // ... handle other event types
    
    
    
    
    
                default:
                    // Unexpected event type
    
                    return new Response(Response::HTTP_BAD_REQUEST);
                    exit();
            }
    
            return new Response(Response::HTTP_OK);
        } catch (\Throwable $th) {
            return json_encode(["error"=>$th->getMessage()]);
        }


    }
}
