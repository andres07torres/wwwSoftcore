<?php

namespace App\Repository;

use App\Entity\HomeHeroConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HomeHeroConfig>
 */
class HomeHeroConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomeHeroConfig::class);
    }

    public function findCurrent(): ?HomeHeroConfig
    {
        return $this->findOneBy([], ['id' => 'ASC']);
    }
}
