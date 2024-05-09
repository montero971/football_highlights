<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserSignUpService
{
    public function __construct(
        private UserRepository $userRepository,
        private ValidatorInterface $validator,
        private UserPasswordHasherInterface $passwordHasher,
        private JWTTokenManagerInterface $jwtManager
    ) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->jwtManager = $jwtManager;
    }
    public function userSignUp(array $body): array
    {
        $user = new User();
        $user->setFirstName($body['firstName']);
        $user->setLastName($body['lastName']);
        $user->setTeam($body['team']);
        $user->setSubscribed((int)$body['subscribed']);

        if ($this->isUserAlreadyRegistered($body['email'])) throw new \Exception('Email already exists', 409);

        $user->setEmail($body['email']);

        $user->setPassword($this->encodePassword($user, $body['password']));

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            $errorMessages = [];

            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            throw new \Exception(implode("\n", $errorMessages));
        }

        $newUser = $this->userRepository->save($user);

        return [$newUser, $this->jwtManager->create($newUser)];
    }

    public function encodePassword(User $user, string $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password);
    }

    public function isUserAlreadyRegistered(string $email): bool
    {
        return $this->userRepository->findOneBy(['email' => $email]) !== null;
    }
}
