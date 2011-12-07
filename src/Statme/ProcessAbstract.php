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

use Statme\Exception\Http;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class ProcessAbstract
{
  const POST_OK = 201;
  const GET_OK = 200;
  const DELETE_OK = 204;
  const PUT_OK = 200;
  const FIELDS_PARAMETER_NAME = 'fields';
  const FIELDS_DELIMITER = ',';
  const JSON_HEADERS = array('content-type' => 'application/json');
  

  /**
   * The request being treated
   * @var request
   */
  protected $request;

  /**
   * The response being rendered
   * @var Response
   */
  protected $response;

  /**
   * The entity Manager
   * @var EntityManager 
   */
  protected $entityManager;

  /**
   * return the allowed methods
   * @return Array
   */
  abstract public function getAllowedMethods();

  abstract public function getDefaultFields();

  /**
   * Constructor for a Statme Thread Module
   * @param PDO $connection
   */
  public function __construct(Request $request, EntityManager $entityManager)
  {
    $this->request = $request;
    $this->entityManager = $entityManager;
  }

  /**
   * Getter
   * @return Request
   */
  public function getRequest()
  {
    return $this->request;
  }

  /**
   * Getter
   * @return EntityManager
   */
  public function getEntityManager()
  {
    return $this->entityManager;
  }

  /**
   * Getter
   * @return Response 
   */
  public function getResponse()
  {
    return $this->response;
  }

  /**
   * @see http://php.net/manual/en/language.oop5.late-static-bindings.php
   * @return ModuleAbstract
   */
  public function execute()
  {
    $response = null;

    switch (strtoupper($this->request->getMethod()))
    {
      case 'POST' :
        $response = static::post();
        break;
      case 'PUT' :
        $response = static::put();
        break;
      case 'DELETE' :
        $response = static::delete();
        break;
      case 'GET' :
        $response = static::get();
        break;
      default :
        throw new Http\NotImplemented();
        break;
    }

    $this->response = $response;

    return $this;
  }

  /**
   * Handle post action
   * @param
   */
  protected function post()
  {
    throw new Http\MethodNotAllowed($this->getAllowedMethods());
  }

  /**
   * Handle delete action
   * @param
   */
  protected function delete()
  {
    throw new Http\MethodNotAllowed($this->getAllowedMethods());
  }

  /**
   * Handle get action
   * @param
   */
  protected function get()
  {
    throw new Http\MethodNotAllowed($this->getAllowedMethods());
  }

  /**
   * Handle put action
   * @param
   */
  protected function put()
  {
    throw new Http\MethodNotAllowed($this->getAllowedMethods());
  }

  /**
   * Return the final field selection
   * 
   * @return Array
   */
  protected function getFieldsSelection()
  {
    $defaultFields = (array) $this->getDefaultFields();

    if (count($defaultFields) === 0)
    {
      throw new Http\InternalServorError('No default field value provided');
    }

    return array_merge(
                    $this->parseRequestedFields(
                            $request, self::FIELDS_PARAMETER_NAME, function($value)
                            {
                              return trim($value);
                            }), $defaultFields);
  }

  /**
   * Use in constructor
   * 
   * Parse query field parameter and retrieve requested fields
   * 
   * @param Request $request The request
   * @param string $fieldName The field parameter name
   * @param Closure $callback A callback applied to all fields
   * @return Array
   */
  private function parseRequestedFields(Request $request, $fieldName = self::FIELDS_PARAMETER_NAME, Closure $callback = null)
  {
    $fields = array();

    $requestedFields = $request->get($fieldName);

    if ($requestedFields !== null && trim($requestedFields) !== '')
    {
      $fields = explode(self::FIELDS_DELIMITER, $requestedFields);
    }

    if ($callback)
    {
      $fields = array_map($callback, $fields);
    }

    return $fields;
  }

  protected function properResult(Array $fieldSelection, Array $entityFields)
  {
    $remove = function($value, $key) use ($entityFields, $fieldsSelection)
            {
              if (!in_array($key, $fieldSelection))
              {
                unset($entityFields[$key]);
              }
            };
            
    array_walk($entityFields, $remove);
    
    return $entityFields;
  }

}