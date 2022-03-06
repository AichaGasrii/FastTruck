<?php

namespace App\Controller;

use App\Entity\Personnel;
use App\Form\AjoutClientType;
use App\Form\AjoutPersonnelType;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="app_client")
     */
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    /**
     * @Route("/ajoutClient", name="ajout_Client")
     */
    public function AjoutClient(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $client = new Client();
        $formc = $this->createForm(AjoutClientType::class, $client);
        $formc->add('Register', SubmitType::class, [
            'attr'=>['class' =>'btn btn-block']
        ]);
        $formc->handleRequest($request);

        if ($formc->isSubmitted() && $formc->isValid()) {
            // encode the plain password
            $client->setPassword(
                $userPasswordEncoder->encodePassword(
                    $client,
                    $formc->get('password')->getData()
                )
            );
            $client->setRoles(["ROLE_CLIENT"]);

         /*   $entityManager->persist($client);
            $entityManager->flush();*/
           $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $client,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/ajoutClient.html.twig', [
            'AjoutClient' => $formc->createView(),
        ]);

    }


    /**
     * @Route("/modifierCompte/{id}", name="client_modifier_compte")
     * @param Client $client
     * @param Request $request
     * @return Response
     */
    public function modifierClient(Client $client, Request $request): Response
    {
        $form= $this->createForm(AjoutClientType::class, $client);
        $form->add('Modifier', SubmitType::class, ['attr'=>['class' =>'btn btn-block']]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('app_client');
        }
        return $this->render("client/detailsCompte.html.twig", ["form"=>$form->createView()]);
    }


}
