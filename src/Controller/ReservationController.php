<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Reservation;
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
        $em = $this->getDoctrine()->getManager();
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
            $reservation = new Reservation();
            if($req->isMethod("post")) {
                $reservation->setIduser("1");
                $reservation->setIdevent($evenement);
                $nbredeticketDemandé=(int)($req->get('nbrplace'));

                if( $nbredeticketDemandé < $evenement->getNbrePlace()){
                    $reservation->setNbrPlace($nbredeticketDemandé);
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
}
