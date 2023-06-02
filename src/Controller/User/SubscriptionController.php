<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;
use App\Entity\User;
use App\Service\Auth\EmailVerifierAndResetPasswordDealerService;
use App\Entity\Account;
use App\Entity\AccountUser;
use App\Entity\Subscription;
use App\Message\SendEmailConfirmationLink;
use App\Message\SendResetPasswordLink;
use App\Repository\SettingsRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use App\Service\Auth\EmailVerifierAndResetPasswordService;
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
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class SubscriptionController extends BaseController
{
    private RequestStack $requestStack;
    private SettingsRepository $settingsRepository;
    private SubscriptionRepository $subscriptionRepository;
    private StripeService $stripeService;


    public function __construct(
        RequestStack $requestStack,
        ManagerRegistry $registry,
        SettingsRepository $settingsRepository,
        SubscriptionRepository $subscriptionRepository,
        StripeService $stripeService,
    ) {
        parent::__construct($settingsRepository, $registry);
        $this->requestStack = $requestStack;
        $this->settingsRepository = $settingsRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->stripeService = $stripeService;

    }

    public function getPricingDetail(SubscriptionRepository $subscriptionRepository)
    {
        $subscriptions = $subscriptionRepository->findBy([], ['id' => 'ASC']);

        return $this->render('pricing/index.html.twig', [
            'subscriptions' => $subscriptions,
        ]);
    }




        #[Route('/subscribe/{priceId}', name: 'checkout')]
    public function subscribe(
        Request $request,
        SubscriptionRepository $subscriptionRepository,
        EntityManagerInterface $em
        ) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $session = $this->requestStack->getSession();
        $priceId = $request->attributes->get('priceId');
        if ('free_price' !== $priceId) {            
            if (!$this->getUser()->getStripeCustomerId()) {
                $stripeCustomerObj = $this->stripeService->stripeCustomerCreated();

                $stripeCustomerId = $stripeCustomerObj->id;
                $this->getUser()->setStripeCustomerId($stripeCustomerId);
                $em->persist($this->getUser());
                $em->flush();                
            }
            $success_url = $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL);
            $cancel_url =  $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL);
            $stripeCustomerId = $this->getUser()->getStripeCustomerId();
            $stripeSession = $this->stripeService->stripeCreateSession($success_url,$cancel_url, $stripeCustomerId, $priceId);
            if ($this->getUser()->getStripeSubscriptionId()) {
                $this->stripeService->stripeAddSubscriptionToCustomer($stripeCustomerId,$this->getUser());                
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
    }


    #[Route('/subscribes/{priceId}/userId/{id}', name: 'checkouts')]
    public function subscribes(Request $request, EmailVerifierAndResetPasswordDealerService $service, SubscriptionRepository $sr, EntityManagerInterface $em, UserRepository $userrepository, $id)
    {       
        $session = $this->requestStack->getSession();
        $priceId = $request->attributes->get('priceId');
        $userData = $userrepository->findOneBy(['id' => $id]);
        if ('free_price' !== $priceId) {
            if (!$userData->getStripeCustomerId()) {
                $stripeCustomerObj =  $this->stripeService->stripeCustomerCreated();
                $stripeCustomerId = $stripeCustomerObj->id;
                $subscription = $sr->findOneBy(['stripe_price_id' => $priceId]);
                $account = new Account();
                $account->setSubscription($subscription);
                $account->setName('Account ' . $userData->getId() . ' - Primary User ' .$userData->getId());
                $account->setPrimaryUser($userData->getId());
                $em->persist($account);
                $userData->setStripeCustomerId($stripeCustomerId);
                $em->persist($userData);
                $em->flush();
            }

            $success_url = $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL);
            $cancel_url =  $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL);
            $stripeCustomerId = $this->getUser()->getStripeCustomerId();
            $stripeSession = $this->stripeService->stripeCreateSession($success_url,$cancel_url, $stripeCustomerId, $priceId);

            if ($userData->getStrSubscriptionId()) {               
                $this->stripeService->stripeAddSubscriptionToCustomer($stripeCustomerId,$userData);                
            }

            $session->set('stripe-session-id', $stripeSession->id);
            return $this->redirect($stripeSession->url, 303);
        }

        $user = $userData;

        $basicPlan = $sr->findOneBy(['price' => 0]);
        $freeTrialTime = explode(' ', $basicPlan->getValidUntil());
        $timeExpolode = $freeTrialTime[0];

        $user->setSubscription($basicPlan);
        $user->setSubscriptionValidUntil((new \DateTime())->modify('+7 day'));
        $user->setFreePlanUsed(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user_profile', ['user' => $userData->getId()]);

//        return $this->redirectToRoute('pricing');
    }

    #[Route('/success-url', name: 'success_url')]
    public function successUrl(Request $request, EmailVerifierAndResetPasswordDealerService $service): Response
    {
        $service->SendEmailConfirmationAndResetPasswordDealer($request);
        return $this->redirectToRoute('app_dash');

        // return $this->render('user/stripe/success.html.twig', [
        //     'title' => 'title.success',
        //     'site' => $this->site($request),
        // ]);
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
