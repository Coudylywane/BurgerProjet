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

            return $this->redirectToRoute('catalogue');
        }

        return $this->render('burger/index.html.twig', [    
            'formBurger' => $formBurger->createView()
        ]);
        
    }


   /*  if ($form->isSubmitted()) {

       $manager->persist($burger)
       $manager->flush()
        
       return $this->redirectToRoute('app_ajoutburger');

    } */
  


   




}
