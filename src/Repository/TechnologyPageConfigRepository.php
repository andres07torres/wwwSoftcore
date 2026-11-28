<?php

namespace App\Repository;

use App\Entity\TechnologyPageConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechnologyPageConfig>
 */
class TechnologyPageConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechnologyPageConfig::class);
    }

    public function findCurrent(): ?TechnologyPageConfig
    {
        return $this->findOneBy([], ['id' => 'ASC']);
    }
}
