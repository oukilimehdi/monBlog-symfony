<?php

namespace App\Controller;



use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

}
