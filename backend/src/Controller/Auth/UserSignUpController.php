<?php

namespace App\Controller\Auth;

use App\Services\Auth\SendGridService;
use App\Services\Auth\UserSignUpService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
class UserSignUpController extends AbstractController
{
    public function __construct(
        private UserSignUpService $userSignUpService,
        private SendGridService $sendGridService
    ) {
        $this->userSignUpService = $userSignUpService;
        $this->sendGridService = $sendGridService;
    }

    #[Route('/signup', name: 'app_user_sign_up', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $body = json_decode($request->getContent(), true);
            $newUser = $this->userSignUpService->userSignUp($body);

            $this->sendGridService->sendWelcomeEmail(/*$newUser->getEmail()*/'josemanuel.montero@agiliacenter.com', $newUser->getFirstName(), $newUser->getActivationToken());

            return $this->json(['New User:' => $newUser], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}