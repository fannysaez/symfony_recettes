<?php

namespace App\Command;

use App\Entity\User;
use App\Entity\Pants;  // Utilise Pants pour les produits
use App\Entity\Category;  // Utilise Category pour les catégories
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:stats', description: 'Affiche les statistiques du site.')]
class StatsCommand extends Command
{

    public function __construct(
        private EntityManagerInterface $entityManager)
    {
        parent::__construct();
       
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Récupération des repositories
        $userRepository = $this->entityManager->getRepository(User::class);
        $pantsRepository = $this->entityManager->getRepository(Pants::class);  // Utilise Pants pour les produits
        $categoryRepository = $this->entityManager->getRepository(Category::class);  // Utilise Category pour les catégories

        // Nombre d'utilisateurs
        $userCount = $userRepository->count();
        $output->writeln("<info>Nombre d'utilisateurs :</info> $userCount");

        // Nombre de pantalons
        $pantsCount = $pantsRepository->count();
        $output->writeln("<info>Nombre de pantalons :</info> $pantsCount");

        // Liste des catégories
        $categories = $categoryRepository->findAll();
        $output->writeln("<info>Catégories de produits :</info>");
        foreach ($categories as $category) {
            $output->writeln(" - " . $category->getLabel());  
        }

        // Prix moyen des pantalons
        $avgPrice = $this->entityManager->createQuery('SELECT AVG(p.price) FROM App\\Entity\\Pants p')->getSingleScalarResult();
        $output->writeln("<info>Prix moyen des pantalons :</info> " . number_format((float)$avgPrice, 2, ',', ' ') . " €");

        return Command::SUCCESS;
    }
}
