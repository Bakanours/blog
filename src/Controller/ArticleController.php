<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("/tableaux", name="app_tableaux")
     */
    public function tableaux(): Response
    {
        return $this->render('article/tableaux.html.twig', [
            'controller_name' => 'ArticleController',
        ]);

    }

    /**
     * @Route ("article/{numero}", name="afficher_article")
     */
    public function afficher($numero) {

        /*return new Response(sprintf(
            'Page d\'affichage d\'un article "%s".', $numero
            )); */
        return $this->render('article/unarticle.html.twig', [
            'controller_name' => 'ArticleController',
            'numero' => $numero,
        ]);
    }
    /**
     * @Route("/article/{numero}/vote/{direction}", name="votes")
     */
    public function vote($numero, $direction){
         if($direction === 'up') {
             $currentVoteCount = rand(7, 50);
         } else {
             $currentVoteCount = rand(0, 5);
         }

         return $this->json(['votes' => $currentVoteCount]);

    }
}
