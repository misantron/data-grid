<?php

namespace Data\DataProvider;

use Doctrine\DBAL\Query\QueryBuilder;

class DoctrineDbalDataProvider extends AbstractDataProvider
{
    protected $queryBuilder;

    public function __construct($queryBuilder)
    {
        if(!($queryBuilder instanceof QueryBuilder)){
            throw new \InvalidArgumentException('');
        }
        $this->queryBuilder = $queryBuilder;
    }

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

    }
}