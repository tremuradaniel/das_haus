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
        echo xdebug_info();
        return $this->json([
            'message' => sprintf('Welcome to %s API!', $_ENV['APP_NAME'])
        ]);
    }
}
