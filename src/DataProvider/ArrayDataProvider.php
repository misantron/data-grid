<?php

namespace DataGrid\DataProvider;

class ArrayDataProvider extends AbstractDataProvider
{
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