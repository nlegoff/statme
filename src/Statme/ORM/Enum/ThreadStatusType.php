<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ThreadStatusType
 *
 * @author nico
 */

namespace Statme\ORM\Enum;

class ThreadStatusType extends \Statme\ORM\EnumType
{
    protected $name = 'enumthreadstatus';
    protected $values = array('validated', 'rejected', 'validation_process');
}


