<?php

namespace App\Controller;

use App\Services\SendGridService;
use App\Services\UserSignUpService;
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
        $body = json_decode($request->getContent(), true);
        $newUser = $this->userSignUpService->userSignUp($body);

        $this->sendGridService->sendWelcomeEmail($newUser->getEmail(), $newUser->getFirstName());

        return $this->json(['New user:' => $newUser], Response::HTTP_CREATED);
    }
}
