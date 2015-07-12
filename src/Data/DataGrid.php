<?php

namespace Data;

use Data\DataProvider\AbstractDataProvider;

class DataGrid
{
    /** @var string */
    protected $id;
    /** @var AbstractDataProvider */
    protected $dataProvider;

    protected $options = [];

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function setDataProvider($value)
    {
        if(!($value instanceof AbstractDataProvider)){
            throw new \InvalidArgumentException('Data provider should be instance of DataProviderInterface');
        }
        $this->dataProvider = $value;
        return $this;
    }

    public function getDataProvider()
    {
        return $this->dataProvider;
    }

    public function render()
    {
        $items = [];
        $items[] = $this->getDataProvider()->getPagination()->render();
        return implode("/n", $items);
    }
}