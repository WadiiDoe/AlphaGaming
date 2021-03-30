<?php

namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleFormType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/ajouter_article", name="ajouter_article")
     */
    public function ajouter_article(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $file = $article->getImgArticle();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $entityManager = $this->getDoctrine()->getManager();
            $article->setImgArticle($fileName);
            try{
                $file->move(
                    $this->getParameter('EventImage_directory'),
                    $fileName
                );

            }
            catch (FileNotFoundException $e){}
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('notice', 'Article ajouté');
            return $this->redirectToRoute('afficher_article');
        }
        if($form->isSubmitted() && $form->isValid()==false)
        {
            $this->addFlash('error', 'Verifier votre ajout');
        }

        return $this->render('article_back/ajouter_article.html.twig', [
            "form_title" => "Ajouter un article",
            "form_article" => $form->createView(),
        ]);
    }
    /**
     * @Route("/afficher_article", name="afficher_article")
     */
    public function afficher_article(Request $request, PaginatorInterface $paginator): Response
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->findAll();
        $article = $paginator->paginate(
            $article, /* query NOT result */
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('article_back/afficher_article.html.twig', [
            "articles" => $article,
        ]);
    }
    /**
     * @Route("/modifier_article/{id}", name="modifier_article")
     */
    public function modifier_article(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $article = $entityManager->getRepository(Article::class)->find($id);
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $file = $article->getImgArticle();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $article->setImgArticle($fileName);
            try{
                $file->move(
                    $this->getParameter('EventImage_directory'),
                    $fileName
                );
            }
            catch (FileNotFoundException $e){}
            $entityManager->flush();
            return $this->redirectToRoute('afficher_article');
        }

        return $this->render("article_back/ajouter_article.html.twig", [
            "form_title" => "Modifier un article",
            "form_article" => $form->createView(),
        ]);
    }
    /**
     * @Route("/supprimer_article/{id}", name="supprimer_article")
     */
    public function supprimer_article(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute("afficher_article");
    }
    /**
     * @Route("/statistics", name="statistics")
     */
    public function get_statistics()
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Article::class)->getstatsdata();
        $bardata= [['Day', 'Articles']];
        $max_count = -1;
        foreach ($data as $row){
            array_push($bardata,[$row['date_article']->format('Y-m-d'),$row['count']]);
            if ($row['count']>$max_count){
                $max_count = $row['count'];
                }
        }
        $bar = new BarChart();
        $bar->getData()->setArrayToDataTable(
            $bardata
        );
        $bar->getOptions()->setTitle('Number or articles per day');
        $bar->getOptions()->getHAxis()->setTitle('Number of articles');
        $bar->getOptions()->getHAxis()->setMinValue(0);
        $bar->getOptions()->getHAxis()->setTicks(range(0,$max_count,1));
        $bar->getOptions()->getVAxis()->setTitle('Day');
        $bar->getOptions()->setWidth(900);
        $bar->getOptions()->setHeight(500);
        return $this->render('article_back/stats.html.twig', array('piechart' => $bar));
    }


}
