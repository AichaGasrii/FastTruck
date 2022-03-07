<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Client;
use App\Entity\Personnel;
use App\Form\AjoutClientType;
use App\Form\AjoutPersonnelType;
use App\Form\RegistrationFormType;
use App\Repository\PersonnelRepository;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Form\FormTypeInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', ['controller_name' => 'AdminController',]);
    }

    /**
     * @Route("/admin/ajoutPersonnel", name="admin_ajoutPersonnel")
     */
    public function AjoutPersonnel(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager)
    {
        $personnel = new Personnel();
        $formp = $this->createForm(AjoutPersonnelType::class, $personnel);
        $formp->add('Ajouter', SubmitType::class, [
            'attr'=>['class' =>'btn btn-block']
        ]);
        $formp->handleRequest($request);

        if ($formp->isSubmitted() && $formp->isValid()) {
            // encode the plain password
            $personnel->setPassword(
                $userPasswordEncoder->encodePassword(
                    $personnel,
                    $formp->get('password')->getData()
                )
            );
            $personnel->setRoles(["ROLE_PERSONNEL"]);

            /*   $entityManager->persist($client);
               $entityManager->flush();*/
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($personnel);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $personnel,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/ajoutPersonnel.html.twig', [
            'AjoutPersonnel' => $formp->createView(),
        ]);

    }

    /**
     * @Route("/admin/ajoutAdmin", name="admin_ajout_admin")
     */
    public function AjoutAdmin(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager)
    {
        $admin = new Admin();
        $forma = $this->createForm(RegistrationFormType::class, $admin);
        $forma->add('Ajouter', SubmitType::class, ['attr'=>['class' =>'btn btn-block']]);
        $forma->handleRequest($request);

        if ($forma->isSubmitted() && $forma->isValid()) {
            // encode the plain password
            $admin->setPassword(
                $userPasswordEncoder->encodePassword(
                    $admin,
                    $forma->get('password')->getData()
                )
            );
            $admin->setRoles(["ROLE_ADMIN"]);

            /*   $entityManager->persist($client);
               $entityManager->flush();*/
            $entityManager=$this->getDoctrine()->getManager();
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
            'AjoutAdmin' => $forma->createView(),
        ]);

    }

    /**
     * @Route ("/admin/listePersonnel", name="admin_liste_personnel")
     */
public function ListePersonnel(){
    $personnels= $this->getDoctrine()->getRepository(Personnel::class)->findAll();
    return $this->render('personnel/listePersonnel.html.twig', ['personnels'=>$personnels]);
}


    /**
     * @Route("/admin/personnel/delete/{id}", name="admin_delete_personnel")
     * @param Personnel $personnel
     * @return RedirectResponse
     */
    public function deletepersonnel(Personnel $personnel): RedirectResponse
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($personnel);
        $em->flush();
        return $this->redirectToRoute('admin_liste_personnel');
    }

    /**
     * @Route ("/admin/listeClient", name="admin_liste_client")
     */
    public function ListeClient(){
        $clients= $this->getDoctrine()->getRepository(Client::class)->findAll();
        return $this->render('client/listeClient.html.twig', ['clients'=>$clients]);
    }

    /**
     * @Route("/admin/client/delete/{id}", name="admin_delete_client")
     * @param Client $client
     * @return RedirectResponse
     */
    public function deleteclient(Client $client): RedirectResponse
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($client);
        $em->flush();
        return $this->redirectToRoute('admin_liste_client');
    }

    /**
     * @Route("/admin/modifierPersonnel/{id}", name="admin_modifier_personnel")
     * @param Personnel $personnel
     * @param Request $request
     * @return Response
     */
    public function modifierPersonnel(Personnel $personnel, Request $request): Response
    {
        $form= $this->createForm(AjoutPersonnelType::class, $personnel);
        $form->add('Modifier', SubmitType::class, ['attr'=>['class' =>'btn btn-block']]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('admin_liste_client');
        }
        return $this->render("admin/modifierPersonnel.html.twig", ["form"=>$form->createView()]);
    }




}
