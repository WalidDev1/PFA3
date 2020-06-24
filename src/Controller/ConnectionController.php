<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class ConnectionController extends AbstractController
{
    /**
     * @Route("/connection", name="connection")
     */
    public function index()
    {
        return $this->render('connection/index.html.twig', [
            'controller_name' => 'ConnectionController',
        ]);
    }

     /**
     * @Route("/")
     */
    public function Connection()
    {
        return $this->render('connection/index.html.twig', [
            'controller_name' => 'ConnectionController',
        ]);
    }

    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
         // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('connection/index.html.twig', [
        'last_username' => $lastUsername,
        'error'         => $error,
    ]);
    }

    /**
     * @Route("/Deconnection" , name="Deconnection")
     */
    public function Deconnection()
    {
        $this->User->delete;
    }
}
