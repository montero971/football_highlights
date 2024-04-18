<?php

declare(strict_types=1);

namespace App\Services;

use DateTimeZone;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendGridService
{
    public function __construct(private MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendWelcomeEmail(string $recipientEmail, string $userName)
    {
        $email = (new TemplatedEmail())
            ->from('josemanuel.montero@agiliacenter.com')
            ->to($recipientEmail)
            ->subject($userName . ', Welcome to Football Highlights!')
            ->htmlTemplate('emails/signup.html.twig')
            ->context([
                'username' => $userName,
            ]);

        $this->mailer->send($email);
    }
}
