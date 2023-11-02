<?php

namespace Ma\Worker\Test\Controllers;

use Ma\Worker\Test\Models\Test;

class TestController
{
    public $param;
    public $model;
    public function __construct($param, Test $model)
    {
        $this->param = $param;
        $this->model = $model;
    }

    public function getParam()
    {
        var_dump($this->param);
    }

    public function setParam($param)
    {
        var_dump($param['method']);
    }

    public function db()
    {
        var_dump($this->model->getAll());
    }
}
