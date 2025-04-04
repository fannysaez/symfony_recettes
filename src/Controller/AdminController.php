<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'title' => 'Espace Administrateur',
        ]);
    }
}
