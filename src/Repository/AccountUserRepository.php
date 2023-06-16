<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AccountUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AccountUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountUser[]    findAll()
 * @method AccountUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountUser::class);
    }

    // /**
    //  * @return OrderDetail[] Returns an array of OrderDetail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderDetail
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
