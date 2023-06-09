<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;

    public function __construct(
        ManagerRegistry $registry,
        PaginatorInterface $paginator
    ) {
        parent::__construct($registry, User::class);
        $this->paginator = $paginator;
    }

    /**
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countAll(): int
    {
        $count = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return (int) $count;
    }

    /**
     * @param  Request  $request
     *
     * @return PaginationInterface
     */
    public function findUsers(
        Request $request,
    ): PaginationInterface {
        $qb = $this->createQueryBuilder('user')
            ->orderBy('user.id', 'DESC')
        ;

        return $this->createPaginator($qb->getQuery(), $request);
    }

    /**
     * @param  User  $dealer
     *
     * @return array
     */
    public function findByLoggedInDealer(User $dealer): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.dealer = :dealer')
            ->setParameter('dealer', $dealer)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param  Query    $query
     * @param  Request  $request
     *
     * @return PaginationInterface
     */
    private function createPaginator(
        Query $query,
        Request $request
    ): PaginationInterface {
        // Paginate the results of the query
        return $this->paginator->paginate(
            // Doctrine Query, not results
            $query,
            // Define the page parameter
            $request->query->getInt('user', 1),
            // Items per page
            10
        );
    }

    /**
     * @param  User  $entity
     * @param  bool  $flush
     *
     * @return void
     */
    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param  User  $user
     *
     * @return void
     */
    private function save(User $user): void
    {
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();
    }

}
