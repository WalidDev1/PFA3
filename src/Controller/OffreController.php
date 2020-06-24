<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Signalement;
use App\Entity\User;
use App\Entity\Vendeur;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OffreController extends AbstractController
{
   
 

    /**
     * @Route("/offre", name="offre")
     * @Route("/offre/{idO}", name="offreID")
     */
    public function index(Vendeur $idO = null,ObjectManager $manager)
    {
        $Vendeur = null ;
        $repo1 = $this->getDoctrine()->getRepository(Signalement::class);
        $Signal = $repo1->findAll();
        $repo = $this->getDoctrine()->getRepository(User::class);
        $Users = $repo->findAll();
        if($idO != null ){
        $Vendeur = $this->getDoctrine()->getRepository(Vendeur::class)->find($idO);;
        if (!$Vendeur) {
            throw $this->createNotFoundException(
                'Erreur reseaux : Vendeur introuvable '.$idO
            );
        }
        $Offre = $Vendeur->getOffre();
        $isForCostumer = true ;
        }else{
        $isForCostumer = false ;
        $repo = $this->getDoctrine()->getRepository(Offre::class);
        $Offre = $repo->findAll();
        }



        $statue = "F" ;
        
        return $this->render('offre/index.html.twig', [
            'controller_name' => 'OffreController',
            'statue' => $statue,
            'offres' => $Offre , 
            'user' => $Users,
            'Vendeur' => $Vendeur ,
            'Signal' => $Signal,
            'isForCostumer' => $isForCostumer,
        ]);
    }

   /**
     * @Route("/offre/{idS}/Delete", name="DeleteOffre")
     */
    public function Delete( $idS = null , ObjectManager $manager){
        $Offre = $this->getDoctrine()
        ->getRepository(Offre::class)
        ->find($idS);
        $manager->remove($Offre);
        $manager->flush();
        return $this->redirectToRoute('offre');
    }

    /**
     * @Route("/offre/valide/{idV}", name="Valide")
     */
    public function Valide( $idV , ObjectManager $manager){
        $Offre = $this->getDoctrine()
        ->getRepository(Offre::class)
        ->find($idV);
        $Offre->setStatue("en ligne");
        $manager->flush();
        return $this->redirectToRoute('offre');
    }


  

  


    
}
