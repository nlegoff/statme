<?php

/*
 * This file is part of Phraseanet
 *
 * (c) 2005-2010 Alchemy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 *
 * @license     http://opensource.org/licenses/gpl-3.0 GPLv3
 * @link        www.phraseanet.com
 */

namespace Statme;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Statme\Exception\Http;

class Process
{

  /**
   * FACTORY PATTERN
   * @param string $type
   * @return ProcessAbstract
   */
  public static function factory($route, Request $request, EntityManager $entityManager)
  {
    $routing = Yaml::parse(ROUTING_FILE);

    if(!is_array($routing))
      throw new Http\InternalServorError("Can't load route config File");

    $classname = isset($routing[$route]) ? $routing[$route] : null;

    if(is_null($classname))
      throw new Http\InternalServorError("Unknown route");
    
    if (include_once __DIR__ . '/Process/' . str_replace('\\', '/', $classname) . '.php')
    {
      $classname = sprintf('\Statme\Process\%s', $classname);
      return new $classname($request, $entityManager);
    }
    else
    {
      throw new Http\internalServorError('Process not found');
    }
  }

}