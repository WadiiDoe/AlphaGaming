<?php

namespace App\Controller;

use App\Entity\Fidelite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FideliteController extends AbstractController
{
    /**
     * @Route("/fidelitre", name="fidelitre")
     */
    public function index(): Response
    {
        return $this->render('fidelite/fidelite.html.twig', [
            'controller_name' => 'FideliteController',
        ]);
    }
    /**
     * @Route("/fidelitelist", name="fidelitelist")
     */
    public function fidelitelist(){

        $fidelitelist=$this->getDoctrine()->getRepository(Fidelite::class)->findAll();

        return $this->render('fidelite/fidelitelist.html.twig', [
            'fidelitelist' => $fidelitelist
        ]);

    }
    /**
     * @Route("/fidelite/{id}", name="fidelite")
     */
    public function afficherfidelite($id){

        $fidelite=$this->getDoctrine()->getRepository(Fidelite::class)
            ->find($id );

        return $this->render('fidelite/fidelite.html.twig', [
            'fidelite' => $fidelite
        ]);

    }
}
