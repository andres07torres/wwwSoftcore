<?php

namespace App\Repository;

use App\Entity\HomeHeroSlide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HomeHeroSlide>
 */
class HomeHeroSlideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomeHeroSlide::class);
    }

    /**
     * @return list<HomeHeroSlide>
     */
    public function findAllOrdered(): array
    {
        return $this->findBy([], ['sortOrder' => 'ASC', 'id' => 'ASC']);
    }

    /**
     * @return list<HomeHeroSlide>
     */
    public function findActiveOrdered(): array
    {
        return $this->findBy(['isActive' => true], ['sortOrder' => 'ASC', 'id' => 'ASC']);
    }
}
