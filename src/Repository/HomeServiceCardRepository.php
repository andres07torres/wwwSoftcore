<?php

namespace App\Repository;

use App\Entity\HomeServiceCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HomeServiceCard>
 */
class HomeServiceCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomeServiceCard::class);
    }

    /**
     * @return list<HomeServiceCard>
     */
    public function findAllOrdered(): array
    {
        return $this->findBy([], ['sortOrder' => 'ASC', 'id' => 'ASC']);
    }

    /**
     * @return list<HomeServiceCard>
     */
    public function findActiveOrdered(): array
    {
        return $this->findBy(['isActive' => true], ['sortOrder' => 'ASC', 'id' => 'ASC']);
    }
}
