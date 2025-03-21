<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminCategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'admin_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        // Récupérer toutes les catégories
        $category = $categoryRepository->findAll();


        // Rendre le template avec les catégories
        return $this->render('admin_category/index.html.twig', [
            'categories' => $category,
        ]);
    }
}
