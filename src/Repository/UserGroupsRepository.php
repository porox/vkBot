<?php

namespace App\Repository;

use App\Entity\UserGroups;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserGroups|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserGroups|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserGroups[]    findAll()
 * @method UserGroups[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserGroupsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserGroups::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('u')
            ->where('u.something = :value')->setParameter('value', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
