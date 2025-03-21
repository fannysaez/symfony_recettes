<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AdminBrandController extends AbstractController{
    #[Route('/admin/brand', name: 'admin_brand')]
    public function index(BrandRepository $brandRepository): Response
    {
        $brands = $brandRepository->findAll();

        return $this->render('admin_brand/index.html.twig', [
            'brands' => $brands,
        ]);
    }
}