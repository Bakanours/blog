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
    public function tabs(){
        $random_numbers = [rand(1,10)];
        var_dump("les tableaux seront ici");
        var_dump($random_numbers);
        die();

    }
}
