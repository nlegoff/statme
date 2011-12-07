<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrivacyType
 *
 * @author nico
 */
namespace Statme\ORM\Enum;

class PrivacyType extends \Statme\ORM\EnumType
{
    protected $name = 'enumprivacy';
    protected $values = array('public', 'private', 'friendly');
}

