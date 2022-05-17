<?php

namespace App\Controller;

use App\Repository\BurgerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CartController extends AbstractController
{
    #[Route('/panier', name: 'cart_index')]
    public function index(SessionInterface $session , BurgerRepository $burgerRepository): Response
    {

        $panier = $session->get('panier',[]);

        $panierWithData =[];

        foreach ( $panier as $id => $quantity) {
            $panierWithData[]=[
                'burger' =>  $burgerRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total =0;

        foreach ($panierWithData as $item) {
           $totalItem = $item['burger']->getPrixBurger() * $item['quantity'];
           $total += $totalItem;
        }

      /*   dd($panierWithData);  */

        return $this->render('cart/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total
        ]);
    }




    #[Route('/panier/add/{id}', name: 'cart_add')]
    public function add($id , SessionInterface $session): Response
    {
 
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        }else{
            $panier[$id] =1;
        }

        $session->set('panier',$panier);

        return $this->redirectToRoute("catalogue"); 
    }

    #[Route('/panier/remove/{id}', name: 'cart_remove')]
    public function remove($id , SessionInterface $session): Response
    {
 
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
           unset($panier[$id]);
        }

        $session->set('panier' , $panier);

        return $this->redirectToRoute("cart_index");

    }


    
}
