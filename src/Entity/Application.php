<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ApplicationRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Traits\EntityPropertyTrait;


#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[ORM\Table(name: 'applications')]
#[UniqueEntity(fields: ['name'], message: 'The name must be unique.')]
class Application
{
    #[ORM\Id, ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', updatable: false)]
    protected int $id;

    #[ORM\Column(type: 'string', updatable: true)]
    #[Assert\NotBlank]
    protected string $name;

    #[ORM\Column(type: 'integer', updatable: true)]
    protected int $type;


    #[ORM\Column(type: 'integer', updatable: true)]
    protected int $status;

    #[ORM\Column(type: 'string', updatable: true)]
    protected string $alias;

    #[ORM\Column(type: 'string', updatable: true)]
    protected string|null $description;

    #[ORM\Column(type: 'string', updatable: true)]
    protected string|null $logo;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable', updatable: false)]
    protected readonly DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable', updatable: true)]
    protected DateTimeImmutable $updatedAt;

    /**
     * Constructor to set initial values for createdAt and updatedAt.
     */
    public function __construct()
    {
        // Set createdAt and updatedAt to the current date and time.
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * Convert entity data to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->translatedFields['name'] ?? $this->name,
            'status'      => $this->status,
            'alias'       => $this->alias,
            'description' => $this->translatedFields['description'] ?? $this->description,
            'logo'        => $this->logo,
            'createdAt'   => $this->createdAt,
            'updatedAt'   => $this->updatedAt,
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo(string $logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeImmutable $updatedAt
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}