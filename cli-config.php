<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


require_once __DIR__ . '/src/Statme/Application.php';

\Statme\Application::bootstrap();

$entityManager = \Statme\Application::getEntityManager();

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
            'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($entityManager->getConnection()),
            'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager)
        ));
