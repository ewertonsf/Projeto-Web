<?php

use Laminas\ServiceManager\ServiceManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require __DIR__ . '/../vendor/autoload.php';

$paths = [__DIR__ . "/Entity"];
$isDevMode = true;

$dbParams = [
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'projeto_web',
];

$config = Setup::createAnnotationMetadataConfiguration(
    $paths,
    $isDevMode,
    null,
    null,
    false
);

$serviceManager = new ServiceManager([
    'factories' => [
        EntityManager::class => function() use ($dbParams, $config) {
            return EntityManager::create($dbParams, $config);
        }
    ]
]);

return $serviceManager;
