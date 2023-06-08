<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductTrims;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @method ProductTrims|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductTrims|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductTrims[]    findAll()
 * @method ProductTrims[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductTrimsRepository extends ServiceEntityRepository
{

    private PaginatorInterface $paginator;
    private Security $security;

    public function __construct(
        ManagerRegistry $registry,
        PaginatorInterface $paginator,
        Security $security,
    ) {
        parent::__construct($registry, ProductTrims::class);
        $this->paginator = $paginator;
        $this->security = $security;
    }

    public const NUM_ITEMS = 20;

    public function findAllPublished(): array
    {
        $qb = $this->createQueryBuilder('p');
        $query = $qb->where("p.state = 'published'")
            ->orderBy('p.id', 'DESC')
            ->getQuery()
        ;

        return $query->execute();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function countAll(): int
    {
        $count = $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return (int) $count;
    }


    protected function createPaginator(Query $query, int $page): PaginationInterface
    {
        return $this->paginator->paginate($query, $page, 4);
    }

    public function findProductsPaginated(int $page, string $slug, int $limit = 6): array
    {
        $limit = abs($limit);

        $result = [];

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('c', 'p')
            ->from('App\Entity\Products', 'p')
            ->join('p.categories', 'c')
            ->where("c.slug = '$slug'")
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit)
        ;

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();

        if (empty($data)) {
            return $result;
        }

        $pages = ceil($paginator->count() / $limit);

        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;

        return $result;
    }

    /**
     * @param $account
     *
     * @return array
     */
    public function findAllThreadsByAccount($account): array
    {
        return $this->createQueryBuilder('P')
            ->leftJoin('P.threads', 'T')
            ->leftJoin('T.messages', 'M')
            ->where('P.account = :account')
            ->setParameter('account', $account)
            ->groupBy('P.id')
            ->getQuery()
            ->getResult();
    }
}
