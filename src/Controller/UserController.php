<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Agence;
use App\Entity\User;
use App\Entity\Vendeur;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Integer;
use PhpParser\Node\Expr\Cast\Int_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    
    /**
     * @Route("/user", name="user")
     * @Route("/user/{id}", name="DeletAdmin")
     */
    public function index(Admin $adminD = null ,Request $request , ObjectManager $manager,UserPasswordEncoderInterface $encoder)
    {
        $statue = "U" ;
        $repo = $this->getDoctrine()->getRepository(Vendeur::class);
        $repoAdmin = $this->getDoctrine()->getRepository(Admin::class);
        $Vendeurs = $repo->findAll();
        $Admins = $repoAdmin->findAll();
        $repoA = $this->getDoctrine()->getRepository(Agence::class);
        $Agences = $repoA->findAll();
        $user = $this->get('security.token_storage')->getToken()->getUser();
       if($request->request->count() > 0 &&  $adminD != null && $request->request->get("Newpassword") != ""){
        
        $hash = $encoder->encodePassword($adminD , $request->request->get("Newpassword"));
        $adminD->setPassword($hash);
        $manager->flush();
        return $this->redirectToRoute('user');
       }else if($adminD !=null && $adminD->getPseudo() != "walid_soussi" && $adminD->getPseudo() != $user->getPseudo()){
            
            $manager->remove($adminD);
            $manager->flush();
            return $this->redirectToRoute('user');
        }
        if($request->request->count() > 0 &&  $adminD == null){
            $Admin = new Admin;
            $Admin->setPseudo($request->request->get("pseudo"));
            $Admin->setPassword($request->request->get("password"));
            $hash = $encoder->encodePassword($Admin , $Admin->getPassword());
            $Admin->setPassword($hash);
            $manager->persist($Admin);
            $manager->flush();
            return $this->redirectToRoute('user');
        }
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'statue' => $statue,
            'Vendeurs' => $Vendeurs,
            'Admins' => $Admins,
            'Agences' => $Agences,
        ]);
    }

    /**
     * @Route("/user/{id}/bane", name="bane")
     */
    public function Banned(User $userB, ObjectManager $manager){
        if( $userB->getBanne() == 0 ){
            $userB->setBanne(1);
        }else{
            $userB->setBanne(0);
        }
        $manager->flush();
        return $this->redirectToRoute('user');
    }

     /**
     * @Route("/user/{idV}/{idU}", name="Delete")
     */
    public function Delete( $idV,  $idU , ObjectManager $manager){
        $Vendeur = $this->getDoctrine()
        ->getRepository(Vendeur::class)
        ->find($idV);
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($idU);
        $manager->remove($Vendeur);
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('user');
    }
   
}
