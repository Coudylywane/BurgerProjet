<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Burger;
use App\Entity\Complement;
use App\Form\ComplementType;
use Doctrine\ORM\EntityManager;
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

class ComplementController extends AbstractController
{
    #[Route('/complement', name: 'add_complement')]
    public function index(?Complement $complement , Request $request , EntityManagerInterface $manager): Response
    {
        if (!$complement) {
            $complement = new Complement();
        }

        $formComplement = $this->createForm(ComplementType::class, $complement);
        $formComplement ->handleRequest($request);

        if ($formComplement->isSubmitted()) {

            // on recupere les images transmises

            $images = $formComplement->get('image')->getData();

            foreach ($images as $image) {
                $fichier = md5(uniqid()). '.' .$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $img = new Image();
                $img->setNomImage($fichier);
                $complement->addImage($img);
            }

            $complement = $formComplement->getData();
            $manager -> persist($complement);
            $manager -> flush();

            return $this->redirectToRoute('catalogue');
        }

        return $this->render('complement/index.html.twig', [
            'formComplement' => $formComplement->createView()
        ]);
    }


}
