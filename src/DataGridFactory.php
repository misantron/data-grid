<?php

namespace DataGrid;

class DataGridFactory
{
    /** @var array */
    protected $cache = [];
    /** @var string */
    protected $defaultId = 'dataGrid';

    /**
     * @param array $config
     * @return DataGrid
     */
    public function create($config = [])
    {
        $dataGridId = $this->resolveId($config);
        if(!isset($this->cache[$dataGridId])){
            $this->cache[$dataGridId] = new DataGrid($config);
        }
        return $this->cache[$dataGridId];
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