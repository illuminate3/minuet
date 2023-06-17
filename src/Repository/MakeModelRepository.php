<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MakeModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MakeModel>
 *
 * @method MakeModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method MakeModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method MakeModel[]    findAll()
 * @method MakeModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MakeModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MakeModel::class);
    }

    /**
     * @param  MakeModel  $entity
     * @param  bool       $flush
     *
     * @return void
     */
    public function save(MakeModel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param  MakeModel  $entity
     * @param  bool       $flush
     *
     * @return void
     */
    public function remove(MakeModel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return MakeModel[] Returns an array of MakeModel objects
     */
    public function findAllUniqueMake(): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.make')
            ->orderBy('m.make', 'ASC')
            ->groupBy('m.make')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return MakeModel[] Returns an array of MakeModel objects
     */
    public function findAllUniqueYear(): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.year')
            ->orderBy('m.year', 'ASC')
            ->groupBy('m.year')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return MakeModel[] Returns an array of MakeModel objects
     */
    public function findAllMakeUsingYear($year): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.make')
            ->andWhere('m.year = :val')
            ->setParameter('val', $year)
            ->orderBy('m.make', 'ASC')
            ->groupBy('m.make')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return MakeModel[] Returns an array of MakeModel objects
     */
    public function findAllModelUsingYearAndMake($year, $make): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.model')
            ->andWhere('m.year = :val1')
            ->andWhere('m.make = :val2')
            ->setParameter('val1', $year)
            ->setParameter('val2', $make)
            ->orderBy('m.make', 'ASC')
            ->groupBy('m.make')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return MakeModel[] Returns an array of MakeModel objects
     */
    public function findAllUniqueModel($make): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.model')
            ->andWhere('m.make = :val')
            ->setParameter('val', $make)
            ->orderBy('m.model', 'ASC')
            ->groupBy('m.model')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return MakeModel[] Returns an array of MakeModel objects
     */
    public function findAllMakeModelYear($id): array
    {
        return $this->createQueryBuilder('m')
            // ->select('m.model')
            ->andWhere('m.id = :val')
            ->setParameter('val', $id)
            // ->orderBy('m.model', 'ASC')
            // ->groupBy('m.model')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return MakeModel[] Returns an array of MakeModel objects
     */
    // public function findId($year, $make, $model): array
    // {
    //     return $this->createQueryBuilder('m')
    //         ->select('m.model')
    //         ->andWhere('m.year = :val1')
    //         ->andWhere('m.make = :val2')
    //         ->andWhere('m.model = :val3')
    //         ->setParameter('val1', $year)
    //         ->setParameter('val2', $make)
    //         ->setParameter('val3', $model)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }

//    public function findOneBySomeField($value): ?MakeModel
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
