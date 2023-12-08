<?php

declare(strict_types=1);

namespace App\Entity;

final class Project
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $clientName;

    /**
     * @var string|null
     */
    protected ?string $shortDescription;

    /**
     * @var int
     */
    protected int $status;

    /**
     * @var int
     */
    protected int $storeId;

    /**
     * @var string
     */
    protected string $host;

    /**
     * @var string|null
     */
    protected ?string $logo;

    /**
     * @var string|null
     */
    protected ?string $logoUrl;

    /**
     * @var bool
     */
    protected bool $isEcommerce;

    /**
     * @var bool
     */
    protected bool $applicationInstalled;

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
     * @return string
     */
    public function getClientName(): string
    {
        return $this->clientName;
    }

    /**
     * @param string $clientName
     */
    public function setClientName(string $clientName): void
    {
        $this->clientName = $clientName;
    }

    /**
     * @return string|null
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @param string|null $shortDescription
     *
     * @return void
     */
    public function setShortDescription(?string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
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
     * @return int
     */
    public function getStoreId(): int
    {
        return $this->storeId;
    }

    /**
     * @param int $storeId
     */
    public function setStoreId(int $storeId): void
    {
        $this->storeId = $storeId;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo(?string $logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return string
     */
    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    /**
     * @param string $logoUrl
     */
    public function setLogoUrl(?string $logoUrl): void
    {
        $this->logoUrl = $logoUrl;
    }

    /**
     * @return bool
     */
    public function isEcommerce(): bool
    {
        return $this->isEcommerce;
    }

    /**
     * @param bool $isEcommerce
     */
    public function setIsEcommerce(bool $isEcommerce): void
    {
        $this->isEcommerce = $isEcommerce;
    }

    /**
     * @return bool
     */
    public function isApplicationInstalled(): bool
    {
        return $this->applicationInstalled;
    }

    /**
     * @param bool $applicationInstalled
     */
    public function setApplicationInstalled(bool $applicationInstalled): void
    {
        $this->applicationInstalled = $applicationInstalled;
    }
}
