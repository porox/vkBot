<?php

namespace App\Repository;

use App\Entity\WatchingGroups;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WatchingGroups|null find($id, $lockMode = null, $lockVersion = null)
 * @method WatchingGroups|null findOneBy(array $criteria, array $orderBy = null)
 * @method WatchingGroups[]    findAll()
 * @method WatchingGroups[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WatchingGroupsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WatchingGroups::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('w')
            ->where('w.something = :value')->setParameter('value', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
