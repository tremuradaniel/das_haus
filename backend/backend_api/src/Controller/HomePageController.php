<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => sprintf('Welcome to %s API!', $_ENV['APP_NAME'])
        ]);
    }

    #[Route('/api/test', name: 'test')]
    public function test(): JsonResponse
    {
        return $this->json([
            'message' => sprintf('Welcome to %s API!', $_ENV['APP_NAME'])
        ]);
    }
}
