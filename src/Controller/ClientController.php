<?php

namespace App\Controller;


use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use App\Repository\ComplementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{

    /* #[Route('/', name: 'catalogue')]
    public function catalogue(BurgerRepository $repo , ComplementRepository $repocomplement , MenuRepository $repomenu): Response
    {

        if ($this->getUser()) {
            $role = $this->getUser()->getRoles();
        }else{
            $role = '';
        }
        $menus=$repomenu->findAll();
        $complements=$repocomplement->findAll();
        $burgers=$repo->findAll();
        return $this->render('client/catalogue.html.twig',[
          "burgers"=> $burgers,
          "complements"=> $complements,
          "menus"=> $menus,
          'role'    => $role
        ]);
    }   */

    #[Route('/', name: 'catalogue')]
    public function catalogue( BurgerRepository $repoBurger,MenuRepository $repoMenu): Response
    {

        if ($this->getUser()) {
            $role = $this->getUser()->getRoles();
        }else{
            $role = '';
        }

        $burgers = $repoBurger -> findBy(['etat'=>'en cours']);
        $menus = $repoMenu -> findBy(['etat'=>'en cours']);
        $catalogues = array_merge($burgers  , $menus);

        return $this->render('client/catalogue.html.twig', [
            'catalogues'=>$catalogues,
            'role'    => $role,

        ]);

    }

    

    


    #[Route('/catalogue', name: 'catalogueC')]
    /**
 *
 * @IsGranted("ROLE_USER")
 */
    public function catalogueC(BurgerRepository $repoBurger , MenuRepository $repoMenu): Response
    {

        $burgers = $repoBurger -> findBy(['etat'=>'en cours']);
        $menus = $repoMenu -> findBy(['etat'=>'en cours']);
        $catalogues = array_merge($burgers  , $menus);

        return $this->render('client/catalogue_c.html.twig',[
          "catalogues"=> $catalogues,
        ]);
    }

   



    #[Route('/commande', name: 'commande')]
    public function commande(): Response
    {
        return $this->render('client/commande.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }



    #[Route('/details/{id}', name: 'details')]
    public function details(int $id , BurgerRepository $repoBurger,
                            ComplementRepository $repoComplet,
                            MenuRepository $repoMenu): Response
    {
        $burgers = $repoBurger -> findBy(['etat'=>'en cours']);
        $complement = $repoComplet-> findBy(['etat'=>'en cours']);
        $menus = $repoMenu -> findBy(['etat'=>'en cours']);
        $catalogue = array_merge($burgers , $complement , $menus);

        foreach ($catalogue as $value) {
            if($value->getId()==$id){
                if($value->getType() == "menu"){
                    $details = $repoMenu->find($id);
                }elseif($value->getType() == "burger"){
                    $details = $repoBurger->find($id);
                }
            }
        }
        return $this->render('client/details.html.twig', [
            'details'=>$details,
        ]);

    }
    
      
    } 

    

 


