<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AbstractController
 *
 * @author nicolasl
 */

namespace Statme;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class AbstractController
{

  protected $route;
  protected $entityManager;

  public function __construct($route, EntityManager $entityManager)
  {
    $this->route = $route;
    $this->entityManager = $entityManager;
  }

  public function getRoute()
  {
    return $this->route;
  }

  /**
   *
   * @return EntityManager 
   */
  public function getEntityManager()
  {
    return $this->entityManager;
  }

  /**
   *
   * @param Request $request
   * @return Statme\Process 
   */
  public function getProcessor(Request $request)
  {
    return Statme\Process::factory($this->getRoute(), $request, $this->getEntityManager());
  }
}

?>
