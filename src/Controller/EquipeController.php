<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Form\SearchEquipeType;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;





    /**
     * @Route("/equipe")
     */
class EquipeController extends AbstractController

{

/**
 * @Route("/indextri", name="indextri", methods={"GET"})
 */
    public function indextri(Request $request,EquipeRepository $equipeRepository,PaginatorInterface $paginator): Response
    {

        $search = new Equipe();
        $form = $this->createForm(SearchEquipeType::class,$search);
        $form->handleRequest($request);

        if($request->get('eq')){
        $eq = $request->get('eq');
        $equipes = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT a FROM App\Entity\equipe a order by  a.age desc')
            ->getResult();
        $equipes=$paginator->paginate($equipes,$request->query->getInt('page',1),8);
        }else{

            $donnees=$equipeRepository->searchEquipe($search);

            $equipes=$paginator->paginate(
                $donnees, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                5);// Nombre de résultats par page
        }
        return $this->render('equipe/index.html.twig', [
            'equipes' => $equipes,
            'form' => $form->createView()

        ]);

    }

    /**
     * @Route("/new", name="equipe_new", methods={"GET","POST"})
     */
public function new(Request $request): Response
{
$equipe = new Equipe();
$form = $this->createForm(EquipeType::class, $equipe);
$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($equipe);
    $entityManager->flush();
// Your Account SID and Auth Token from twilio.com/console
//    $account_sid = 'AC5bf1069e34a096d16cebd4a1b4481bba';
//    $auth_token = 'fcdc24eab1c2e969f2d44dd200d09582';
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]
// A Twilio number you own with SMS capabilities
//    $twilio_number = "+17622474309";
//    $equipe = new Equipe($account_sid, $auth_token);
//    $equipe->create(
//    // Where to send a text message (your cell phone?)
//        '+21626629623',
//        array(
//            'from' => $twilio_number,
//            'body' => 'I sent this message in under 10 minutes!'
//        )
//    );
            return $this->redirectToRoute('indextri', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipe/new.html.twig', [
            'equipe' => $equipe,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="equipe_show", methods={"GET"})
     */
    public function show(Equipe $equipe): Response
    {
        return $this->render('equipe/show.html.twig', [
            'equipe' => $equipe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="equipe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Equipe $equipe): Response
    {
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('indextri', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipe/edit.html.twig', [
            'equipe' => $equipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="equipe_delete", methods={"POST"})
     */
    public function delete(Request $request, Equipe $equipe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($equipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('indextri', [], Response::HTTP_SEE_OTHER);
    }
}
