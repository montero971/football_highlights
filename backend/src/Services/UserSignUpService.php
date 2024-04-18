<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserSignUpService
{
    public function __construct(
        private UserRepository $userRepository,
        private ValidatorInterface $validator
    ) {
        $this->userRepository = $userRepository;
    }
    public function userSignUp(array $body): User
    {
        $user = new User();
        $user->setFirstName($body['firstName']);
        $user->setLastName($body['lastName']);
        $user->setTeam($body['team']);
        $user->setSubscribed($body['subscribed']);
        
        if ($this->isUserAlreadyRegistered($body['email'])) throw new \Exception('Email already exists', 409);
        
        $user->setEmail($body['email']);
        $user->setPassword($body['password']);

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            $errorMessages = [];

            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            throw new \Exception(implode("\n", $errorMessages));
        }

        return $this->userRepository->save($user);
    }

    public function isUserAlreadyRegistered(string $email): bool
    {
        return $this->userRepository->findOneBy(['email' => $email]) !== null;
    }
}
