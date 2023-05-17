<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Entity\User;
use App\Repository\SettingsRepository;
use App\Repository\SubscriptionRepository;
use App\Service\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Object_;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\StripeClient;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class SubscriptionController extends BaseController
{
    private RequestStack $requestStack;
//    private Stripe $stripe;

//        $stripe_pk = $this->getParameter('app.stripe.publishable_api_key');
//        $stripe = new StripeClient(
//        $this->getParameter('app.stripe.secret_api_key')
    private SettingsRepository $settingsRepository;
    private SubscriptionRepository $subscriptionRepository;
    private StripeService $stripeService;


    public function __construct(
        RequestStack $requestStack,
        ManagerRegistry $registry,
        SettingsRepository $settingsRepository,
        SubscriptionRepository $subscriptionRepository,
        StripeService $stripeService,
//        Stripe $stripe,
    ) {
        parent::__construct($settingsRepository, $registry);
        $this->requestStack = $requestStack;
        $this->settingsRepository = $settingsRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->stripeService = $stripeService;
//        $this->stripe = $stripe;
    }

    public function getPricingDetail(SubscriptionRepository $subscriptionRepository)
    {
        $subscriptions = $subscriptionRepository->findBy([], ['id' => 'ASC']);

        return $this->render('pricing/index.html.twig', [
            'subscriptions' => $subscriptions,
        ]);
    }

    /**
     * @throws ApiErrorException
     */
    #[Route('/subscribe/make/{customerID}', name: 'make_stripe_customer')]
    public function make_stripe_customer(
        Request $request,
    ): RedirectResponse {
//        // Create a new customer object
//        $customer = $stripe->customers->create([
//            'email' => $body->email,
//        ]);

//        $stripe = new \Stripe\StripeClient(
//            'sk_test_4eC39HqLyjWDarjtT1zdp7dc'
//        );
//        $stripe->customers->create([
//            'description' => 'My First Test Customer (created for API docs at https://www.stripe.com/docs/api)',
//        ]);

        $this->stripeService->stripeCustomerCreated();

        return $this->redirectToRoute('success_url');

    }



        #[Route('/subscribe/{priceId}', name: 'checkout')]
    public function subscribe(
        Request $request,
        SubscriptionRepository $subscriptionRepository,
        EntityManagerInterface $em
        ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

//        $stripeAPI = $_ENV['STRIPE_SECRET_KEY'];
        Stripe::setApiKey($this->getParameter('app.stripe.secret_key'));

        $session = $this->requestStack->getSession();
        $priceId = $request->attributes->get('priceId');
//        $stripe = $this->stripe;
        if ('free_price' !== $priceId) {
            $stripeCustomerObject = null;
            if (!$this->getUser()->getStripeCustomerId()) {
//                $stripeCustomerObj = Customer::create([
//                    'description' => 'Minuet customer',
//                    'email' => $this->getUser()->getEmail(),
//                    'metadata' => [
//                        'userId' => $this->getUser()->getId(),
//                    ],
//                ]);
//                $stripeCustomerId = $stripeCustomerObj->id;
//                $this->getUser()->setStripeCustomerId($stripeCustomerId);
//                $em->persist($this->getUser());
//                $em->flush();
                $stripeCustomerObject = $this->stripeService->stripeCustomerCreated();
            }

            $success_url = $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL);
            $cancel_url =  $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL);

            $stripeCustomerId = $this->getUser()->getStripeCustomerId();

//            if ($stripeCustomerObject) {
//                $stripeCustomerId = $stripeCustomerObject->id;
//            } else {
//                $stripeCustomerId = $this->getUser()->getStripeCustomerId();
//            }

            $stripeSession = $this->stripeService->stripeCreateSession($success_url,$cancel_url, $stripeCustomerId, $priceId);

//            $stripeSession = \Stripe\Checkout\Session::create([
//                'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
//                'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
//                'payment_method_types' => ['card'],
//                'mode' => 'subscription',
//                'customer' => $this->getUser()->getStripeCustomerId(),
//
//                'line_items' => [[
//                    'price' => $priceId,
//                    // For metered billing, do not pass quantity
//                    'quantity' => 1,
//                ]],
//            ]);

            if ($this->getUser()->getStripeSubscriptionId()) {
                $stripe = new StripeClient($this->getParameter('app.stripe.secret_key'));
                $stripe->subscriptions->update(
                    $this->getUser()->getStripeSubscriptionId(),
                    ['metadata' => ['customer_id' => $stripeCustomerId]]
                );
            }

            $session->set('stripe-session-id', $stripeSession->id);

            return $this->redirect($stripeSession->url, 303);
        }

        $user = $this->getUser();

        $basicPlan = $subscriptionRepository->findOneBy(['price' => 0]);
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
            'title' => 'title.success',
            'site' => $this->site($request),
        ]);
    }

    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(Request $request): Response
    {
        return $this->render('user/stripe/cancel.html.twig', [
            'site' => $this->site($request),
            'title' => 'title.payment-success',
        ]);

        return $this->render('user/stripe/cancel.html.twig', []);
    }

    #[Route('/cancel/{user}/{plan}', name: 'cancel_plan')]
    public function cancelPlan(Request $request, User $user, $stripeAPI): Response
    {
        if ($user->getStripeSubscriptionId()) {
            $str_sub_id = $user->getStripeSubscriptionId();

            $stripe = new StripeClient($stripeAPI);
            $stripe->subscriptions->cancel(
                $str_sub_id,
                []
            );
            $user->setPaymentStatus(false);
            $user->setStrSubscriptionId($str_sub_id);
        }
        $user->setSubscription(null);
        $user->setSubscriptionValidUntil(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user_profile', ['user' => $user->getId()]);
    }
}
