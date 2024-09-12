<?php

namespace App\Controller\Developers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DevelopersController extends AbstractController
{
    #[Route('/developers', name: 'get_developers', methods: ['GET'])]
    public function index(): JsonResponse
    {

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DevelopersController.php',
        ]);
    }
}
