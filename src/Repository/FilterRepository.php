<?php

declare(strict_types=1);

namespace App\Repository;

use Knp\Component\Pager\Pagination\PaginationInterface;

final class FilterRepository extends ProductRepository
{

    /**
     * @param  array  $params
     *
     * @return PaginationInterface
     */
    public function findByFilter(array $params): PaginationInterface
    {
        $queryBuilder = $this->createQueryBuilder('p')->orderBy('p.id', 'DESC');
        if (isset($params['category']) && !empty($params['category'])) {
            $queryBuilder->where($queryBuilder->expr()->in('p.category',  $params['category']));
        }
        return $this->createPaginator($queryBuilder->getQuery(), $params['page']);
    }

}
