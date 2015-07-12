<?php

use DataGrid\DataGridFactory;
use Data\DataProvider\DoctrineDbalDataProvider;
use Data\Pagination;
use Doctrine\DBAL\Connection;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Response;

class AppController
{
    /** @var Connection */
    protected $connection;
    /** @var DataGridFactory */
    protected $dataGridFactory;

    public function __construct(Connection $connection, DataGridFactory $dataGridFactory)
    {
        $this->connection = $connection;
        $this->dataGridFactory = $dataGridFactory;
    }

    public function actionIndex(ServerRequestInterface $request)
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('users')
            ->orderBy('last_name', 'DESC')
        ;
        $pagination = new Pagination([
            'request' => $request,
            'pageSize' => 20
        ]);
        $dataProvider = new DoctrineDbalDataProvider([
            'queryBuilder' => $queryBuilder,
            'pagination' => $pagination
        ]);
        $dataGrid = $this->dataGridFactory->create([
            'id' => 'myDataGrid',
            'dataProvider' => $dataProvider
        ]);

        return new Response([
            'dataGrid' => $dataGrid->createView()
        ]);
    }
}