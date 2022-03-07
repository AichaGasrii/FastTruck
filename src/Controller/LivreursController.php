<?php

namespace App\Controller;

use App\Entity\Livreurs;
use App\Form\LivreursType;
use App\Repository\LivreursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/livreurs")
 */
class LivreursController extends AbstractController
{
    /**
     * @Route("/", name="livreurs_index", methods={"GET"})
     */
    public function index(LivreursRepository $livreursRepository): Response
    {
        return $this->render('livreurs/index.html.twig', [
            'livreurs' => $livreursRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="livreurs_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livreurs = new Livreurs();
        $form = $this->createForm(LivreursType::class, $livreurs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livreurs);
            $entityManager->flush();

            return $this->redirectToRoute('livreurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livreurs/new.html.twig', [
            'livreurs' => $livreurs,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="livreurs_show", methods={"GET"})
     */
    public function show(Livreurs $livreurs): Response
    {
        return $this->render('livreurs/show.html.twig', [
            'livreurs' => $livreurs,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="livreurs_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Livreurs $livreurs, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreursType::class, $livreurs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('livreurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livreurs/edit.html.twig', [
            'livreurs' => $livreurs,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="livreurs_delete", methods={"POST"})
     */
    public function delete(Request $request, Livreurs $livreurs, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livreurs->getId(), $request->request->get('_token'))) {
            $entityManager->remove($livreurs);
            $entityManager->flush();
        }

        return $this->redirectToRoute('livreurs_index', [], Response::HTTP_SEE_OTHER);
    }
}
