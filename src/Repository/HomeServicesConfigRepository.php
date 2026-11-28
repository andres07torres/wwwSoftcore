<?php

namespace App\Repository;

use App\Entity\HomeServicesConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HomeServicesConfig>
 */
class HomeServicesConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomeServicesConfig::class);
    }

    public function findCurrent(): ?HomeServicesConfig
    {
        return $this->findOneBy([], ['id' => 'ASC']);
    }
}
