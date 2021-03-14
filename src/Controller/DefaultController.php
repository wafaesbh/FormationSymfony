<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

class DefaultController extends AbstractController
{
    /**
     * @param ProductRepository $repository
     * @Route("/", name="default")
     */
    public function index(ProductRepository $repository): Response
    {
        $categories = $repository->findAll();
        return $this->render('default/index.html.twig', [
            
            // 'products' => $repository->getProductWithHeigherQuantity(-1, 15),
            'products' => $repository->findAll(),
            'categories' => $categories
        ]);
    }
    /**
     *
     *
     * @return Response
     */
    function brands():Response{
        return $this->render( 'default/brand.html.twig',[
            'brands' => [
                'Nike' => 29,
                'Puma' => 10,
                'Adidas' =>8
            ],
        ]);
    }
    /**
     * get all gategories from db
     *
     * @return void
     */
    // function getCategories(){
    //     $repo = $this->getDoctrine()->getRepository(Category::class);
    //     $categories = $repo->findAll();
    //     return $this->render('default/index.html.twig', [
    //         'categories' => $categories
    //     ]);
    // }
}
