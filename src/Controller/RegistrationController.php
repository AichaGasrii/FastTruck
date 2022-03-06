<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Client;
use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $admin = new Admin();
        $forma = $this->createForm(RegistrationFormType::class, $admin);
        $forma->handleRequest($request);

        if ($forma->isSubmitted() && $forma->isValid()) {
            // encode the plain password
            $admin->setPassword(
            $userPasswordEncoder->encodePassword(
                    $admin,
                    $forma->get('plainPassword')->getData()
                )
            );
            $admin->setRoles(['ROLE_ADMIN']);

            $entityManager->persist($admin);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $admin,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/ajoutAdmin.html.twig', [
            'ajoutAdmin' => $forma->createView(),
        ]);
    }


}
