<?php

namespace App\Controller;

use App\Entity\offre;
use App\Form\offreType;
use App\Repository\offreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailOffreController extends AbstractController
{
    /**
     * @Route("/mail", name="app_mail")
     */

    public function index($nom="Aicha", \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Merci d avoir rempli
         notre formulaire d offre de travail nous vous contacterons aux plus 
         brefs delais pour fixer un rendez-vous'))
            ->setFrom('fast.truck@gmail.com')
            ->setTo('Aicha.gasri@gmail.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'email/offre.html.twig',
                    ['nom' => $nom]
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
        return $this->render('email/offre.html.twig');
    }
}
