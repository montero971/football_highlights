<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Repository\UserRepository;

class ActivateAccountService
{
    const ACTIVE = 1;

    public function __construct(private UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function activateAccount(string $token)
    {
        $user = $this->userRepository->findOneBy(['activationToken' => $token]);

        if (!$user) {
            throw new \Exception('Token does not match with DB token');
        }
        
        $user->setActive(self::ACTIVE);
        $this->userRepository->save($user);

        return $user;
    }
}
