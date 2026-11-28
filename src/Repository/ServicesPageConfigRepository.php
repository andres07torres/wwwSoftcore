<?php

namespace App\Repository;

use App\Entity\ServicesPageConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServicesPageConfig>
 */
class ServicesPageConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServicesPageConfig::class);
    }

    public function findCurrent(): ?ServicesPageConfig
    {
        return $this->findOneBy([], ['id' => 'ASC']);
    }
}
