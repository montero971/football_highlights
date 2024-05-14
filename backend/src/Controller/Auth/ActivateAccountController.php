<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Services\Auth\ActivateAccountService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
class ActivateAccountController extends AbstractController
{
    public function __construct(private ActivateAccountService $activateAccountService) {
        $this->activateAccountService = $activateAccountService;
    }

    #[Route('/activateaccount/{token}', name: 'app_user_activate_account', methods: ['GET'])]
    public function activateAccount(Request $request)
    {
        $this->activateAccountService->activateAccount($request->get('token'));
        return $this->redirect($_ENV['REACT_APP_URL']);
    }
}
