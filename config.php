<?php

use Ma\Worker\Shared\Database;
use Ma\Worker\Test\Controllers\TestController;
use Ma\Worker\Test\Models\Test;

function getParams($paramName)
{
    global $argv;
    foreach ($argv as $param) {
        if (strpos($param, "$paramName=") === 0) {
            $result = explode('=', $param);
            return $result[1];
        }
    }
    return null;
}

return [
    TestController::class => DI\create()
        ->constructor(DI\get('classParam'), DI\get(Test::class)),
    Database::class => DI\create()
        ->constructor($_ENV['MA_HOST'], $_ENV['MA_USER'], $_ENV['MA_PASSWORD'], $_ENV['MA_DATABASE']),
    'classParam' => getParams('param')
];
