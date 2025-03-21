<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CategoryController extends AbstractController
{
    #[Route('/add_category', name: 'add_category')]
    public function index(EntityManagerInterface $entityManager,  Request $request): Response
    {

        //persist sert à mettre en file d'attente ce qui va aller
        //en base de données
        //ATTENTION  --> je ne peux pas persist le vide,
        //forcement une entitiée
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
        }

        // $entityManager->persist($category);
        // $entityManager->flush();
        // //rien besoin en paramètre ! il exécute juste la file d'attente 


        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form->createView(),
        ]);
    }


    #[Route('/remove_category/{id}', name: 'remove_category')]
    public function removeCategory(int $id, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        // Vérifier si la catégorie existe
        // $category = $entityManager->getRepository(Category::class)->find($id);
        $category = $categoryRepository->find($id);
        if (!$category) { //une page d'erreur pour me dire que la catégorie demandée n'existe pas
            throw $this->createNotFoundException('La catégorie demandée n\'existe pas.');
        }

        // Supprimer l'entité
        $entityManager->remove($category);
        $entityManager->flush();

        // Rediriger vers la category
        return $this->redirectToRoute('home_index');
    }


    #[Route('/edit_category/{id}', name: 'edit_category')]
    public function editCategory(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository
    ): Response {
        // Récupérer la catégorie par son ID
        $category = $categoryRepository->find($id);

        if (!$category) {
            throw $this->createNotFoundException('La catégorie demandée n\'existe pas.');
        }

        // Création du formulaire
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Redirection après la modification
            return $this->redirectToRoute('home_index'); // À adapter si nécessaire
        }

        // Afficher le formulaire dans la vue
        return $this->render('category/edit.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }


    // //En vérifiant dans la base de donnée de ma table category, mon label de la category à bien été supprimer  
    // #[Route('/edit_category/{id}', name: 'edit_category')]
    // public function editCategory(int $id, Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    // {
    //     // Vérifier si la catégorie existe
    //     // $category = $entityManager->getRepository(Category::class)->find($id);
    //     $category = $categoryRepository->find($id);
    //     if (!$category) {
    //         throw $this->createNotFoundException('La catégorie demandée n\'existe pas.');
    //     }



    //     // Editer l'entité
    //     // $category->setLabel('toto');
    //     // $entityManager->persist($category);
    //     // $entityManager->flush();

    //     // Rediriger vers la category
    //     return $this->redirectToRoute('home_index');
    // }
}
