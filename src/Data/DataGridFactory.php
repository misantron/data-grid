<?php

namespace Data;

class DataGridFactory
{
    /** @var array */
    private static $cache = [];

    /**
     * @param string $id
     * @return DataGrid
     */
    public function create($id)
    {
        if(!isset(static::$cache[$id])){
            static::$cache[$id] = new DataGrid($id);
        }
        return static::$cache[$id];
    }
}