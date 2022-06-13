<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Paiement;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    #[Route('/commandes', name: 'app_commande')]
    public function index(CommandeRepository $commandeRepository): Response
    {
        $commandes = $commandeRepository->findAll();
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/valider/{id}', name: 'valider')]
    public function valider(Commande $commande, EntityManagerInterface $manager):Response{
        $commande ->setEtat('valider');
        $manager->flush();
        return $this->redirectToRoute("app_commande");  
    }

    #[Route('/annuler/{id}', name: 'annuler')]
    public function annuler(Commande $commande, EntityManagerInterface $manager):Response{
        $commande ->setEtat('annuler');
        $manager->flush();
        return $this->redirectToRoute("app_commande");  
    }







}
