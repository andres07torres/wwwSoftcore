<?php

namespace App\Repository;

use App\Entity\AboutMetricCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AboutMetricCard>
 */
class AboutMetricCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AboutMetricCard::class);
    }

    /**
     * @return list<AboutMetricCard>
     */
    public function findAllOrdered(): array
    {
        return $this->findBy([], ['sortOrder' => 'ASC', 'id' => 'ASC']);
    }

    /**
     * @return list<AboutMetricCard>
     */
    public function findActiveOrdered(): array
    {
        return $this->findBy(['isActive' => true], ['sortOrder' => 'ASC', 'id' => 'ASC']);
    }
}
