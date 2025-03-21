<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

final class BrandController extends AbstractController{
    #[Route('/add_brand', name: 'add_brand')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {

        $brand = new Brand();

        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($brand);
            $entityManager->flush();
        }


        return $this->render('brand/index.html.twig', [
            'controller_name' => 'BrandController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit_brand/{id}', name: 'edit_brand')]
    public function editCategory(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        BrandRepository $brandRepository
    ): Response {
        // Récupérer la catégorie par son ID
        $brand = $brandRepository->find($id);

        if (!$brand) {
            throw $this->createNotFoundException('La marque demandée n\'existe pas.');
        }

        // Création du formulaire
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Redirection après la modification
            return $this->redirectToRoute('home_index'); // À adapter si nécessaire
        }

        // Afficher le formulaire dans la vue
        return $this->render('brand/edit.html.twig', [
            'form' => $form->createView(),
            'label' => $brand,
        ]);
    }

    #[Route('/remove_brand/{id}', name: 'remove_brand')]
    public function removeBrand(int $id, EntityManagerInterface $entityManager, BrandRepository $brandRepository): Response
    {
        // Vérifier 
        // $category = $entityManager->getRepository(Category::class)->find($id);
        $brand = $brandRepository->find($id);
        if (!$brand) { //une page d'erreur pour me dire que la catégorie demandée n'existe pas
            throw $this->createNotFoundException('La marque demandée n\'existe pas.');
        }

        // Supprimer l'entité
        $entityManager->remove($brand);
        $entityManager->flush();

        // Rediriger 
        return $this->redirectToRoute('home_index');
    }

}

