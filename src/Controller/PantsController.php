<?php

namespace App\Controller;

use App\Entity\Pants;
use App\Form\PantsType;
use App\Repository\BrandRepository;
use App\Repository\PantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PantsController extends AbstractController{
    #[Route('/add_pants', name: 'add_pants')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {

        $pants = new Pants();
        $form = $this->createForm(PantsType::class, $pants);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pants);
            $entityManager->flush();
        }


        return $this->render('pants/index.html.twig', [
            'controller_name' => 'PantsController',
            'form' => $form->createView(),
        ]);
    }


    #[Route('/edit_pants/{id)', name: 'edit_pants')]
    public function editPants(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        PantsRepository $pantsRepository
    ): Response  {
        // Récupérer la catégorie par son ID
        $pants = $pantsRepository->find($id);

        if (!$pants) {
            throw $this->createNotFoundException('Le pantalon demandée n\'existe pas.');
        }

        // Création du formulaire
        $form = $this->createForm(PantsType::class, $pants);
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Redirection après la modification
            return $this->redirectToRoute('home_index'); // À adapter si nécessaire
        }

        // Afficher le formulaire dans la vue
        return $this->render('pants/edit.html.twig', [
            'form' => $form->createView(),
            'name' => $pants,
            'description' => $pants,
            'price' => $pants,
        ]);
    }

    #[Route('/remove_pants/{id}', name: 'remove_pants')]
    public function removePants(int $id, EntityManagerInterface $entityManager, PantsRepository $pantsRepository): Response
    {
        // Vérifier 
   
        $pants = $pantsRepository->find($id);
        if (!$pants) { 
            throw $this->createNotFoundException('Le pantalon demandée n\'existe pas.');
        }

        // Supprimer l'entité
        $entityManager->remove($pants);
        $entityManager->flush();

        // Rediriger 
        return $this->redirectToRoute('home_index');
    }
}
