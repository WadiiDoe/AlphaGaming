<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Entity\Rating;
use App\Form\RateFormType;
use App\Form\RatingFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JeuxController extends AbstractController
{
    /**
     * @Route("/jeux", name="jeux")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'JeuxController',
        ]);
    }

    /**
     * @Route("/show_jeux", name="show_jeux")
     */
    public function afficher_serveur(){
        $list = $this->getDoctrine()->getRepository(Jeux::class)->findAll();
        return $this->render('jeux/afficher_jeux.html.twig', array('list'=>$list));
    }

    /**
     * @Route("/show_oneg/{id}", name="show_oneg")
     */
    public function afficher_un_jeux(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $jeux = $this->getDoctrine()->getRepository(Jeux::class)->find($id);
        $rating = $em->getRepository(Rating::class)->find($id);
        $form = $this->createForm(RatingFormType::class,$rating);
        $em->flush();
        return $this->render('jeux/afficher_detail_jeux.html.twig',[
            'Jeux'=> $jeux,
            'form_rate'=>$form->createView(),
        ]);
    }
   /* /**
     * @Route("/rate_jeux/{id}", name="rate_jeux")
     */
   /* public function update_rate(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $jeux = $em->getRepository(Jeux::class)->find($id);
        $form = $this->createForm(RateFormType::class,$jeux);
        var_dump($jeux->getRating());
        $form->handleRequest($request);

            echo "diviseur";
            var_dump($jeux->getRating());
            $em->flush();
            $this->redirectToRoute('show_jeux');


        return $this->render('jeux/rate_jeux.html.twig',[
            'form_rate'=>$form->createView(),
        ]);
    }*/



}
