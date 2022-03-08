<?php

namespace App\Controller;

use App\Entity\Equippement;
use App\Form\EquippementType;
use App\Repository\EquippementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equippement")
 */
class EquippementController extends AbstractController
{
    /**
     * @Route("/", name="equippement_index", methods={"GET"})
     */
    public function index(EquippementRepository $equippementRepository): Response
    {
        return $this->render('equippement/index.html.twig', [
            'equippements' => $equippementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="equippement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $equippement = new Equippement();
        $form = $this->createForm(EquippementType::class, $equippement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equippement);
            $entityManager->flush();

            return $this->redirectToRoute('equippement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equippement/new.html.twig', [
            'equippement' => $equippement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="equippement_show", methods={"GET"})
     */
    public function show(Equippement $equippement): Response
    {
        return $this->render('equippement/show.html.twig', [
            'equippement' => $equippement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="equippement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Equippement $equippement): Response
    {
        $form = $this->createForm(EquippementType::class, $equippement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equippement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equippement/edit.html.twig', [
            'equippement' => $equippement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="equippement_delete", methods={"POST"})
     */
    public function delete(Request $request, Equippement $equippement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equippement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($equippement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('equippement_index', [], Response::HTTP_SEE_OTHER);
    }
}
