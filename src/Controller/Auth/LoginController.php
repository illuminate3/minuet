<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Form\Type\LoginFormType;
use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController extends BaseController
{
    #[Route(path: '/login', name: 'security_login')]
    public function login(
        Request $request,
        AccountRepository $accountRepository,
        AccountUserRepository $accountUserRepository,
        Security $security,
        AuthenticationUtils $helper,
    ): Response {

        // if user is already logged in, don't display the login page again

        if ($security->isGranted('ROLE_USER')) {
            $resp = $this->checkStripeSubscriptionActive($security,$accountRepository,$accountUserRepository);
            if ($resp==='account') {
                return $this->redirectToRoute('app_pricing');
            }elseif (!$resp) {
                $this->addFlash('error','message.stripe_in_active');        
            }else{
                return $this->redirectToRoute('app_dash');
            }
        }     
        if ($security->isGranted('ROLE_USER') || $security->isGranted('ROLE_DEALER')) {
            return $this->redirectToRoute('app_dash');
        }

        if ($security->isGranted('ROLE_BUYER')) {
            return $this->redirectToRoute('app_dash_buyer');
        }

        if ($security->isGranted('ROLE_STAFF')) {
            return $this->redirectToRoute('app_dash_staff');
        }

        $error = $helper->getLastAuthenticationError();

        if ($error && $error->getMessage() !== null) {
            return $this->forward(
                'App\Controller\Auth\MessageController::authMessages',
                [
                    'title' => 'title.verify_account',
                    'message' => $error->getMessage(),
                    'link' => 'auth_request_verify_email',
                    'link_title' => 'action.verify_account',
                ]
            );
        }

        $form = $this->createForm(LoginFormType::class);

        return $this->render('auth/login/login.html.twig', [
            'title' => 'title.login',
            'site' => $this->site($request),
            'error' => $helper->getLastAuthenticationError(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route(path: '/logout', name: 'security_logout')]
    public function logout(): void
    {
        throw new Exception('This should never be reached!');
    }
}
