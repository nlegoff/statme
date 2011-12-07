<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EnumGenderType
 *
 * @author nico
 */

namespace Statme\ORM\Enum;

class GenderType extends \Statme\ORM\EnumType
{
    protected $name = 'enumgender';
    protected $values = array('m', 'f');
}

