<?php

namespace DataGrid;

class DataGridFactory
{
    /** @var array */
    private static $cache = [];
    /** @var string */
    protected $defaultId = 'dataGrid';

    /**
     * @param array $config
     * @return DataGrid
     */
    public function create($config = [])
    {
        $dataGridId = $this->resolveId($config);
        if(!isset(static::$cache[$dataGridId])){
            static::$cache[$dataGridId] = new DataGrid($config);
        }
        return static::$cache[$dataGridId];
    }

    /**
     * @param array $config
     * @return string
     */
    protected function resolveId(&$config)
    {
        return isset($config['id']) ? $config['id'] : $this->defaultId;
    }
}