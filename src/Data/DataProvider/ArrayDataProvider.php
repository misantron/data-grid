<?php

namespace Data\DataProvider;

class ArrayDataProvider extends AbstractDataProvider
{
    /** @var array */
    protected $data;

    public function __construct($array)
    {
        $this->data = $array;
    }

    protected function initData()
    {
        $data = $this->data;
        $pagination = $this->getPagination();
        if($pagination !== false){
            return array_slice($data, $pagination->getOffset(), $pagination->getLimit(), true);
        }
        return $data;
    }

    protected function initKeys()
    {
        // TODO: Implement initKeys() method.
    }

    protected function initTotalDataCount()
    {
        return $this->getCount();
    }
}