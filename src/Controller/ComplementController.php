<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Burger;
use App\Entity\Complement;
use App\Form\ComplementType;
use App\Repository\ComplementRepository;
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
            $complement = new Complement();
        

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

            return $this->redirectToRoute('list_complement');
        }

        return $this->render('complement/index.html.twig', [
            'formComplement' => $formComplement->createView()
        ]);
    }


    #[Route('/list3', name: 'list_complement')]
    public function catalogue(ComplementRepository $repo): Response
    {
        $complements= $repo->findBy(['etat' => 'en cours']);
        return $this->render('complement/complement.html.twig',[
          "complements"=> $complements
        ]);
    }

    #[Route('/editer/{id}', name: 'modifier')]
    public function modifier(?Complement $complement , Request $request , EntityManagerInterface $manager): Response
    {
        
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

            return $this->redirectToRoute('list_complement');
        }

        return $this->render('complement/index.html.twig', [
            'complement'=> $complement,
            'formComplement' => $formComplement->createView()
        ]);

        
    }

    #[Route('/archive/{id}', name: 'archiver_complement')]
        public function archive(Complement $complement, EntityManagerInterface $manager):Response{
            $complement ->setEtat('archiver');
            $manager->flush();
            return $this->redirectToRoute("list_archiver");  
  
    }

    #[Route('/desarchiver/{id}', name: 'desarchiver_complement')]
    public function desarchive(Complement $complement, EntityManagerInterface $manager):Response{
        $complement ->setEtat('en cours');
        $manager->flush();
        return $this->redirectToRoute("list_complement");  

}


    #[Route('/listar', name: 'list_archiver')]
    public function list(ComplementRepository $repo): Response
    {
        $complements= $repo->findBy(['etat' => 'archiver']);

        return $this->render('complement/archiver.html.twig',[
          "complements"=> $complements
        ]);
    }


}
