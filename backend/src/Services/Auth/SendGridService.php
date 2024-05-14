<?php

declare(strict_types=1);

namespace App\Services\Auth;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendGridService
{
    public function __construct(private MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendWelcomeEmail(string $recipientEmail, string $userName, string $activationToken)
    {
        $email = (new TemplatedEmail())
            ->from('josemanuel.montero@agiliacenter.com')
            ->to($recipientEmail)
            ->subject($userName . ', Welcome to Football Highlights!')
            ->htmlTemplate('emails/signup.html.twig')
            ->context([
                'username' => $userName,
                'activationToken' => $activationToken,
            ]);

        $this->mailer->send($email);
    }
}
