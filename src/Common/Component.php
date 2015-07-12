<?php

namespace Common;

class Component
{
    public function __construct($config = [])
    {
        $this->configure($config);
    }

    /**
     * @param array $config
     */
    protected function configure($config)
    {
        foreach($config as $key => $value){
            if(property_exists($this, $key)){
                $setterMethod = 'set' . ucfirst($key);
                if(method_exists($this, $setterMethod)){
                    $this->{$setterMethod}($value);
                } else {
                    $this->{$key} = $value;
                }
            }
        }
        $this->init();
    }

    public function init()
    {

    }
}