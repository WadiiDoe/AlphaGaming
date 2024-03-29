<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Reservation;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\False_;
use ProxyManager\Exception\ExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }






    /**
     * @Route("/reserverEvent/{id}", name="reserverEvent")
     */
    public function reserverEvent(Request $req ,$id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        // $connectedUser= fonction li t5arajlk user connectee session
            $reservation = new Reservation();
            $reservation->setUser($user);

        if($req->isMethod("post")) {
                $reservation->setIdevent($evenement);
                $nbredeticketDemandé=(int)($req->get('nbrplace'));
                $reservation->setApprouve(0);


                if( $nbredeticketDemandé <= $evenement->getNbrePlace()){
                    $reservation->setNbrPlace($nbredeticketDemandé);
                    $evenement->setNbrePlace(($evenement->getNbrePlace())-(int)($req->get('nbrplace')));
                }
                else {
                    return $this->redirectToRoute('reserverEvent', array('id'=>$id));
                }
                try{
                    $em->persist($reservation);
                    $em->flush();
                    return $this->redirectToRoute('listEvent');

                }catch(ExceptionInterface $e){
                }


            }

        return $this->render('event/evenement.html.twig',array('evenement'=>$evenement));
    }







    /**
     * @Route("/listreservation/{id}", name="afficherReservation")
     */
    public function listReservationByEvent($id){
        $event=$this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $listReservation=$this->getDoctrine()->getRepository(Reservation::class)->findBy(array('idevent'=>$event));
        return $this->render('event/listReservation.html.twig',array('reservations'=>$listReservation));

    }







    /**
     * @Route("/listreser", name="listReservation")
     */
    public function listReservation(){
        $listReservation=$this->getDoctrine()->getRepository(Reservation::class)->findAll();

        return $this->render('event/listReser.html.twig',array('reservations'=>$listReservation));

    }






    /**
     * @param $id
     * @Route("/approuverReservation/{id}",name="approuverReservation")
     */
    public function approuverReservation($id,\Swift_Mailer $mailer)
    {
        $em= $this->getDoctrine()->getManager();
        $reservation=$em->getRepository( Reservation::class)->find($id);
        //£connectedUser
        $reservation->setApprouve(1);
        $message = (new \Swift_Message('Validation Réservation'))
            ->setFrom('wadii.jhinaoui@esprit.tn')
            ->setTo('sanadelfaleh@gmail.com')
            ->setBody(
                $this->renderView(
                // templates/emails/confirmation_mail.html.twig
                    'reservation/confirmation_mail.html.twig'
                ),
                'text/html'
            );
        $em->merge($reservation);
        $em->flush();
        $mailer->send($message);
        return $this->redirectToRoute('listReservation',array('id'=>$id));

    }



}

