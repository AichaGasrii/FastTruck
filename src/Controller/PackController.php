<?php

namespace App\Controller;

use App\Entity\Pack;
use App\Form\PackType;
use App\Repository\PackRepository;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;

/**
 * @Route("/Pack")
 */
class PackController extends AbstractController
{
    /**
     * @Route("/show", name="Pack_index", methods={"GET"})
     */
    public function index(PackRepository $PackRepository): Response
    {
        return $this->render('Pack/index.html.twig', [
            'Packs' => $PackRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="Pack_new", methods={"GET","POST"})
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function new(Request $request): Response
    {

        $Pack = new Pack();
        $form = $this->createForm(PackType::class, $Pack);
        $form->add('captchaCode', CaptchaType::class, array(
            'captchaConfig' => 'ExampleCaptchaUserRegistration',
            'mapped' => false,
            'constraints' => [
                new ValidCaptcha([
                    'message' => 'Invalid captcha, please try again',
                ]),
            ],
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Pack);
            $entityManager->flush();
            $account_sid = 'AC5bf1069e34a096d16cebd4a1b4481bba';
            $auth_token = '6b34e82b837ae4935b97551dbbd26dcc';
            $twilio_number = "+17622474309";

            $client = new Client($account_sid,$auth_token);
            $client->messages->create(
                '+21626629623',
                array(
                    'from' => $twilio_number,
                    'body' => 'Pack crée pour le client de num commande'.$Pack->getNumcommande().'!'
                )
            );
            return $this->redirectToRoute('Pack_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('Pack/new.html.twig', [
            'Pack' => $Pack,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="Pack_show", methods={"GET"})
     */
    public function show(Pack $Pack): Response
    {
        return $this->render('Pack/show.html.twig', [
            'Pack' => $Pack,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="Pack_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pack $Pack): Response
    {
        $form = $this->createForm(PackType::class, $Pack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Pack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Pack/edit.html.twig', [
            'Pack' => $Pack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="Pack_delete", methods={"POST"})
     */
    public function delete(Request $request, Pack $Pack): Response
    {
        if ($this->isCsrfTokenValid('delete'.$Pack->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($Pack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('Pack_index', [], Response::HTTP_SEE_OTHER);
    }
}
