<?php

namespace App\Controller;

use App\Entity\Jeux;

use App\Form\JeuxFormType;
use App\Repository\JeuxRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JeuxController extends AbstractController
{

    /**
     * @Route("/show_jeux", name="show_jeux")
     */
    public function afficher_serveur(){
        $list = $this->getDoctrine()->getRepository(Jeux::class)->findAll();
        return $this->render('jeux_front/afficher_jeux.html.twig', array('list'=>$list));
    }

    /**
     * @Route("/show_oneg/{id}", name="show_oneg")
     */
    public function afficher_un_jeux(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $jeux = $this->getDoctrine()->getRepository(Jeux::class)->find($id);
        $em->flush();
        return $this->render('jeux_front/afficher_detail_jeux.html.twig',[
            'Jeux'=> $jeux,
        ]);
    }


    /**
     * @Route("/admin_show_jeux", name="admin_show_jeux")
     */
    public function afficher_jeux(){
        $list = $this->getDoctrine()->getRepository(Jeux::class)->findAll();
        return $this->render("jeux_back/Afficher_jeux.html.twig",array('list'=>$list));
    }

    /**
     * @Route("/admin_add_jeux", name="admin_add_jeux")
     */
    public function ajouter_jeux(Request $request){

        $jeux = new Jeux();
        $form = $this->createForm(JeuxFormType::class,$jeux);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $file = $jeux->getImg();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $em = $this->getDoctrine()->getManager();
            $jeux->setImg($fileName);
            try{
                $file->move(
                    $this->getParameter('EventImage_directory'),
                    $fileName
                );

            }
            catch (FileNotFoundException $e){}
            $em->persist($jeux);
            $em->flush();
            $this->addFlash('notice','Jeux Ajouter avec succées');

            return $this->redirectToRoute("admin_add_jeux");
        }
        if ($form->isSubmitted() && $form->isValid()==false){
            $this->addFlash('error','Erreur! veuillez verifier vos données');
        }
        return $this->render("jeux_back/ajout2.html.twig",[
            "form_title" => "Ajouter un jeux",
            "form_jeux"=>$form->createView(),
        ]);

    }
    /**
     * @Route("/admin_change_jeux/{id}", name="admin_change_jeux")
     */
    public function modifier_jeux(Request $request, int $id){

        $em = $this->getDoctrine()->getManager();
        $jeux = $em->getRepository(Jeux::class)->find($id);
        $form = $this->createForm(JeuxFormType::class,$jeux);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ){
            $file = $jeux->getImg();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $em = $this->getDoctrine()->getManager();
            $jeux->setImg($fileName);
            try{
                $file->move(
                    $this->getParameter('EventImage_directory'),
                    $fileName
                );
            }
            catch (FileNotFoundException $e){
                $e->getMessage();
            }
            $em->flush();
            $this->addFlash('notice','Jeux modifier avec Succées');
            return $this->redirectToRoute("admin_show_jeux");
        }
        return $this->render("jeux_back/ajout2.html.twig",[
            "form_title"=> "modifier un jeux",
            "form_jeux"=>$form->createView(),
        ]);
    }

    /**
     * @Route("/admin_delete_jeux/{id}", name="admin_delete_jeux")
     */
    public function supprimer_jeux($id){
        $em = $this->getDoctrine()->getManager();
        $jeux = $em->getRepository(Jeux::class)->find($id);
        $em->remove($jeux);
        $em->flush();
        $this->addFlash('notice','Jeux Supprimer');
        return $this->redirectToRoute("admin_show_jeux");
    }

    /**
     * @Route("/listimprimer",name="listimprimer")
     */
    public function list2()
    {
        //récupérer tous les articles de la table article de la BD
        // et les mettre dans le tableau $articles


        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $inter = $this->getDoctrine()->getRepository(Jeux::class)->findAll();
        // Retrieve the HTML generated in our twig file
        $html = $this->render('jeux_back/imprimer.html.twig', ['inter' => $inter]);

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

    /**
     * @Route("/calendar", name="calendar")
     */
    public function index(JeuxRepository $jeux):Response
    {
        $events = $jeux->findAll();

        $tab = [];
        foreach ($events as $event){
            $tab[] = [
                'id'=>$event->getId(),
                'start'=>$event->getReleaseDate()->format('Y-m-d H:i:s'),
                //'end'=>$event->getEnd()->format('Y-m-d H:i:s'),
                'title'=>$event->getDescription(),
                'backgroundColor'=>$event->getBgColor(),
                'borderColor'=>$event->getBorderColor(),
                'textColor'=>$event->getTextColor(),
            ];
        }
        $data = json_encode($tab);

        return $this->render('jeux_back/calendar.html.twig', compact('data'));
    }


}
