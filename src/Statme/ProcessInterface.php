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

use Symfony\Component\HttpFoundation\Request;

interface ProcessInterface
{

  /**
   * @return Response
   */
  public function execute();
  
  /**
   * Handle post action
   * @param 
   */
  public function post();

  /**
   * Handle delete action
   * @param 
   */
  public function delete();

  /**
   * Handle get action
   * @param 
   */
  public function get();

  /**
   * Handle put action
   * @param 
   */
  public function put();
}