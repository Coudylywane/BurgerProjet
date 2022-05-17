<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Image;
use App\Form\MenuType;
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
class MenuController extends AbstractController
{
    #[Route('/menu', name: 'add_menu')]
    public function add(?Menu $menu , Request $request , EntityManagerInterface $manager ): Response
    {
        if(!$menu){
           $menu = new Menu();
        }

        $formMenu = $this->createForm(MenuType::class,$menu);
        $formMenu ->handleRequest($request);

        if ($formMenu->isSubmitted()) {

            // on recupere les images transmises

            $images = $formMenu->get('image')->getData();

            foreach ($images as $image) {
                $fichier = md5(uniqid()). '.' .$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $img = new Image();
                $img->setNomImage($fichier);
                $menu->addImage($img);
            }

            $menu = $formMenu->getData();
            $manager -> persist($menu);
            $manager -> flush();

            return $this->redirectToRoute('catalogue');
        }
        
        return $this->render('menu/index.html.twig', [
            'formMenu' => $formMenu->createView(),
        ]);
    }


}
