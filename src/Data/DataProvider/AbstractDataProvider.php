<?php

namespace Data\DataProvider;

use Data\Pagination;
use Component\Component;

abstract class AbstractDataProvider extends Component implements DataProviderInterface
{
    private $data;
    private $keys;
    private $totalDataCount;
    /** @var Pagination|bool */
    private $pagination;

    abstract protected function initData();

    abstract protected function initKeys();

    abstract protected function initTotalDataCount();

    public function getData()
    {
        $this->initData();
        return $this->data;
    }

    public function setData($value)
    {
        $this->data = $value;
        return $this;
    }

    public function getTotalCount()
    {
        if($this->getPagination() === false){
            return $this->getCount();
        } elseif($this->totalDataCount === null){
            return $this->initTotalDataCount();
        }
        return $this->totalDataCount;
    }

    public function getPagination()
    {
        if($this->pagination === null){
            $this->setPagination([]);
        }
        return $this->pagination;
    }

    public function setPagination($value)
    {
        if($value instanceof Pagination || $value === false){
            $this->pagination = $value;
        } elseif (is_array($value)){

        }
        return $this;
    }

    public function getCount()
    {
        return sizeof($this->data);
    }
}