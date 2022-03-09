<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;

/**
 * @Route("/reclamation")
 */
class ReclamationController extends AbstractController
{
    /**
     * @Route("/", name="reclamation_index", methods={"GET"})
     */
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/stats", name="statReclamation")
     */
    public function stat()
    {
        $repository = $this->getDoctrine()->getRepository(Reclamation::class);
        $reclamations = $repository->findAll();

        $em = $this->getDoctrine()->getManager();

        $r1=0;
        $r2=0;

        foreach ($reclamations as $reclamation)
        {
            if ( $reclamation->getEtat()==1) :

                $r1+=1;
            else:

                $r2+=1;


            endif;

        }

        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['etat', 'nombre'],
                ['valide', $r1],
                ['en cours', $r2],
            ]
        );
        $pieChart->getOptions()->setTitle('Statiqtiques ');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('reclamation/stat.html.twig', array('piechart' => $pieChart));
    }


    /**
     * @Route("/indextri", name="indextri", methods={"GET"})
     */
    public function indextri(Request $request,ReclamationRepository $reclamationRepository): Response
    {


        $rec = $request->get('rec');
        $reclamat = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT reclamation FROM App\Entity\Reclamation reclamation order by  reclamation.date desc')
            ->getResult();
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamat


        ]);

    }
    /**
     * @Route("/new", name="reclamation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reclamation = new Reclamation();
        $objDateTime=new\ DateTime('NOW');
        $reclamation->setDate($objDateTime);
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        return $this->render('reclamation/showReclamation.html.twig', [
            'reclamation' => $reclamation,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reclamation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reclamation $reclamation): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reclamation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reclamation $reclamation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
 * @Route("/{id}/valide", name="reclamation_valide")
 * @param Reclamation $reclamation
 * @return RedirectResponse
 */
    public function valide (Reclamation $reclamation): RedirectResponse
    {   $reclamation->setEtat(1);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("reclamation_index");
    }
    /**
     * @Route("/{id}/refuse", name="reclamation_refuse")
     * @param Reclamation $reclamation
     * @return RedirectResponse
     */
    public function refuse (Reclamation $reclamation): RedirectResponse
    {   $reclamation->setEtat(2);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("reclamation_index");
    }

    
}
