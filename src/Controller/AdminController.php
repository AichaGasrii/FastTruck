<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Personnel;
use App\Form\AjoutClientType;
use App\Form\AjoutPersonnelType;
use App\Repository\PersonnelRepository;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

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
     * @Route ("/admin/listePersonnel", name="admin_liste_personnel")
     */
public function ListePersonnel(){
    $personnels= $this->getDoctrine()->getRepository(Personnel::class)->findAll();
    return $this->render('personnel/listePersonnel.html.twig', ['personnels'=>$personnels]);
}


    /**
     * @Route("/admin/personnel/delete/{id}", name="admin_deletePersonnel")
     */
    public function deletepersonnel($id,PersonnelRepository $repository) {

        $user=$repository->find($id);;
        $em=$this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('app_admin');
    }


}
