<?php

namespace Data\DataProvider;

use Doctrine\DBAL\Query\QueryBuilder;

class DoctrineDbalDataProvider extends AbstractDataProvider
{
    /** @var QueryBuilder */
    protected $queryBuilder;

    protected function initData()
    {
        $queryBuilder = clone $this->queryBuilder;
        $pagination = $this->getPagination();
        if($pagination !== false){
            $queryBuilder
                ->setMaxResults($pagination->getLimit())
                ->setFirstResult($pagination->getOffset())
            ;
        }
        return $queryBuilder->execute()->fetchAll();
    }

    protected function initTotalDataCount()
    {
        $queryBuilder = clone $this->queryBuilder;
        $pagination = $this->getPagination();
        if($pagination === false){
            return $this->getCount();
        }
        $queryBuilder
            ->resetQueryParts(['select', 'orderBy', 'groupBy'])
            ->select('COUNT(1)')
        ;
        return (int) $queryBuilder->execute()->fetchColumn();
    }

    protected function initKeys()
    {
        $queryBuilder = clone $this->queryBuilder;
        return $queryBuilder->getQueryPart('select');
    }
}