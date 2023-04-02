<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Page;
use App\Entity\Settings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class PageRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(
        ManagerRegistry $registry,
        PaginatorInterface $paginator
    ) {
        parent::__construct($registry, Page::class);
        $this->paginator = $paginator;
    }

    public function countAll(): int
    {
        $count = $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return (int) $count;
    }

    private function findLimit(): int
    {
        $repository = $this->getEntityManager()->getRepository(Settings::class);
        $limit = $repository->findOneBy([]);

        return (int) $limit->getSettingValue();
    }

    public function findLatest(
        Request $request,
    ): PaginationInterface {

        $locale = 'en';

        $qb = $this->createQueryBuilder('p')
            ->where('p.locale = :locale')
            ->setParameter('locale', $locale)
            ->orderBy('p.id', 'DESC');

        return $this->createPaginator($qb->getQuery(), $request);
    }

    public function findPublished(
        Request $request,
    ): PaginationInterface {

        $locale = 'en';
        $publish = '1';

        $qb = $this->createQueryBuilder('p')
            ->where('p.locale = :locale')
//            ->andWhere('p.publish = :publish')
            ->setParameter('locale', $locale)
//            ->setParameter('publish', $publish)
            ->orderBy('p.id', 'DESC');

        return $this->createPaginator($qb->getQuery(), $request);
    }

    private function createPaginator(
        Query $query,
        Request $request
    ): PaginationInterface {
        // Paginate the results of the query
        return $this->paginator->paginate(
            // Doctrine Query, not results
            $query,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
    }
}
