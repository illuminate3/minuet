<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Controller\BaseController;
use App\Form\Type\LoginFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\FormError;
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
        TranslatorInterface $translator,
        EntityManagerInterface $entityManager
    ): Response {

        $user = $security->getUser();  
        $form = $this->createForm(LoginFormType::class); 
        $emailField = $form->get('email');       
        if ($user && $user->getStatus()===false) {
            $security->logout(false);   
            $errorTranslationKey = 'message.user_inactive';
            $translatedErrorMessage = $translator->trans($errorTranslationKey);        
            $error = new FormError($translatedErrorMessage);
            $emailField->addError($error);          
        }
        if ($user && $user->getIsVerified()===false) {
            $security->logout(false); 
            $errorTranslationKey = 'message.user_unverified';
            $translatedErrorMessage = $translator->trans($errorTranslationKey);                            
            $error = new FormError($translatedErrorMessage);            
            $emailField->addError($error);            
        }
            

        // if user is already logged in, don't display the login page again
        $user = $userRepository->findOneBy(["email"=>$form->get('email')->getData()]);
        if ($security->isGranted('ROLE_USER')) {
            $user->setLoginAttempts(0);
            $entityManager->flush();
            return $this->redirectToRoute('app_dash');
        }
        $error = $helper->getLastAuthenticationError();
       if ($error && $error->getMessage() !== null) { 
            if (!is_null($user)) {
                $user->setLoginAttempts($user->getLoginAttempts()+1);
                $entityManager->flush();
                $attemptsRemaining = 3-$user->getLoginAttempts();
                if ($attemptsRemaining===0) { 
                    $user->setLoginAttempts(0);
                    $entityManager->flush();
                    $this->addFlash("danger","message.create_forgot_request");   
                    return $this->redirectToRoute("auth_password_reset");
                }else{    
                    $attempts = $attemptsRemaining==1 ? " $attemptsRemaining attempt is" : "$attemptsRemaining attempts are";                       
                    $emailField = $form->get('password');    
                    $message = $translator->trans('message.attempt_remaining', ['%attemptcount%' => $attempts]);                
                    $error = new FormError($error->getMessage()." $message");                    
                    $emailField->addError($error);                    
                } 
            }else{                
                $emailField = $form->get('email');                
                $error = new FormError($error->getMessage());                
                $emailField->addError($error);
            }              
       }       
        return $this->render('auth/login/login.html.twig', [
            'title' => 'title.login',
            'site' => $this->site($request),
            'form' => $form->createView(),
            'error'=>$helper->getLastAuthenticationError()
            
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
