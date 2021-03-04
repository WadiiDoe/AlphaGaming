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
                $reservation->setIdevent($id);
                $reservation->setNbrplace($req->get('nbrplace'));
                try{
                    $em->persist($reservation);
                    $em->flush();
                    return $this->redirectToRoute('listEvent');

                }catch(ExceptionInterface $e){
                    $req->getSession()
                        ->getFlashBag()
                        ->add('error', 'Vous avez deja fait une reservation de cet evenement')
                    ;
                }


            }

        return $this->render('event/evenement.html.twig',array('evenement'=>$evenement));
    }
}
