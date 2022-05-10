<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Repository\BurgerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function catalogue(BurgerRepository $repo): Response
    {
        /* return $this->render('client/catalogue.html.twig', [
            'controller_name' => 'ClientController',
        ]); */

        $burgers=$repo->findAll();
        return $this->render('client/catalogue.html.twig',[
          "burgers"=> $burgers,
        ]);
    }

    #[Route('/catalogue', name: 'catalogueC')]
    public function catalogueC(BurgerRepository $repo): Response
    {
        return $this->render('client/catalogue_c.html.twig', [
            'controller_name' => 'ClientController',
        ]);

        /* $burgers=$repo->findAll();
        return $this->render('client/catalogue.html.twig',[
          "burgers"=> $burgers,
        ]); */
    }

    #[Route('/commande', name: 'commande')]
    public function commande(): Response
    {
        return $this->render('client/commande.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    /* #[Route('liste', name: 'classe_liste')]
    public function index(ClasseRepository $repo): Response
    {
        $classes=$repo->findAll();
        return $this->render('classe/liste.html.twig',[
          "classes"=> $classes
        ]);
    } */

}
