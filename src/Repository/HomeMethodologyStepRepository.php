<?php

namespace App\Repository;

use App\Entity\HomeMethodologyStep;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HomeMethodologyStep>
 */
class HomeMethodologyStepRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomeMethodologyStep::class);
    }

    /**
     * @return list<HomeMethodologyStep>
     */
    public function findAllOrdered(): array
    {
        return $this->findBy([], ['sortOrder' => 'ASC', 'id' => 'ASC']);
    }

    /**
     * @return list<HomeMethodologyStep>
     */
    public function findActiveOrdered(): array
    {
        return $this->findBy(['isActive' => true], ['sortOrder' => 'ASC', 'id' => 'ASC']);
    }
}
