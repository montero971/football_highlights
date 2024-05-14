<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserSignUpService
{
    const INACTIVE = 0;

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
    public function userSignUp(array $body): User
    {
        $user = new User();
        $user->setFirstName($body['firstName']);
        $user->setLastName($body['lastName']);
        $user->setTeam($body['team']);
        $user->setSubscribed((int)$body['subscribed']);

        $this->suscribedWithEmptyTeam($user->getSubscribed(), $user->getTeam());

        $user->setActive(self::INACTIVE);

        if ($this->isUserAlreadyRegistered($body['email'])) throw new \Exception('Email already exists', 409);

        $user->setEmail($body['email']);
        if ($body['password'] === '') {
            $user->setPassword(null);
        } else {
            $user->setPassword($this->encodePassword($user, $body['password']));
        }
        $user->setActivationToken($this->jwtManager->create($user));


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

    public function encodePassword(User $user, string $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password);
    }

    public function suscribedWithEmptyTeam(int $suscribed, string $team): bool
    {
        if ($suscribed === 1 && empty($team))
            throw new Exception('You have ticked the box to receive notifications, but we do not know your team, please, let us know your colours');

        return false;
    }

    public function isUserAlreadyRegistered(string $email): bool
    {
        return $this->userRepository->findOneBy(['email' => $email]) !== null;
    }
}
