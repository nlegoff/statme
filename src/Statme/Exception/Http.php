<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Http
 *
 * @author nico
 */

namespace Statme\Exception;

class Http extends \Statme\Exception
{
  protected $httpStatusCode;
  protected $httpMessage;
  
  
  public function getHttpStatusCode()
  {
    return $this->httpStatusCode;
  }

  public function setHttpStatusCode($httpStatusCode)
  {
    $this->httpStatusCode = $httpStatusCode;
  }

  public function getHttpMessage()
  {
    return $this->httpMessage;
  }

  public function setHttpMessage($httpMessage)
  {
    $this->httpMessage = $httpMessage;
  }


  
}

?>
