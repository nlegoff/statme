<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author nico
 */

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Silex\Application;

class User extends \Statme\AbstractController implements ControllerProviderInterface
{

  public function connect(Application $app)
  {
    $controllers = new ControllerCollection();

    $controllers->match('/{slug}', function(Application $app, Request $request, $username)
            {
              return $this->getProcessor($request)->execute()->getResponse();
            });

    return $controllers;
  }

}