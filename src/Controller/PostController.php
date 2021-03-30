<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostFormType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class PostController extends AbstractController
{
    // ...

    /**
     * @Route("/ajouter_post", name="ajouter_post")
     */
    public function ajouter_post(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);
        $date = new \DateTime('@'.strtotime('now'));
        $post->setDatePost($date);
        $post->setLikes(0);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
         {
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($post);
             $entityManager->flush();
             return $this->redirectToRoute('afficher_post');
         }

        return $this->render("post_front/ajouter_post.html.twig", [
            "form_title" => "Ajouter un post",
            "form_post" => $form->createView(),
        ]);
    }

    /**
     * @Route("/afficher_post", name="afficher_post")
     */
    public function afficher_post()
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();

        return $this->render('post_front/afficher_post.html.twig', [
            "posts" => $posts,
        ]);
    }
    /**
     * @Route("/modifier_post/{id}", name="modifier_post")
     */
    public function modifier_post(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $post = $entityManager->getRepository(Post::class)->find($id);
        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('afficher_post');
        }

        return $this->render("post_front/ajouter_post.html.twig", [
            "form_title" => "Modifier un post",
            "form_post" => $form->createView(),
        ]);
    }
    /**
     * @Route("/supprimer_post/{id}", name="supprimer_post")
     */
    public function supprimer_post(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $post = $entityManager->getRepository(Post::class)->find($id);
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute("afficher_post");
    }
    /**
     * @Route("/afficher_post/{id}", name="afficher_post_by_id")
     */
    public function afficher_post_by_id(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $post = $entityManager->getRepository(Post::class)->find($id);
        return $this->render('post_front/afficher_post_by_id.html.twig', [
            "post" => $post,
        ]);
    }
}
