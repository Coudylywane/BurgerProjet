<?php

namespace App\Controller;


use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use App\Repository\CommandeRepository;
use App\Repository\ComplementRepository;
use App\Repository\PaiementRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ContainerBoLhxUK\PaginatorInterface_82dac15;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{


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

    


    #[Route('/commande', name: 'commande')]
    public function commande(CommandeRepository $commandeRepository , PaginatorInterface $paginatorInterface , Request $request): Response
    {
        $idUser = array_values((array)$this->getUser())[0];
        $commandes = $paginatorInterface->paginate
        (
            $commandeRepository->findBy(['users'=>$idUser]),
            $request->query->getInt('page',1),
            5
        );
        return $this->render('client/commande.html.twig', [
            'commandes' => $commandes,
        ]);
    }

   /*  #[Route('/voirCommande/{id}', name: 'voir_commande')]
    public function voirCommande( $id , CommandeRepository $commandeRepository , Request $request,PaginatorInterface $paginatorInterface, ComplementRepository $complementRepository): Response
    {
        $etat = 'true';
        $complements =  $complementRepository->findBy(['etat'=>'en cours']);
        $idUser = array_values((array)$this->getUser())[0];
        $commandes = $paginatorInterface->paginate
        (
            $commandeRepository->findBy(['users'=>$idUser]),
            $request->query->getInt('page',1),
            2
        );
        $commandess = $commandeRepository->findBy(['id'=>$id]);
        return $this->render('client/commande.html.twig', [
            'commandess' => $commandess,
            'commandes' => $commandes,
            'complements'=> $complements,
            'etat'=> $etat,
        ]);
    } */



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

    #[Route('/paiement', name: 'imam')]
    public function imam(CommandeRepository $commandeRepository , Request $request, PaiementRepository $paiementRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        $data = $request->request->all();
        extract($data);
       if (isset($payer)) {
         foreach ($payer as $value) {
             $paiement[] = $commandeRepository->find($value);
         }

            foreach ($paiement as $val) {
            $commandeValide[]= [
                'paiements' => $paiementRepository ->find($val->getPaiements()),
                'montant' => $val->getMontant(),
            ];
         }

        /*  foreach ($commandeValide as $vale) {
            $vale['paiements'] -> setMontantPaiement($vale['montant']);
            $entityManagerInterface->persist( $vale['paiements'] );
            $entityManagerInterface-> flush();
         } */

         $session = $request ->getSession();
         $session ->set('payer' , $payer);
         return $this->render('client/detail.commande.html.twig', [
           'paiement' => $paiement,
        ]);

       }
       return $this->redirectToRoute('commande');   
    }

    




    #[Route('/detailCommande', name: 'voir_commande')]
    public function voirCommande(Request $request , CommandeRepository $commandeRepository , PaiementRepository $paiementRepository ,EntityManagerInterface $entityManagerInterface ): Response
    {
        $session = $request->getSession();
        $payer = $session->get("payer");
        $method = $request->getMethod();
        if ($method == 'POST') {
            foreach ($payer as $value) {
                $paiement[] = $commandeRepository->find($value);
            }

            foreach ($paiement as $val) {
                $commandeValide[]= [
                    'paiements' => $paiementRepository ->find($val->getPaiements()),
                    'montant' => $val->getMontant(),
                ];
             }

              foreach ($commandeValide as $vale) {
            $vale['paiements'] -> setMontantPaiement($vale['montant']);
            $entityManagerInterface->persist( $vale['paiements'] );
            $entityManagerInterface-> flush();
         } 

             
        }

        return $this->redirectToRoute('commande');   

    } 
      
    } 

    

 


