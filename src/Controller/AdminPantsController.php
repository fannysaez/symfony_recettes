<?php

namespace App\Controller;

use App\Repository\PantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminPantsController extends AbstractController{
    #[Route('/admin/pants', name: 'admin_pants')]
    public function index(PantsRepository $pantsRepository): Response
    {

        $pants = $pantsRepository->findAll();

        return $this->render('admin_pants/index.html.twig', [
            'pants' => $pants,
        ]);
    }
}
