<?php

namespace App\Controller;

use App\Entity\Serveur;
use App\Form\ServeurFormType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServeurController extends AbstractController
{


    /**
     * @Route("/show_sv", name="show_sv")
     */
    public function afficher_sv(){
        $serveurs = $this->getDoctrine()->getRepository(Serveur::class)->findAll();
        return $this->render('serveur_front/afficher_sv.html.twig', array('serveurs'=>$serveurs));
    }


    /**
     * @Route("/admin_add_sv", name="admin_add_sv")
     */
    public function ajouter_serveur(Request $request){

        $sv= new Serveur();
        $form= $this->createForm(ServeurFormType::class,$sv);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($sv);
            $em->flush();
            $this->addFlash('notice','Serveur Ajouter avec Succées');
            return $this->redirectToRoute('admin_show_sv');

        }
        if ($form->isSubmitted() && $form->isValid()==false){
            $this->addFlash('error','Erreur! veuillez verifier vos données');
        }

        return $this->render('serveur_back/ajout_serveur.html.twig',[
            'form_title'=>'Ajouter un Serveur',
            'form_sv'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/admin_show_sv", name="admin_show_sv")
     */
    public function afficher_serveur(){
        $list = $this->getDoctrine()->getRepository(Serveur::class)->findAll();
        return $this->render('serveur_back/afficher_serveur.html.twig',[
            'list'=>$list]);
    }

    /**
     * @Route("/admin_delete_sv/{id}", name="admin_delete_sv")
     */
    public function supprimer_serveur (Request $request,int $id):Response
    {
        $em= $this->getDoctrine()->getManager();
        $sv = $em->getRepository(Serveur::class)->find($id);
        $em->remove($sv);
        $em->flush();
        $this->addFlash('notice','Serveur supprimer avec Succées');
        return $this->redirectToRoute('admin_show_sv');

    }

    /**
     * @Route("/admin_change_sv/{id}", name="admin_change_sv")
     */
    public function modifier_jeux(Request $request,int $id){
        $em = $this->getDoctrine()->getManager();
        $sv = $em->getRepository(Serveur::class)->find($id);
        $form = $this->createForm(ServeurFormType::class,$sv);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ){
            $em->flush();
            $this->addFlash('notice','Serveur modifier avec Succées');
            return $this->redirectToRoute("admin_show_sv");

        }
        return $this->render("serveur_back/ajout_serveur.html.twig",[
            "form_title"=> "Modifier un serveur",
            "form_sv"=>$form->createView(),
        ]);

    }

    /**
     * @Route("/listimprimer",name="listimprimer")
     */
    public function list2()
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $inter = $this->getDoctrine()->getRepository(Serveur::class)->findAll();
        // Retrieve the HTML generated in our twig file
        $html = $this->render('serveur_back/imprimer.html.twig', ['inter' => $inter]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);


    }
}
