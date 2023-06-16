<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\User;
use App\Mailer\Mailer;
use App\Message\SendEmailConfirmationLink;
use App\Repository\SettingsRepository;
use App\Service\Cache\UserDataCache;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Model\VerifyEmailSignatureComponents;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

#[AsMessageHandler]
final class SendEmailConfirmationLinkHandler
{

    use UserDataCache;

    private VerifyEmailHelperInterface $verifyEmailHelper;
    private Mailer $mailer;
    private UrlGeneratorInterface $router;
    private TranslatorInterface $translator;
    private $settings;
    public function __construct(
        VerifyEmailHelperInterface $helper,
        Mailer $mailer,
        UrlGeneratorInterface $router,
        TranslatorInterface $translator,
        SettingsRepository $settingsRepository,
    ) {
        $this->verifyEmailHelper = $helper;
        $this->mailer = $mailer;
        $this->router = $router;
        $this->translator = $translator;
        $this->settings = $settingsRepository->findAllAsArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws InvalidArgumentException
     */
    public function __invoke(SendEmailConfirmationLink $sendEmailConfirmationLink): void
    {
        $user = $sendEmailConfirmationLink->getUser();
        $email = $this->buildEmail($user);
        $this->mailer->send($email);
        $this->setConfirmationSentAt($user);
    }

    private function getSender(): Address
    {
        $host = $this->router->getContext()->getHost();

        return new Address('no-reply@' . $host, $host);
    }

    private function getSubject(): string
    {
        return $this->translator->trans('message.email.subject.confirmation');
    }

    private function getSignatureComponents(User $user): VerifyEmailSignatureComponents
    {
        return $this->verifyEmailHelper->generateSignature(
            'verify_email',
            (string) $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId()]
        );
    }

    private function createContext(VerifyEmailSignatureComponents $signatureComponents): array
    {
        return [
            'signedUrl' => $signatureComponents->getSignedUrl(),
            'expiresAtMessageKey' => $signatureComponents->getExpirationMessageKey(),
            'expiresAtMessageData' => $signatureComponents->getExpirationMessageData(),
            'siteName' => $this->settings["site_name"]
        ];
    }

    private function buildEmail(User $user): TemplatedEmail
    {
        $signatureComponents = $this->getSignatureComponents($user);

        return (new TemplatedEmail())
            ->from($this->getSender())
            ->to($user->getEmail())
            ->subject($this->getSubject())
            ->htmlTemplate('auth/email/confirmation_email.html.twig')
            ->context($this->createContext($signatureComponents))
        ;
    }

}
