<?php

namespace App\Controller;

use App\Services\ScorebatVideoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ScorebatVideoController extends AbstractController
{
    public function __construct(private ScorebatVideoService $scorebatVideoService)
    {
        $this->scorebatVideoService = $scorebatVideoService;
    }

    #[Route('/scorebat/highlights', name: 'app_scorebat_video', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json($this->scorebatVideoService->getRecentFeed(), Response::HTTP_OK);
    }
}
