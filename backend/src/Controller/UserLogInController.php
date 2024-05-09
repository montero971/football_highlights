<?php

namespace App\Controller;

use App\Services\UserLogInService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
class UserLogInController extends AbstractController
{
    public function __construct(
        private UserLogInService $userLogInService,
    ) {
        $this->userLogInService = $userLogInService;
    }

    #[Route('/login', name: 'app_user_log_in', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $body = json_decode($request->getContent(), true);
            $login = $this->userLogInService->logIn($body);

            return $this->json(['User loged:' => $login], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
