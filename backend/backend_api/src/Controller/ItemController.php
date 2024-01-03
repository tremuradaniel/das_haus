<?php

namespace App\Controller;

use Throwable;
use RuntimeException;
use App\DTO\ItemListDTO;
use Psr\Log\LoggerInterface;
use App\Repository\ItemRepository;
use App\Model\Items\ItemListFiltersModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class ItemController extends AbstractController
{
    #[Route('/item', name: 'app_item')]
    public function index(Request $request, ItemRepository $repo, LoggerInterface $logger): JsonResponse
    {
        $error = false;
        try {
            $userIdentifier = $this->getUser()->getUserIdentifier();
            $filters = new ItemListFiltersModel($request->query->all(), $userIdentifier);
            $items = $repo->getUserItems($filters);            
            $totalSiteItems = $repo->getUserTotalSites($filters);
            $response = new ItemListDTO($items, $filters->getPage(), $totalSiteItems);
        } catch (RuntimeException $e) {
            $error = true;
            $response = $e->getMessage();
            $logger->error($e->getMessage(), $e->getTrace());
        } catch (Throwable $e) {
            $error = true;
            $response = "Something went wrong and we could not fetch the requested data. Please check the logs";
            $logger->error($e->getMessage(), $e->getTrace());
        }
        
        return $this->json(!$error ? $response->getResponse() : $response);
    }
}
