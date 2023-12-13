<?php

namespace App\Repository;

use App\Entity\Application;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * ApplicationRepository
 *
 * @extends ServiceEntityRepository<Application>
 */
class ApplicationRepository extends ServiceEntityRepository
{
    /**
     * ApplicationRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }

    /**
     * Find an application by its alias.
     *
     * @param string $alias
     *
     * @return Application|null
     */
    public function findByAlias(string $alias): ?Application
    {
        return $this->findOneBy(['alias' => $alias]);
    }
}
