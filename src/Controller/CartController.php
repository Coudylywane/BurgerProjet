<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Paiement;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CartController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/panier', name: 'cart_index')]
    public function index( SessionInterface $session , BurgerRepository $burgerRepository , MenuRepository $menuRepository , Request $request ,UserRepository $userRepository , EntityManagerInterface $entityManager): Response
    {
        $method = $request->getMethod();

        $commande = new Commande();

        $paiement = new Paiement();

            $panier = $session->get('panier',[]);

            $panierWithData =[];
            $idMenus = [];
            $idBurgers = [];


        
            foreach ( $panier as $id => $quantity) {
                if (str_contains($id , 'burger')) {
                    $idBurgers [] = (int) filter_var($id , FILTER_SANITIZE_NUMBER_INT);
                }else {
                    $idMenus[] = (int) filter_var($id , FILTER_SANITIZE_NUMBER_INT);
                }
                $panierWithData[]=[
                    'burger' =>str_contains($id , "burger") ? $burgerRepository->find($id) :$menuRepository->find($id) ,
                    'quantity'=> $quantity
                ];
    
            }
    
            $total =0;
    
            foreach ($panierWithData as $item) {
               $totalItem = $item['burger']->getPrix() * $item['quantity'];
               $total += $totalItem;
            }
            
            if ($method == 'POST') {
                $date = date_format(date_create() , 'Y-m-d');
                $idUser = array_values((array)$this->getUser())[0];
                $user = $userRepository->find($idUser);

    
                $paiement->setMontantPaiement(0);
                $commande->setDate($date) 
                        ->setNumero(rand())
                        ->setUsers($this->getUser())
                        ->setMontant($total)
                        ->setPaiements($paiement);
                   
                if(count($idBurgers) > 0){
                    foreach ($idBurgers as $val) {
                        $commande->addBurger($burgerRepository->find($val));
                    }
                } 

               
                    if(count($idMenus) > 0){
                        foreach ($idMenus as $val2) {
                            $commande->addMenu($menuRepository->find($val2));
                        }
                    } 
                

                
                   
                $entityManager->persist($paiement);
                $entityManager->persist($commande);
                $entityManager->flush();
                $session->remove('panier',[]);
                return $this->redirectToRoute("commande");
            }
        
       

        

         
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


    #[Route('/panier/a/{id}', name: 'plus')]
    public function plus($id , SessionInterface $session): Response
    {


            $panier = $session->get('panier', []);


        if (!empty($panier[$id])) {
            $panier[$id]++;
        }else{
            $panier[$id] =1;
        }

        $session->set('panier',$panier);

        return $this->redirectToRoute("cart_index"); 
    }

    
    #[Route('/panier/ad/{id}', name: 'moins')]
    public function moins($id , SessionInterface $session): Response
    {

        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]--;
        }else{
            $panier[$id] =1;
        }

        $session->set('panier',$panier);

        return $this->redirectToRoute("cart_index"); 
    }  
}



