<?php
require_once __DIR__ . '/../vendor/silex.phar';
require_once __DIR__ . '/../src/Statme/Application.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

Statme\Application::bootstrap();

$app = new Silex\Application();

$app['debug'] = true;

$app->get('/', function()
        {
          return 'hellow';
        });

$app->run();
