<?php

namespace App\Repository;

use App\Entity\SocialLinksConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SocialLinksConfig>
 */
class SocialLinksConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocialLinksConfig::class);
    }

    public function findCurrent(): ?SocialLinksConfig
    {
        return $this->findOneBy([], ['id' => 'ASC']);
    }
}
