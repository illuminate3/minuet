<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\User;
use App\Mailer\Mailer;
use App\Message\SendEmailConfirmationAndResetPassword;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AsMessageHandler]
final class SendEmailConfirmationAndResetPasswordLinkHandler
{
    public function __construct(private Mailer $mailer, private TranslatorInterface $translator, private UrlGeneratorInterface $router)
    {
    }


    /**
     * @param  SendEmailConfirmationAndResetPassword  $SendEmailConfirmationAndResetPassword
     *
     * @return void
     * @throws TransportExceptionInterface
     */
    public function __invoke(SendEmailConfirmationAndResetPassword $SendEmailConfirmationAndResetPassword): void
    {
        $user = $SendEmailConfirmationAndResetPassword->getUser();

        $email = $this->buildEmail($user);

        $this->mailer->send($email);
    }

    /**
     * @return Address
     */
    private function getSender(): Address
    {
        $host = $this->router->getContext()->getHost();

        return new Address('no-reply@' . $host, $host);
    }

    /**
     * @return string
     */
    private function getSubject(): string
    {
        return $this->translator->trans('email.subject.staff.account_setup');
    }

    private function getConfirmationUrl(User $user): string
    {
        return $this->router->generate(
            'password_reset_confirm', ['token' => $user->getConfirmationToken()], 0
        );
    }

    /**
     * @param  User  $user
     *
     * @return TemplatedEmail
     */
    private function buildEmail(User $user): TemplatedEmail
    {
        return (new TemplatedEmail())
            ->from($this->getSender())
            ->to($user->getEmail())
            ->subject($this->getSubject())
            ->htmlTemplate('auth/email/confirmation_email_and_reset_password.txt.twig')
            ->context([
                'confirmationUrl' => $this->getConfirmationUrl($user),
                'username' => $user->getEmail(),
            ])
        ;
    }

}
