<?php

namespace App\Controller;

use App\Entity\Developers;
use App\Entity\Jobs;
use App\Service\GreedyAlgorithmService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class DashboardController extends AbstractController
{
    public function __construct(
        private GreedyAlgorithmService $greedyAlgorithmService,
        private EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/', name: 'app_dashboard', methods: ['GET'])]
    public function index()
    {
        $developers = $this->entityManager->getRepository(Developers::class)->findAll();
        $jobs = $this->entityManager->getRepository(Jobs::class)->findAll();

        $result = $this->greedyAlgorithmService->calculateBest($developers,$jobs);

        return $this->render('dashboard/index.html.twig', [
            'data' => $result,
        ]);
    }
}
