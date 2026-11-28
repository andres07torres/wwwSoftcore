<?php

namespace App\Repository;

use App\Entity\HomeMethodologyConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HomeMethodologyConfig>
 */
class HomeMethodologyConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomeMethodologyConfig::class);
    }

    public function findCurrent(): ?HomeMethodologyConfig
    {
        return $this->findOneBy([], ['id' => 'ASC']);
    }
}
