<?php

namespace App\Controller;

use App\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Asset\Package;


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
            'listEvent' => $listEvent
        ]);

    }
    /**
     * @Route("/listEventBack", name="listEventBack")
     */
    public function listEventBack(){

        $listEvent=$this->getDoctrine()->getRepository(Evenement::class)->findAll();

        return $this->render('event/listEventBack.html.twig', [
            'listEvent' => $listEvent
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
        $form = $this->createFormBuilder($evenement)
            ->add('nom', TextType::class)
            ->add('description', TextType::class)
            ->add('adresse', TextType::class)
            ->add('prix', TextType::class)
            ->add('nbrePlace', TextType::class)
            ->add('date', DateType::class)
            ->add('image', FileType::class)
            ->getForm();
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $file=$evenement->getImage();
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            $evenement = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $evenement->setImage($fileName);
            try{
                $file->move(
                    $this->getParameter('EventImage_directory'),
                    $fileName
                );

            }
            catch (FileNotFoundException $e){}
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('listEventBack');
        }

        return $this->render('event/ajouterEvent.html.twig' , ['form' => $form->createView()

        ]);
        }
        /**
         * @param $id
         * @Route("/supprimerevent/{id}",name="supprimerevent")
         */
    public function supprimer($id)
    {
        $em= $this->getDoctrine()->getManager();
        $evenement=$em->getRepository( Evenement::class)->find($id);
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute( "listEventBack");

    }

    /**
     * @Route("/modifierEvent/{id}", name="modifierEvent")
     */
    public function modifierEvent( Request $req , $id){
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);

        $form = $this->createFormBuilder ($evenement)
            ->add('nom', TextType::class)
            ->add('description', TextType::class)
            ->add('adresse', TextType::class)
            ->add('prix', TextType::class)
            ->add('nbrePlace', TextType::class)
            ->add('date', DateType::class)
            ->getForm();
        $form ->handleRequest($req);
        if ($form->isSubmitted()){
            $entity = $this->getDoctrine()->getManager();
            $entity->flush();
            return $this->redirectToRoute('listEventBack');
        }
        return $this->render('event/modifierEvent.html.twig' , [ 'form' => $form->createView()]);
    }
}