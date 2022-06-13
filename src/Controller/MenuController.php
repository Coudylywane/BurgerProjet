<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Image;
use App\Form\MenuType;
use App\Repository\ComplementRepository;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    public function add(?Menu $menu , Request $request , EntityManagerInterface $manager , ComplementRepository $complementRepo): Response
    {
        if(!$menu){
           $menu = new Menu();
        }

         $datas= $request->request->all();
       // extract($datas); 
            
        $complement = $complementRepo->findBy(['etat'=>'en cours']);
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

            // dd($datas['complements']);

             foreach ($datas['complements'] as  $value) {
                $coche = $complementRepo->find($value);
                $menu->addComplement($coche);
                
            } 

            $menu = $formMenu->getData();
            $manager -> persist($menu);
            $manager -> flush();  
            return $this->redirectToRoute('list_menu');
        }
        
        return $this->render('menu/index.html.twig', [
            'formMenu' => $formMenu->createView(),
            'complement'=>$complement,
        ]);
    }

    #[Route('/list2', name: 'list_menu')]
    public function catalogue(MenuRepository $repo , ComplementRepository $complementRepo , PaginatorInterface $paginatorInterface , Request $request): Response
    {
        
       $complement =  $complementRepo->findBy(['etat'=>'en cours']);
       $menus = $paginatorInterface->paginate(
        $repo->findBy(['etat'=>'en cours']),
        $request->query->getInt('page',1),
        3
    );
        return $this->render('menu/menu.html.twig',[
            'complements' => $complement,
            "menus"=> $menus
        ]);
    }

    #[Route('/edit/{id}', name: 'modif')]
    public function edit(?Menu $menu , Request $request , EntityManagerInterface $manager , ComplementRepository $complementRepo): Response
    {

         $datas= $request->request->all();
        // extract($datas); 
            
        $complement = $complementRepo->findBy(['etat'=>'en cours']);
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

            // dd($datas['complements']);

            foreach ($datas['complements'] as  $value) {
                $coche = $complementRepo->find($value);
                $menu->addComplement($coche);
                
            }

            $menu = $formMenu->getData();
            $manager -> persist($menu);
            $manager -> flush();  
            return $this->redirectToRoute('list_menu');
        }
        
        return $this->render('menu/index.html.twig', [
            'formMenu' => $formMenu->createView(),
            'complement'=>$complement,
            'menu'=>$menu,
        ]);
    }

    #[Route('/archiverr/{id}', name: 'archiverr')]
    public function archive(Menu $menu, EntityManagerInterface $manager):Response{
        $menu ->setEtat('archiver');
        $manager->flush();
        return $this->redirectToRoute("lister_archiver");  

    }

    #[Route('/archi', name: 'lister_archiver')]
    public function archiver(MenuRepository $repo): Response
    {
        $menus=$repo->findBy(['etat'=>'archiver']);
        return $this->render('menu/archive.html.twig',[
          "menus"=> $menus
        ]);
    }

    #[Route('/desarchiverr/{id}', name: 'desarchiverr')]
    public function desarchive(Menu $menu, EntityManagerInterface $manager):Response{
        $menu ->setEtat('en cours');
        $manager->flush();
        return $this->redirectToRoute("list_menu");  

    }






    


}
