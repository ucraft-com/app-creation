<?php

declare(strict_types=1);

namespace App\Entity;




final class User
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @var string
     */
    private string $firstName;

    /**
     * @var string
     */
    private string $lastName;

    /**
     * @var string
     */
    private string $username;
    /**
     * @var string
     */
    private string $email;

    /**
     * @var string|null
     */
    private ?string $emailVerifiedAt;

    public function getUserIdentifier(): string
    {
        return $this->getUsername();
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getEmailVerifiedAt(): ?string
    {
        return $this->emailVerifiedAt;
    }

    /**
     * @param string|null $emailVerifiedAt
     */
    public function setEmailVerifiedAt(?string $emailVerifiedAt): void
    {
        $this->emailVerifiedAt = $emailVerifiedAt;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id'              => $this->getId(),
            'firstName'       => $this->getFirstName(),
            'lastName'        => $this->getLastName(),
            'email'           => $this->getEmail(),
            'emailVerifiedAt' => $this->getEmailVerifiedAt(),
        ];
    }

    public function eraseCredentials()
    {
        // Not used in this example
    }

    public function getRoles(): array
    {
        return [];
    }
}
