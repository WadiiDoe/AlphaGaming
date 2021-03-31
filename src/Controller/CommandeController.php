<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Form\CommandeType;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/", name="commande_index", methods={"GET"})
     * @param CommandeRepository $commandeRepository
     * @return Response
     */
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="commande_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $commande = new Commande();
        $produit = new Produit();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);
        $f = $this->createForm(ProduitType::class, $produit);
        $f->handleRequest($request);


        if ($form->isSubmitted() || $f->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($commande);
            $entityManager->flush();


            return $this->redirectToRoute('commande_index');
        }

        return $this->render('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
            'produits' => $produit,
            'f' => $f->createView(),

        ]);
    }

    /**
     * @Route("/{id}", name="commande_show", methods={"GET"})
     * @param Request $request
     * @param ProduitRepository $produitRepository
     * @param Commande $commande
     * @return Response
     */
    public function show(Request $request,ProduitRepository $produitRepository,Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,

        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Commande $commande
     * @return Response
     */
    public function edit(Request $request, Commande $commande): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_index');
        }

        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_delete", methods={"POST"})
     * @param Request $request
     * @param Commande $commande
     * @return Response
     */
    public function delete(Request $request, Commande $commande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_index');
    }
}
