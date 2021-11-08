<?php

namespace App\Controller;



use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(ArticleRepository $articleRepo): Response
    {
        $user = $this->getUser();
        $articles = $articleRepo->findBy(["user" => $user->getId()]);

        return $this->render('user/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/ajout_article", name="ajout_article")
     */
    public function ajoutArticle(Request $request){

        $article = new Article();
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $article = new Article;
            $article = $form->getData();
            $user = $this->getUser();
            $article->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('user/ajoutArticle.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
