<?php

namespace Data\Twig;

class DataGridExtension extends \Twig_Extension
{
    /**
     * @var \Twig_Environment
     */
    private $environment;

    /**
     * @return string
     */
    public function getName()
    {
        return 'dataGrid';
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getFunctions()
    {
        return [
            'grid' => new \Twig_Function_Method($this, 'getGrid', ['is_safe' => ['html']]),
        ];
    }
}