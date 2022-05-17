<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GestionnaireController extends AbstractController
{
    #[Route('/gestionnaire', name: 'app_gestionnaire')]
    public function index(): Response
    {
        return $this->render('gestionnaire/index.html.twig', [
            'controller_name' => 'GestionnaireController',
        ]);
    }

    #[Route('/tableau_bord', name: 'tableau_bord')]
    public function tableau_bord(): Response
    {
        return $this->render('gestionnaire/tableau_bord.html.twig', [
            'controller_name' => 'GestionnaireController',
        ]);
    }




    

   /*  #[Route('/ajout_produit', name: 'ajout_produit')]
    public function ajout_produit(): Response
    {
        $form = $this->createForm(BurgerType::class);
        return $this->render('gestionnaire/ajout_produit.html.twig', [
            'controller_name' => 'GestionnaireController',
        ]);
    } */

    #[Route('/lescommande', name: 'lescommande')]
    public function lescommande(): Response
    {
        return $this->render('gestionnaire/lescommande.html.twig', [
            'controller_name' => 'GestionnaireController',
        ]);
    }
}
