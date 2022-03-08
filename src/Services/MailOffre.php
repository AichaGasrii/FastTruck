<?php

namespace App\Services;


class MailOffre
{
    public function index($nom, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Merci d avoir rempli
         notre formulaire d offre de travail nous vous contacterons aux plus 
         brefs delais pour fixer un rendez-vous'))
            ->setFrom('fast.truck@gmail.com')
            ->setTo('salma.khemiri@esprit.tn')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'email/offre.html.twig',
                    ['name' => $nom]
                ),
                'text/html'
            )

            // you can remove the following code if you don't define a text version for your emails
            ->addPart(
                $this->renderView(
                // templates/emails/registration.txt.twig
                    'email/offre.html.twig',
                    ['name' => $nom]
                ),
                'text/plain'
            )
        ;

        $mailer->send($message);

        return $this->render();
    }
}