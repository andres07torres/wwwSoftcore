<?php

namespace App\Repository;

use App\Entity\AboutPageConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AboutPageConfig>
 */
class AboutPageConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AboutPageConfig::class);
    }

    public function findCurrent(): ?AboutPageConfig
    {
        return $this->findOneBy([], ['id' => 'ASC']);
    }
}
