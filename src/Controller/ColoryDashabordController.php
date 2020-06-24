<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ColoryDashabordController extends AbstractController
{
    /**
     * @Route("/colory/dashabord", name="colory_dashabord")
     */
    public function index()
    {
        $statue = "D" ;
        return $this->render('colory_dashabord/index.html.twig', [
            'controller_name' => 'ColoryDashabordController',
            'statue' => $statue,
        ]);
    }

   
}
