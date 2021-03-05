<?php

namespace App\Controller;

use App\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event")
     */
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }
    /**
     * @Route("/listEvent", name="listEvent")
     */
    public function listEvent(){

        $listEvent=$this->getDoctrine()->getRepository(Evenement::class)->findAll();

        return $this->render('event/listEvent.html.twig', [
            'listStudent' => $listEvent
        ]);

    }

    /**
     * @route("/evenement/{id}", name="evenement")
     */

    public function afficherEvent($id){

        $evenement=$this->getDoctrine()->getRepository(Evenement::class)->find($id );

        return $this->render('event/evenement.html.twig', [
            'evenement' => $evenement
        ]);

    }


    /**
     * @Route("/addevent", name="add_event")
     */
    public function ajouter(Request $req): Response
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = new Evenement();
        $form = $this->createFormBuilder($evenement)->add('nom', TextType::class)->add('description', TextType::class)->add('adresse', TextType::class)->add('prix', TextType::class)->add('date', DateType::class)->add('Ajouter', SubmitType::class, ['label' => 'Ajouter'])->getForm();
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $evenement = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('listEvent');
        }

        return $this->render('event/ajouterEvent.html.twig' , ['form' => $form->createView()

        ]);
        }

}