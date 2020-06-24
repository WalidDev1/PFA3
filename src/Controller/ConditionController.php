<?php

namespace App\Controller;

use App\Entity\Condition;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConditionController extends AbstractController
{
    
    /**
     * @Route("/condition", name="condition")
     */
    public function index(Request $request , ObjectManager $manager )
    {
        $statue = "C" ;
        $Condition = new Condition();
        if($request->request->count() > 0 ){
            $Condition->setDescription($request->request->get("var"));
            $manager->persist($Condition);
            $manager->flush();
        }
        $repoA = $this->getDoctrine()->getRepository(Condition::class);
        $Condition = $repoA->findAll();
        return $this->render('condition/index.html.twig', [
            'controller_name' => 'ConditionController',
            'statue' =>  $statue  ,
            'Condition' => $Condition,
        ]);
    }

   
}
