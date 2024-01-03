<?php

namespace App\Controller;

use Throwable;
use RuntimeException;
use App\DTO\ItemHistoryDTO;
use Psr\Log\LoggerInterface;
use App\Repository\ItemHistoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\ItemHistory\ItemHistoryFiltersModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class ItemHistoryController extends AbstractController
{
    #[Route('/item/{itemId}/history', name: 'app_item_history')]
    public function index(
        int $itemId,
        Request $request, 
        ItemHistoryRepository $repo, 
        LoggerInterface $logger
    ): JsonResponse {
        $error = false;
        try {
            $userIdentifier = $this->getUser()->getUserIdentifier();
            $params = $request->query->all();
            $params[ItemHistoryFiltersModel::ITEM_ID_KEY] = $itemId; 
            $filters = new ItemHistoryFiltersModel($params, $userIdentifier);
            $itemHistory = $repo->getUserItems($filters);            
            $totalSiteItems = $repo->getUserItemHistoryTotalInstances($filters);
            $response = new ItemHistoryDTO($itemHistory, $filters->getPage(), $totalSiteItems);
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
