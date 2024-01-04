<?php

namespace App\Controller;

use Throwable;
use SiteListDTO;
use RuntimeException;
use SiteListFiltersModel;
use Psr\Log\LoggerInterface;
use App\Repository\SiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $responseCode = Response::HTTP_OK;
        try {
            $userIdentifier = $this->getUser()->getUserIdentifier();
            $filters = new SiteListFiltersModel($request->query->all(), $userIdentifier);
            $sites = $repo->getSitesForListing($filters);
            $totalUserSites = $repo->getUserTotalSites($userIdentifier);
            $response = new SiteListDTO($sites, $filters->getPage(), $totalUserSites);
        } catch (RuntimeException $e) {
            $error = true;
            $response = $e->getMessage();
            $responseCode = Response::HTTP_BAD_REQUEST;
            $logger->error($e->getMessage(), $e->getTrace());
        } catch (Throwable $e) {
            $error = true;
            $response = "Something went wrong and we could not fetch the requested data. Please check the logs";
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $logger->error($e->getMessage(), $e->getTrace());
        }
        
        return $this->json(!$error ? $response->getResponse() : $response, $responseCode);
    }
}
