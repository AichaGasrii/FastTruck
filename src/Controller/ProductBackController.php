<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Product1Type;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product/back")
 */
class ProductBackController extends AbstractController
{
    /**
     * @Route("/", name="product_back_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository,CategoryRepository $categoryRepository): Response
    {
        return $this->render('product_back/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_back_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(Product1Type::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $product->setInitialPrice($product->getPrice());
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_back/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_back_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product_back/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_back_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(Product1Type::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_back/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_back_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_back_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/addDiscount", name="product_back_discount", methods={"GET","POST"})
     */
    public function addDiscount(Request $request, Product $product): Response
    {
        $form = $this->createForm(Product1Type::class, $product);
        $form->remove('name');
        $form->remove('description');
        $form->remove('image');
        $form->remove('category');
        $form->remove('Quantite');

        $form->add('Discount',NumberType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setPrice($product->getPrice()-($product->getPrice()*$product->getDiscount()/100));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_back/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }
}
