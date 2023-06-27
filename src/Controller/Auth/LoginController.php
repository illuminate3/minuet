<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Form\Type\LoginFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController extends BaseController
{

    /**
     * @param  Request              $request
     * @param  Security             $security
     * @param  AuthenticationUtils  $helper
     *
     * @return Response
     */
    #[Route(path: '/login', name: 'security_login')]
    public function login(
        Request $request,
        Security $security,
        UserRepository $userRepository,
        AuthenticationUtils $helper,
        EntityManagerInterface $entityManager
    ): Response {

        // if user is already logged in, don't display the login page again
        $form = $this->createForm(LoginFormType::class);
        $user = $userRepository->findOneBy(["email"=>$form->get('email')->getData()]);
        if ($security->isGranted('ROLE_USER')) {
            $user = $security->getUser();  
            if (is_null($user->getProfile()->getFirstName())) {
                return $this->redirectToRoute('user_profile_edit');
            }
            return $this->redirectToRoute('app_dash');
        }
        $error = $helper->getLastAuthenticationError();
       if ($error && $error->getMessage() !== null) { 
                    
        $user->setLoginAttempts($user->getLoginAttempts()+1);
        $entityManager->flush();
        $attemptsRemaining = 3-$user->getLoginAttempts();
        if ($attemptsRemaining===0) { 
            $user->setLoginAttempts(0);
            $entityManager->flush();
            $this->addFlash("danger","Please create a forgot password request and reset your password.");   
            return $this->redirectToRoute("auth_password_reset");
        }else{    
            $attempts = $attemptsRemaining==1 ? "attempt is" : "attempts are";   
            $this->addFlash("danger",$error->getMessage());
            $this->addFlash("danger","Only $attemptsRemaining $attempts remaining.");
        }        
       }       
        return $this->render('auth/login/login.html.twig', [
            'title' => 'title.login',
            'site' => $this->site($request),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return void
     * @throws Exception
     */
    #[Route(path: '/logout', name: 'security_logout')]
    public function logout(): void
    {
        throw new Exception('This should never be reached!');
    }

}
