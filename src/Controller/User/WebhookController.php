<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Entity\User;
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

final class WebhookController extends BaseController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/webhook', name: 'webhook')]
    public function stripeWebhookAction($stripeAPI, UserRepository $ur, SubscriptionRepository $sr)
    {
        Stripe::setApiKey($stripeAPI);
        $endpoint_secret = 'whsec_o5GViEieAbivYcyXwLTyOyFOHAwc0zN2';
        $session = $this->requestStack->getSession();

        $em = $this->getDoctrine()->getManager();
        $json_str = \file_get_contents('php://input');
        $event = \json_decode($json_str);

        $type = $event->type;
        $object = $event->data->object;



        // Handle the event
        switch ($type) {

            case 'invoice.paid':

                $user = $ur->findOneBy(['email' => $object->customer_email]);
                $plan = $sr->findOneBy(['stripe_price_id' => $object->lines->data[0]->plan->id]);
                $user->setSubscription($plan);
                $user->setPaymentStatus(\true);
                $user->setStrCustomerId($object->customer);
                $user->setStrSubscriptionId($object->subscription);
                $user->setSubscriptionValidUntil(DateTime::createFromFormat('U', $object->lines->data[0]->period->end));
                $em->persist($user);
                $em->flush();
                break;
                // ... handle other event types


                // case 'invoice.paid':

                //     \dump($event->data->object);
                //     // $user = $ur->findOneBy(['email', $object->customer_email]);
                //     // $user->setPaymentStatus(\true);
                //     // $user->setStrCustomerId($object->customer);
                //     // $em->persist($user);
                //     // $em->flush();

                //     break;
                //     // ... handle other event types



                // ... handle other event types
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

        // $session = $this->requestStack->getSession();

        // $data = json_decode($request->getContent(), true);



        // $endpoint_secret = 'whsec_Cl1FIM6uvwBE5h9BEpMOBcQsyQl5siZX';

        // $data = json_decode($request->getContent(), true);
        // $session->set('data', $data);




        // $session->set('Req', $request);
    }
}
