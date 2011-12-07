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

class SubscriptionStatusType extends \Statme\ORM\EnumType
{
    protected $name = 'enumsubscriptionstatus';
    protected $values = array('active', 'inactive', 'deleted');
}

