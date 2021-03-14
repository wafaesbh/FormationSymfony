<?php

namespace App\Controller;

use App\Repository\ProductRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
USE App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * find Product By Id
     * @Route("/product/{id}", name="productDetails"))
     * @param ProductRepository $productRepository
     * @param int $id
     * @return Response
     */
    public function findProductById(ProductRepository  $productRepository,int $id):Response
    {
        $product = $productRepository->find($id);
        /*if(!$product){
            throw $this->createNotFoundException(
                'No product found !!'
            );
        }*/
        return $this->render('product/productDetails.html.twig', [
        'controller_name' => 'ProductController',
        'product' => $product
    ]);

    }

    public  function getRelatedProducts(ProductRepository  $productRepository):Response
    {
        $products = $productRepository->getRelatedProducts();
        return $this->render('product/productDetails.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products
        ]);
    }

    /**
     * @Route("/search" , name ="search")
     * @param Request $request
     * @param ProductRepository $repository
     * @return Response
     */
   public  function search(Request  $request , ProductRepository  $repository):Response
   {
       $q = $request->query->get('q');
       dump($q);
       $products = $repository->search(['term' => $q,
       ]);
       return $this->render('default/index.html.twig',[
           'products'=>$products,
       ]);
   }






}
