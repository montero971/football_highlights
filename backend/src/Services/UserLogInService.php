<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserLogInService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function logIn(array $body): User
    {
        $user = $this->findUserByEmail($body['email']);

        if (!$this->passwordHasher->isPasswordValid($user, $body['password'])) {
            throw new Exception("Incorrect password");
        }

        return $user;
    }

    private function findUserByEmail($email): User
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            throw new Exception("$email is not registered");
        }

        return $user;
    }
}
