<?php
namespace App\Service\Cart;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;



class CartService{

    protected $session;
    public function __construct(SessionInterface $session, ProductRepository $productRepository) {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function add(int $id){

        $panier = $this->session->get('panier' , []);
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }
       
        $this->session->set('panier' , $panier);
       

    }

    public function remove(int $id){
        $panier = $this->session->get('panier' , []);

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }
        $this->session->set('panier', $panier);
    }
    public function getFullCart():array {

        $panier = $this->session->get('panier' , []);
        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $panierWithData;
    }

    public function  getTotal():float {

        $total = 0;
        $panierWithData = $this->getFullCart();
        foreach($panierWithData as $item){
            $totalItem = $item['product']->getUnitPrice() * $item['quantity'];
            $total += $totalItem;
        }
        return $total;
    }




}