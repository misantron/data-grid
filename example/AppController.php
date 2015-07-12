<?php

use Data\DataGridFactory;
use Data\DataProvider\DoctrineDbalDataProvider;
use Data\Pagination;
use Doctrine\DBAL\DriverManager;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Response;

class AppController
{
    /** @var DataGridFactory */
    protected $dataGridFactory;

    public function __construct(DataGridFactory $dataGridFactory)
    {
        $this->dataGridFactory = $dataGridFactory;
    }

    public function actionIndex(ServerRequestInterface $request)
    {
        $pagination = new Pagination([
            'request' => $request,
            'pageSize' => 20
        ]);
        $connection = DriverManager::getConnection([]);
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('users')
            ->orderBy('last_name', 'DESC')
        ;
        $dataProvider = (new DoctrineDbalDataProvider($queryBuilder))
            ->setPagination($pagination);
        $dataGrid = $this->dataGridFactory
            ->create('dataGrid')
            ->setDataProvider($dataProvider);

        return new Response($dataGrid->render());
    }
}