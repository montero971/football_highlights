<?php

declare(strict_types=1);

namespace App\Services\Auth;

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
        $this->isFormEmpty($body['email'], $body['password']);

        $user = $this->findUserByEmail($body['email']);

        if (!$this->passwordHasher->isPasswordValid($user, $body['password']))
            throw new Exception("Incorrect password");

        if ($this->isInactiveUser($user))
            throw new Exception("Your account is not activated. Please activate it before signing in.");

        return $user;
    }

    private function findUserByEmail(string $email): User
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            throw new Exception("$email is not registered");
        }

        return $user;
    }

    private function isInactiveUser(User $user): bool
    {
        return !$user->getActive();
    }

    private function isFormEmpty(string $email, string $password): bool
    {
        if (empty($email) && empty($password)) {
            throw new Exception("Email and Password cannot be empty");
        }

        if (empty($email)) {
            throw new Exception("Email cannot be empty");
        }

        if (empty($password)) {
            throw new Exception("Password cannot be empty");
        }

        return false;
    }
}
