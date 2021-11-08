<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function index(ArticleRepository $articleRepo): Response
    {

        return $this->render('articles/index.html.twig', [
             'articles' => $articleRepo->findAll(['createdAt' => 'DESC']),
        ]);
    }

   /**
    * @Route("show/{id}", name="articles_show")
    */
    public function show($id, ArticleRepository $articleRepo)
    {
         $article = $articleRepo->findOneBy(["id" => $id]);
         if(!$article){
             return $this->redirectToRoute('articles');
         }

        return $this->render('articles/show.html.twig', [
             'article' => $article
            
        ]);

    }

}

