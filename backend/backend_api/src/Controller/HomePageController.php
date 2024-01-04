<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(Request $request): JsonResponse
    {
        $swaggerLocation = sprintf("%s:%s/swagger-ui", $request->getHost(), $request->getPort());
        return $this->json([
            'message' => sprintf('Welcome to %s API! Visit %s for api documentation', $_ENV['APP_NAME'], $swaggerLocation)
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
