<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
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

   /**
    * @Route("update/{id}", name="articles_update")
    */
    public function update($id, ArticleRepository $articleRepo, Request $request)
    {
        $article = $articleRepo->findOneBy(["id" => $id]);
        if(!$article){
            return $this->redirectToRoute('articles');
        }

        $user = $this->getUser();
        $article = $articleRepo->findOneBy(["user" => $user->getId()]);
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $article = new Article;
            $article = $form->getData();
            $user = $this->getUser();
            $article->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('user/modifierArticle.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);

    }
   /**
    * @Route("delete/{id}", name="articles_delete")
    */
    public function delete($id, ArticleRepository $articleRepo, Request $request)
    {
       
        $article = $articleRepo->findOneBy(["id" => $id]);
        if(!$article){
            return $this->redirectToRoute('articles');
        }

        $em= $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        $this->addFlash('articleSuprime', "votre article a bien été suprimé");

        return $this->redirectToRoute('user');

    }




}

