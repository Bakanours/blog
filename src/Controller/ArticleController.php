<?php

namespace App\Controller;

//use http\Client\Request;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }


    #[Route('/tableaux', name: 'app_tableaux')]
    public function tableaux()
    {
        return $this->render('article/tableaux.html.twig', [
            'controller_name' => 'ArticleController',
        ]);

    }


    #[Route('article/{id}', name: 'afficher_article')]
    public function afficher(Article $article): Response {

        /*return new Response(sprintf(
            'Page d\'affichage d\'un article "%s".', $numero
            )); */
        //$repository = $entityManager->getRepository(Article::class);
        //$article = $repository->find($id);

        return $this->render('article/unarticle.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/article/{numero}/vote/{direction}', name: 'votes')]
    public function vote($numero, $direction){
         if($direction === 'up') {
             $currentVoteCount = rand(7, 50);
         } else {
             $currentVoteCount = rand(0, 5);
         }

         return $this->json(['votes' => $currentVoteCount]);

    }

    #[Route('/article/{id}/voter', name: 'article_vote', methods: "POST")]
    public function articleVote(Article $article, Request $request, EntityManagerInterface $entityManager){
        $direction = $request->request->get('direction');
        if($direction === 'up'){
            $article->setVotes($article->getVotes() + 1);
        }elseif ($direction === 'down'){
            $article->setVotes($article->getVotes() - 1);
        }
        $entityManager->flush();

        return $this->redirectToRoute('afficher_article', ['id'=>$article->getId()]);

    }

    #[Route('/savearticle', name: 'save-article')]
    public function saveArticle(EntityManagerInterface $entityManager){
        $article = new Article();
        $article->setTitre('Mon premier article');
        $article->setContenu("Contenu random d'un article random numero 3.");
        $article->setDatecreation(new \DateTime("01/01/2021"));

        $entityManager->persist($article);
        $entityManager->flush($article);

        return $this->redirectToRoute('afficher_article', ['id'=>$article->getId()]);


    }

    #[Route('/all', name: 'all_articles')]
    Public function allArticles(EntityManagerInterface $entityManager)
    {

        $repository = $entityManager->getRepository(Article::class);
        $allarticles = $repository->findAll();

        return $this->render('article/allarticles.html.twig', [
            'controller_name' => 'ArticleController',
            'allarticles' => $allarticles,
        ]);
    }

    //sauver mes categories en db, hardcodé
    #[Route('/savecategorie', name: 'save-categorie')]
    public function saveCategorie(EntityManagerInterface $entityManager)
    {
        $categorie = new Categorie();
        $categorie->setNomDeCategorie('Catégorie 5');

        $entityManager->persist($categorie);
        $entityManager->flush();

        return $this->redirectToRoute('all_articles');
    }
    // test pour mettre mes articles dans une categorie, comment update mes articles en ajoutant une categorie ?

    #[Route('/cat1', name: 'cat-1')]
    public function categorize(EntityManagerInterface $entityManager){

        $repository = $entityManager->getRepository(Article::class);
        $article = $repository->find(1);
        // comment ecrire pour que l'article ait la categorie 1 ? $article->addCategory(id=1);
        $repositoryCat = $entityManager->getRepository(Categorie::class);
        $categorie = $repositoryCat->find(1);
        $article->setCategorie($categorie);

        $entityManager->persist($article);
        $entityManager->flush();

        return $this->redirectToRoute('all_articles');

    }

    //formulaires

    #[Route('/addArticle', name:'add_article')]
    public function addArticle(Request $request, EntityManagerInterface $entityManager) : Response {
        $article = new Article();
        $article->setDatecreation(new \DateTime());
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // remplir article avec les donnees du form
            $article = $form->getData();
            //ajouter à la DB
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            //si tout est bon affiche le nouvel article
            return $this->redirectToRoute('afficher_article', ['id'=>$article->getId()]);
        }

        return $this->render('article/addArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
