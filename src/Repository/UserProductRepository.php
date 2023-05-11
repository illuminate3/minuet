<?php

declare(strict_types=1);

namespace App\Repository;

use Knp\Component\Pager\Pagination\PaginationInterface;

final class UserProductRepository extends ProductRepository
{
//    public function findByUser(array $params): PaginationInterface
//    {
//        $qb = $this->createQueryBuilder('p')
//            ->where('p.user = :id')
//        ;
//
////        if ('published' === $params['state']) {
////            $qb->andWhere("p.state = 'published'");
////        } else {
////            $qb->andWhere("p.state != 'published'");
////        }
//
//        $qb->orderBy('p.id', 'DESC')
//            ->setParameter('id', $params['user'])
//        ;
//
//        return $this->createPaginator($qb->getQuery(), $params['page']);
//    }

//    public function changeState(Product $property, string $state): bool
//    {
//        try {
//            $property->setState($state);
//            $em = $this->getEntityManager();
//            $em->persist($property);
//            $em->flush();
//
//            return true;
//        } catch (\Throwable $e) {
//            return false;
//        }
//    }
}
