<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Product;
use App\Repository\ProductRepository;
class RechercheController extends AbstractController
{
    /**
     * Creates a new ActionItem entity.
     *
     * @Route("/search", name="ajax_search")
     * @method Product[]    findAll()
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('recherche/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $requestString = $request->get('Product');

        $entities =  $em->getRepository('App:Entity')->findEntitiesByString($requestString);

        if(!$entities) {
            $result['entities']['error'] = "aucun produit trouvé";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }

        return new Response(json_encode($result));

    }

    public function getRealEntities($entities){

        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = $entity->getName();
        }

        return $realEntities;
    }
}
