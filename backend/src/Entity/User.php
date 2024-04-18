<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: "firstname", length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Firstname cannot be empty")]
    #[Assert\Type(type: "string", message: "Firstname must be a string")]
    private ?string $firstName = null;

    #[ORM\Column(name: "lastname", length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Lastname cannot be empty")]
    #[Assert\Type(type: "string", message: "Lastname must be a string")]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Email cannot be empty")]
    #[Assert\Email(message: "Incorrect email format")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Password cannot be empty")]
    #[Assert\Length(
        min: 8,
        minMessage: "Password must contain at least {{ limit }} characters.",
    )]
    #[Assert\Regex(
        pattern: "/^(?=.*[A-Z])(?=.*[!@#$%^&*])/",
        message: "Password must contain at least a capital letter and a symbol."
    )]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\Type(type: "string", message: "Team must be a {{ type }}")]
    private ?string $team = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Assert\Type(type: "int", message: "Subscribed must be a {{ type }} (0 o 1)")]
    #[Assert\Range(min: 0, max: 1, notInRangeMessage: "Subscribed must be {{ min }} or {{ max }}")]
    private ?int $subscribed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getTeam(): ?string
    {
        return $this->team;
    }

    public function setTeam(string $team): static
    {
        $this->team = $team;

        return $this;
    }

    public function getSubscribed(): ?int
    {
        return $this->subscribed;
    }

    public function setSubscribed(?int $subscribed): static
    {
        $this->subscribed = $subscribed;

        return $this;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
