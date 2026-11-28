<?php

namespace App\Repository;

use App\Entity\MethodologyPageConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MethodologyPageConfig>
 */
class MethodologyPageConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MethodologyPageConfig::class);
    }

    public function findCurrent(): ?MethodologyPageConfig
    {
        return $this->findOneBy([], ['id' => 'ASC']);
    }
}
