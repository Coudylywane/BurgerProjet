<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
