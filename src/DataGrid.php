<?php

namespace DataGrid;

use Common\Component;
use Data\DataProvider\AbstractDataProvider;

class DataGrid extends Component
{
    /** @var string */
    protected $id;
    /** @var AbstractDataProvider */
    protected $dataProvider;
    /** @var array */
    protected $columns = [];

    /**
     * @param AbstractDataProvider $value
     * @return $this
     */
    public function setDataProvider($value)
    {
        if(!$value instanceof AbstractDataProvider){
            throw new \InvalidArgumentException('Data provider should be instance of AbstractDataProvider');
        }
        $this->dataProvider = $value;
        return $this;
    }

    public function getDataProvider()
    {
        return $this->dataProvider;
    }

    public function createView()
    {
        return new DataGridView();
    }
}