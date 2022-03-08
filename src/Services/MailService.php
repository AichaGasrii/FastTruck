<?php

namespace App\Services;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;

class MailService
{

    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNewEventEmail($toMail , array $var)
    {
        $email = (new TemplatedEmail())
            ->from("farouk.douiri@esprit.tn")
            ->to(...$toMail)
            ->subject('You have new event')
            ->htmlTemplate('email/event.html.twig')
            ->context(
                $var
            );
        $this->mailer->send($email);
    }
}