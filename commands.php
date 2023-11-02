<?php

require_once __DIR__ . '/vendor/autoload.php';
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$config = require_once __DIR__.'/config.php';

use Ma\Worker\Test\Controllers\TestController;

$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->addDefinitions($config);
$container = $containerBuilder->build();

// Obten los parámetros de la línea de comandos
// Obten los parámetros de la línea de comandos
$params = [];
$x = 0;
foreach ($argv as $param) {
    if ($x == 0) {
        $x++;
        continue;
    }

    $data = explode("=", $param);
    $params[$data[0]] = $data[1];

    $x++;
}


// Obtén la instancia del controlador desde el contenedor
$controller = $container->get(TestController::class); // Asegúrate de configurar la definición en PHP-DI

$action = $params['action'];
$controller->$action($params);
