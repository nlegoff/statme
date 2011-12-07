<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UnitType
 *
 * @author nico
 */

namespace Statme\ORM\Enum;

class UnitType extends \Statme\ORM\EnumType
{

  protected $name = 'enumunittype';
  protected $values = array('incremental', 'masse', 'time');

}

