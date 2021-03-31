<?php

namespace App\Controller;

use App\Entity\Evenement;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Asset\Package;


use Symfony\Component\Routing\Annotation\Route;


class EventController extends Controller
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
    public function listEvent(Request $request ,PaginatorInterface $paginator):Response
    {

        $AlllistEvent=$this->getDoctrine()->getRepository(Evenement::class)->findAll();
        // Paginate the results of the query
        $listEvent= $paginator->paginate(
        // Doctrine Query, not results
            $AlllistEvent,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
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
            ->add('nom', TextType::class, [
                'attr'=> [
                    'placeholder' =>'Nom event',
                    'class'=> 'form-control'
                ]
            ])
            ->add('description', TextType::class,[
                'attr'=>[
                    'placeholder' => 'Description',
                    'class' => 'form-control',
                    'required'=> false
                ]
            ])

            ->add('prix', TextType::class,[
                'attr'=> [
                    'placeholder' => 'Prix',
                    'class' =>'form-control',
                    'type' => 'number',
                    'step'=>'any',
                    'empty_data'=> '0'
                ]
            ])
            ->add('nbrePlace', TextType::class,[
                'attr'=>[
                    'placeholder' => 'capacité',
                    'class' =>'form-control',
                    'type' => 'number',
                    'empty_data'=> '0'
                ]
            ])
            ->add('date', DateType::class,[
                'widget' => 'single_text',
                'attr' =>[
                    'class' => 'form-control',
                    'placeholder'=> 'dd/mm/yyyy',
                    'type'=>'date'
                ]
            ])
            ->add('image', FileType::class, [
                'attr' => ['class' => 'form-control'],
            ])


            ->getForm();
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $file=$evenement->getImage();
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            $evenement = $form->getData();
            $evenement->setAdresse($req->get('adresse'));
            $evenement->setLongitude($req->get('longitude'));
            $evenement->setLatitude( $req->get('latitude'));

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
            ->add('nom', TextType::class,[
                'attr'=> [
                    'placeholder' =>'Nom event',
                    'class'=> 'form-control'
                ]
            ])
            ->add('description', TextType::class,[
                'attr'=>[
                    'placeholder' => 'Description',
                    'class' => 'form-control',
                    'required'=> false
                ]
            ])
            ->add('adresse', TextType::class,[
                'attr'=> [
                    'placeholder' =>'adresse',
                    'class'=> 'form-control'
                ]
            ])
            ->add('prix', TextType::class,[
                'attr'=> [
                    'placeholder' => 'Prix',
                    'class' =>'form-control',
                    'type' => 'number',
                    'step'=>'any',
                    'empty_data'=> '0'
                ]
            ])
            ->add('nbrePlace', TextType::class,[
                'attr'=>[
                    'placeholder' => 'capacité',
                    'class' =>'form-control',
                    'type' => 'number',
                    'empty_data'=> '0'
                ]
            ])
            ->add('date', DateType::class,[
                'widget' => 'single_text',
                'attr' =>[
                    'class' => 'form-control',
                    'placeholder'=> 'dd/mm/yyyy',
                    'type'=>'date'
                ]
            ])
            ->getForm();
        $form ->handleRequest($req);
        if ($form->isSubmitted()) {
            $entity = $this->getDoctrine()->getManager();
            $entity->flush();
            return $this->redirectToRoute('listEventBack');
        }
        return $this->render('event/modifierEvent.html.twig' , [ 'form' => $form->createView()]);
    }
}