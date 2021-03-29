<?php

namespace App\Controller;

use App\Entity\Serveur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServeurController extends AbstractController
{
    /**
     * @Route("/serveur", name="serveur")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'ServeurController',
        ]);
    }


    /**
     * @Route("/show_sv", name="show_sv")
     */
    public function afficher_sv(){
        $serveurs = $this->getDoctrine()->getRepository(Serveur::class)->findAll();
        return $this->render('serveur/afficher_sv.html.twig', array('serveurs'=>$serveurs));
    }
}
