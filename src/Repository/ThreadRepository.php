<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Thread;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use DoctrineDBALConnection;
use DoctrineDBALQueryQueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Thread>
 *
 * @method Thread|null find($id, $lockMode = null, $lockVersion = null)
 * @method Thread|null findOneBy(array $criteria, array $orderBy = null)
 * @method Thread[]    findAll()
 * @method Thread[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThreadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Thread::class);
    }

    public function save(Thread $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param  Thread  $entity
     * @param  bool    $flush
     *
     * @return void
     */
    public function remove(Thread $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param  int   $id
     * @param  bool  $pin_value
     *
     * @return void
     */
    public function updatePinStatus(int $id, bool $pin_value)
    {
        $thread = $this->getEntityManager()->getRepository(Thread::class)->find($id);

        if (!$thread) {
            throw $this->createNotFoundException('Thread not found');
        }

        $thread->setIsPin($pin_value);
        $this->getEntityManager()->flush();
    }

    /**
     * @param  int   $id
     * @param  bool  $close_value
     *
     * @return void
     */
    public function updateCloseStatus(int $id, bool $close_value)
    {
        $thread = $this->getEntityManager()->getRepository(Thread::class)->find($id);

        if (!$thread) {
            throw $this->createNotFoundException('Thread not found');
        }

        $thread->setIsClosed($close_value);
        $this->getEntityManager()->flush();
    }

//    /**
//     * @return Thread[] Returns an array of Thread objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Thread
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
