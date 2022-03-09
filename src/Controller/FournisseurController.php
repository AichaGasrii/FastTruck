<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use App\Repository\FournisseurRepository;
use App\Repository\StocksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/fournisseur")
 */
class FournisseurController extends AbstractController
{
    /**
     * @Route("/", name="fournisseur_index", methods={"GET"})
     */
    public function index(FournisseurRepository $fournisseurRepository,PaginatorInterface $paginator,StocksRepository $stocksRepository,Request $request): Response
    {
        $fournisseur=$paginator->paginate($fournisseurRepository->findAll(),$request->query->getInt('page',1),2);
        return $this->render('fournisseur/index.html.twig', [
            'fournisseurs' => $fournisseurRepository->findAll(),
            'stocks' => $stocksRepository->findAll(),
        ]);
    }

    /**
     * @Route("/stats", name="Stocks_stat", methods={"GET"})
     */
    public function board(FournisseurRepository $fournisseurRepository): Response
    {
        return $this->render('stocks/Dashboard1.html.twig', [
            'fournisseurs' => $fournisseurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="fournisseur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fournisseur);
            $entityManager->flush();

            return $this->redirectToRoute('fournisseur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fournisseur/new.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fournisseur_show", methods={"GET"})
     */
    public function show(Fournisseur $fournisseur): Response
    {
        return $this->render('fournisseur/show.html.twig', [
            'fournisseur' => $fournisseur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fournisseur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Fournisseur $fournisseur): Response
    {
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fournisseur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fournisseur/edit.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fournisseur_delete", methods={"POST"})
     */
    public function delete(Request $request, Fournisseur $fournisseur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fournisseur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fournisseur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fournisseur_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/{id}/valide", name="fournisseur_valide")
     * @param Fournisseur $fournisseur
     * @return RedirectResponse
     */
    public function valide (Fournisseur $fournisseur): RedirectResponse
    {   $fournisseur->setStatu(1);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("fournisseur_index");
    }
    /**
     * @Route("/{id}/refuse", name="fournisseur_refuse")
     * @param Fournisseur $fournisseur
     * @return RedirectResponse
     */
    public function refuse (Fournisseur $fournisseur): RedirectResponse
    {   $fournisseur->setStatu(2);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("fournisseur_index");
    }
}
