<?php

class Controller
{
    protected $params;
    public function __construct($params)
    {
        $this->params = $params;
    }

    public function setParam()
    {
        print_r($this->params['hola']);
    }
}
