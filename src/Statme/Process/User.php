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

namespace Statme\Process;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use Statme\Http;

class User extends \Statme\ProcessAbstract
{

  /**
   * Constructor for a Statme Thread Module
   * @param PDO $connection
   */
  public function __construct(Request $request, EntityManager $entityManager)
  {
    parent::__construct($request, $entityManager);
    $this->defaultFields = array('id', 'username', 'slug');
  }

  public function getDefaultFields()
  {
    return array(
        'id', 'username', 'slug'
    );
  }

  /**
   * Get Allowed methods for Statme Thread module
   * @return Array
   */
  public function getAllowedMethods()
  {
    return array('GET', 'POST', 'DELETE', 'PUT');
  }

  /**
   * Handle post action
   * Create a new thread
   * @return Response
   */
  protected function post()
  {
    
  }

  /**
   * Handle get action
   * Get appropriate thread
   * @return Response
   */
  protected function get()
  {
    $parameter = $this->getRequest()->get('slug');

    if ($parameter === null)
    {
      throw new Http\BadRequest('Missing username parameter');
    }

    $criteria = array('slug' => $parameter);

    /** @var User */
    $user = $this
            ->getEntityManager()
            ->getRepository('Entity\User')
            ->findOneBy($criteria);

    if (!$user instanceof Entity\user)
    {
      throw new Http\NotFound('The requested user could not be found.');
    }

    $result = array(
        'id' => $user->getId(),
        'username' => $user->getUserName(),
        'slug' => $user->getSlug(),
        'email' => $user->getEmail(),
        'first_name' => $user->getFirsName(),
        'last_name' => $user->getLastName(),
        'country' => $user->getCountry(),
        'zip_code' => $user->getZipCode(),
        'gender' => $user->getGender(),
        'about' => $user->getAbout(),
        'language' => $user->getLanguage(),
        'last_update' => $user->lastUpdate(),
        'registered' => $user->registeredDate(),
        'birthday' => $user->birthdayDate(),
        'notification_max_time' => $user->notificationMaxTime(),
        'notification_min_time' => $user->notificationMinTime()
    );
    
    $fieldSelection = $this->getFieldsSelection();
    
    $properResult = $this->properResult($fieldSelection, $result);
    
    return new Response(\Statme\Utils::json_encode($properResult), self::GET_OK, self::JSON_HEADERS);
  }

}