<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;
use App\Service\Cart\CartService;


class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(CartService $cartService): Response
    {
        $panierWithData = $cartService->getFullCart();
        $total = $cartService->getTotal();
       
        
        return $this->render('cart/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total
        ]);
        return $total;
    }

    /**
     * add product to shopping cart
     *@Route("/panier/add/{id}" , name="add")
     * @param [type] $id
     * @return void
     */
    public function add($id , CartService $cartService)
    {
       $cartService->add($id);
        return $this->redirectToRoute('panier');
    }

    /**
     * Remove product from cart
     *@Route("/panier/remove/{id}" , name ="remove")
     * @param [type] $id
     * @param SessionInterface $session
     * @return void
     */
    public function remove($id, CartService $cartService){
        $cartService->remove($id);
        
        return $this->redirectToRoute("panier");
    }
}
