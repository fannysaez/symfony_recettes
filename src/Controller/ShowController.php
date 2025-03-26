<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShowController extends AbstractController{
    #[Route('/show_index', name: 'show_index')]
    public function index(): Response
    {
        return $this->render('show/index.html.twig', [
            'controller_name' => 'ShowController',
        ]);
    }
}
