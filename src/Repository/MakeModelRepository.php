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

    public function save(MakeModel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

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
