<?php

namespace App\Controller;

use App\Entity\Livraieur;
use App\Form\LivraieurType;
use App\Repository\LivraieurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/livraieur")
 */
class LivraieurController extends AbstractController
{
    /**
     * @Route("/", name="livraieur_index", methods={"GET"})
     * @param LivraieurRepository $livraieurRepository
     * @return Response
     */
    public function index(LivraieurRepository $livraieurRepository): Response
    {
        return $this->render('livraieur/index.html.twig', [
            'livraieurs' => $livraieurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="livraieur_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $livraieur = new Livraieur();
        $form = $this->createForm(LivraieurType::class, $livraieur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livraieur);
            $entityManager->flush();

            return $this->redirectToRoute('livraieur_index');
        }

        return $this->render('livraieur/new.html.twig', [
            'livraieur' => $livraieur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="livraieur_show", methods={"GET"})
     * @param Livraieur $livraieur
     * @return Response
     */
    public function show(Livraieur $livraieur): Response
    {
        return $this->render('livraieur/show.html.twig', [
            'livraieur' => $livraieur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="livraieur_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Livraieur $livraieur
     * @return Response
     */
    public function edit(Request $request, Livraieur $livraieur): Response
    {
        $form = $this->createForm(LivraieurType::class, $livraieur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('livraieur_index');
        }

        return $this->render('livraieur/edit.html.twig', [
            'livraieur' => $livraieur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="livraieur_delete", methods={"POST"})
     * @param Request $request
     * @param Livraieur $livraieur
     * @return Response
     */
    public function delete(Request $request, Livraieur $livraieur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livraieur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($livraieur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('livraieur_index');
    }
}
