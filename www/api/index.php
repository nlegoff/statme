<?php

require_once __DIR__ . '/../../vendor/silex.phar';
require_once __DIR__ . '/../../src/Statme/Application.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

Statme\Application::bootstrap();
$entityManager = Statme\Application::getEntityManager();

$app = new Silex\Application();

$app->mount('/user', new Controller\User('user', $entityManager));

/** Error handler */
$app->error(function (\Exception $e)
        {
          return new Response($e->getMessage(), $e->getCode());
        });

$app->run();
