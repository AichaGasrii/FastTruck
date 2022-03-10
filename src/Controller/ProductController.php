<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     */

    public function index(ProductRepository $productRepository,CategoryRepository $categoryRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file= $request->files->get('product')['image'];

            $uploads_directory=$this->getParameter('uploads_directory');
            $file_name=md5(uniqid())    . '.'   . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $file_name
            );
            $product->setImage($file_name);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }


/**
 * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
 */
public function edit(Request $request, Product $product): Response
{
    $form = $this->createForm(ProductType::class, $product);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $file= $request->files->get('product')['image'];

        $uploads_directory=$this->getParameter('uploads_directory');
        $file_name=md5(uniqid())    . '.'   . $file->guessExtension();
        $file->move(
            $uploads_directory,
            $file_name
        );
        $product->setImage($file_name);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('product_back_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('product/edit.html.twig', [
        'product' => $product,
        'form' => $form->createView(),
    ]);
}

/**
 * @Route("/{id}", name="product_delete", methods={"POST"})
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
}
