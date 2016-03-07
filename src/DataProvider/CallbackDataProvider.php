<?php

namespace DataGrid\DataProvider;

class CallbackDataProvider extends AbstractDataProvider
{
    /** @var callable */
    protected $dataCallback;
    /** @var callable */
    protected $totalCountCallback;

    protected function initData()
    {
        return call_user_func($this->dataCallback);
    }

    protected function initKeys()
    {
        // TODO: Implement initKeys() method.
    }

    protected function initTotalDataCount()
    {
        return call_user_func($this->totalCountCallback);
    }
}