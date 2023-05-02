<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Entity\User;
use App\Repository\SettingsRepository;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class SubscriptionController extends BaseController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack,ManagerRegistry $registry,SettingsRepository $sr)
    {
        parent::__construct($sr,$registry);
        $this->requestStack = $requestStack;
    }

    public function getPricingDetail(SubscriptionRepository $sr)
    {
        $subscriptions = $sr->findBy([], ['id' => 'ASC']);
        // \dd($subscriptions);
        return $this->render('common/pricing.html.twig', [
            'subscriptions' => $subscriptions,
        ]);
    }

    #[Route('/subscribe/{priceId}', name: 'checkout')]
    public function subscribe(Request $request,SubscriptionRepository $sr,EntityManagerInterface $em)
    {

        $stripeAPI = $_ENV['STRIPE_SECRET_KEY'];
        // \dd($request->request->get('priceId'));
        // \dd($request->attributes->get('plan'));
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        Stripe::setApiKey($stripeAPI);

        $session = $this->requestStack->getSession();

        // \dd($request);

        $priceId = $request->attributes->get('priceId');
        if ('free_price' !== $priceId) {


            if (!$this->getUser()->getStripeCustomerId()) {
                $stripeCustomerObj =  \Stripe\Customer::create([
                    'description' => 'Minuet customer',
                    'email'=>$this->getUser()->getEmail(),
                    'metadata'=>[
                        "userId"=>$this->getUser()->getId()
                    ]                  
                ]);                 
                $stripeCustomerId =  $stripeCustomerObj->id;
                $this->getUser()->setStripeCustomerId($stripeCustomerId);                 
                $em->persist($this->getUser());   
                $em->flush(); 
            }

            $stripeSession = \Stripe\Checkout\Session::create([
                'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'payment_method_types' => ['card'],
                'mode' => 'subscription',
                'customer'=>$this->getUser()->getStripeCustomerId(),
                // 'client_reference_id' => $this->getUser()->getId(),
                // 'customer_email' => $this->getUser()->getEmail(),

                'line_items' => [[
                    'price' => $priceId ,
                    // For metered billing, do not pass quantity
                    'quantity' => 1,
                ]],
            ]);

            // \dd($this->getUser()->getStrSubscriptionId());

           if ($this->getUser()->getStrSubscriptionId()) {
                $stripe = new \Stripe\StripeClient(
                    $stripeAPI
                );
                $stripe->subscriptions->update(
                    $this->getUser()->getStrSubscriptionId(),
                    ['metadata' => ['customer_id' => $this->getUser()->getStripeCustomerId()]]
                );
           }

            $session->set('stripe-session-id', $stripeSession->id);

            return $this->redirect($stripeSession->url, 303);
        }
        // \dd($request);
        $user = $this->getUser();

        if (condition) {
            # code...
        }

        $basicPlan = $sr->findOneBy(['price' => 0]);
        $freeTrialTime = explode(' ', $basicPlan->getValidUntil());
        $timeExpolode = $freeTrialTime[0];

        $user->setSubscription($basicPlan);
        $user->setSubscriptionValidUntil((new \DateTime())->modify('+7 day'));
        $user->setFreePlanUsed(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user_profile', ['user' => $this->getUser()->getId()]);

        return $this->redirectToRoute('pricing');
    }

    #[Route('/success-url', name: 'success_url')]
    public function successUrl(Request $request): Response
    {
        return $this->render('user/stripe/success.html.twig', [
            "site"=>$this->site($request),
            "title"=>"title.payment-success"
        ]);
    }

    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(Request $request): Response
    {
        return $this->render('user/stripe/cancel.html.twig', [
            "site"=>$this->site($request),
            "title"=>"title.payment-success"
        ]);
        return $this->render('user/stripe/cancel.html.twig', []);
    }

    #[Route('/cancel/{user}/{plan}', name: 'cancel_plan')]
    public function cancelPlan(Request $request, User $user, $stripeAPI): Response
    {
        // \dd($user->getStrSubscriptionId());
        // dd($user->getSubscription());
        // $subscription = $user->getSubscription();

        if ($user->getStrSubscriptionId()) {
            $str_sub_id = $user->getStrSubscriptionId();

            $stripe = new \Stripe\StripeClient($stripeAPI);
            $stripe->subscriptions->cancel(
                $str_sub_id,
                []
            );
            $user->setPaymentStatus(false);
            $user->setStrSubscriptionId(null);
        }
        $user->setSubscription(null);
        $user->setSubscriptionValidUntil(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user_profile', ['user' => $user->getId()]);
    }
}
