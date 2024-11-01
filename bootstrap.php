<?php

use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;


require_once "vendor/autoload.php";


$paths = array(__DIR__.'/src');
$isDevMode = true;

$config = ORMSetup::createAttributeMetadataConfiguration(
    $paths,
    $isDevMode
);

$params = [
    'driver' => 'pdo_mysql',
    'user' => "root",
    'password' => "",
    'host' => "localhost",
    'dbname' => "ecommerce"
];

$connexion = DriverManager::getConnection($params, $config);

$entityManager = new EntityManager($connexion, $config);