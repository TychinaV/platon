<?php

namespace Platon\Method;

/**
 * Class Method
 * @package Platon
 */
abstract class Method
{
    /**
     * @var array
     */
    protected $params;

    /**
     * Method constructor.
     * @param $params
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    abstract public function getInputParams();
    abstract public function getSign($key, $password);
}