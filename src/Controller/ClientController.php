<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Entity\Complement;
use App\Entity\Menu;
use App\Repository\BurgerRepository;
use App\Repository\ComplementRepository;
use App\Repository\MenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    
    #[Route('/', name: 'catalogue')]
    public function catalogue(BurgerRepository $repo , ComplementRepository $repocomplement , MenuRepository $repomenu): Response
    {
        /* return $this->render('client/catalogue.html.twig', [
            'controller_name' => 'ClientController',
        ]); */
        if ($this->getUser()) {
            $role = $this->getUser()->getRoles();
        }else{
            $role = '';
        }
        $menus=$repomenu->findAll();
        $complements=$repocomplement->findAll();
        $burgers=$repo->findAll();
        return $this->render('client/catalogue.html.twig',[
          "burgers"=> $burgers,
          "complements"=> $complements,
          "menus"=> $menus,
          'role'    => $role
        ]);
    }  







    


    #[Route('/catalogue', name: 'catalogueC')]
    public function catalogueC(BurgerRepository $burger): Response
    {
       /*  return $this->render('client/catalogue_c.html.twig', [
            'controller_name' => 'ClientController',
        ]); */

        $burgers=$burger->findAll();
        return $this->render('client/catalogue_c.html.twig',[
          "burgers"=> $burgers,
        ]);
    }

   



    #[Route('/commande', name: 'commande')]
    public function commande(): Response
    {
        return $this->render('client/commande.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/details/{id}', name: 'details')]
     public function details(int $id , BurgerRepository $burges): Response
    {
            
        /* dump($id);
        die; */
    $burgers=$burges->findBy(['id' => $id]);
    return $this->render('client/details.html.twig',[
        "burgers"=> $burgers,
    ]);; 
    
        /* return $this->render('client/details.html.twig', [
            'controller_name' => 'ClientController',
        ]); */
    } 

 

}
