<?php

namespace App\Controller;

use Throwable;
use SiteListFiltersModel;
use App\Repository\SiteRepository;
use Psr\Log\LoggerInterface;
use RuntimeException;
use SiteListDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class SiteController extends AbstractController
{
    #[Route('/site', name: 'app_site')]
    public function index(Request $request, SiteRepository $repo, LoggerInterface $logger): JsonResponse
    {
        $error = false;
        try {
            $userIdentifier = $this->getUser()->getUserIdentifier();
            $filters = new SiteListFiltersModel($request->query->all(), $userIdentifier);
            $sites = $repo->getSitesForListing($filters);
            $totalUserSites = $repo->getUserTotalSites($userIdentifier);
            $response = new SiteListDTO($sites, $filters->getPage(), $totalUserSites);
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
