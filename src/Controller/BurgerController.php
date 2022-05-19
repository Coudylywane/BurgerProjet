<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Burger;
use App\Form\BurgerType;
use App\Repository\ImageRepository;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 *
 * @IsGranted("ROLE_GESTIONNAIRE")
 */

 
class BurgerController extends AbstractController
{
    #[Route('/burger', name: 'add_burger')]
    public function burger(?Burger $burger,Request $request, EntityManagerInterface $manager): Response
    {
        if(!$burger){
            $burger = new Burger();
        }
        $formBurger = $this->createForm(BurgerType::class,$burger);
        $formBurger ->handleRequest($request);

        if ($formBurger->isSubmitted()) {

            // on recupere les images transmises

            $images = $formBurger->get('image')->getData();

            foreach ($images as $image) {
                $fichier = md5(uniqid()). '.' .$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $img = new Image();
                $img->setNomImage($fichier);
                $burger->addImage($img);
            }

            $burger = $formBurger->getData();
            $manager -> persist($burger);
            $manager -> flush();

            return $this->redirectToRoute('list_burger');
        }

        return $this->render('burger/index.html.twig', [    
            'formBurger' => $formBurger->createView()
        ]);
        
    }




    #[Route('/list1', name: 'list_burger')]
    public function catalogue(BurgerRepository $repo): Response
    {
        $burgers= $repo->findBy(['etat' => 'en cours']);
        return $this->render('burger/burger.html.twig',[
          "burgers"=> $burgers
        ]);
    }  


    #[Route('/edite/{id}', name: 'modifier_burger')]
    public function modifier(?Burger $burger,Request $request, EntityManagerInterface $manager): Response
    {

        $formBurger = $this->createForm(BurgerType::class,$burger);
        $formBurger ->handleRequest($request);

        if ($formBurger->isSubmitted()) {

            // on recupere les images transmises

            $images = $formBurger->get('image')->getData();

            foreach ($images as $image) {
                $fichier = md5(uniqid()). '.' .$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $img = new Image();
                $img->setNomImage($fichier);
                $burger->addImage($img);
            }

            $burger = $formBurger->getData();
            $manager -> persist($burger);
            $manager -> flush();

            return $this->redirectToRoute('list_burger');
        }

        return $this->render('burger/index.html.twig', [ 
            'burger'=>$burger,   
            'formBurger' => $formBurger->createView()
        ]);
        
    }

    #[Route('/archiver/{id}', name: 'archiver_burger')]
        public function archive(Burger $burger, EntityManagerInterface $manager):Response{
            $burger ->setEtat('archiver');
            $manager->flush();
            return $this->redirectToRoute("liste_archiver");  
    }

    #[Route('/dess/{id}', name: 'desarchiver_burger')]
    public function desarchive(Burger $burger, EntityManagerInterface $manager):Response{
        $burger ->setEtat('en cours');
        $manager->flush();
        return $this->redirectToRoute("list_burger");  

    }  


    #[Route('/listarchiver', name: 'liste_archiver')]
    public function archiver(BurgerRepository $repo): Response
    {
        $burgers= $repo->findBy(['etat' => 'archiver']);
        return $this->render('burger/archiver.html.twig',[
          "burgers"=> $burgers
        ]);
    }
    
    




}
