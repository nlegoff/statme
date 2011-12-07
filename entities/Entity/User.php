<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author nico
 */

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{

  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue 
   */
  protected $id;

  /**
   * @ORM\Column(name="username", type="string", length=32, unique=true, nullable=false)
   */
  protected $userName;

  /**
   * @Gedmo\Slug(fields={"userName"})
   * @ORM\Column(name="slug", type="string", length=128, unique=true, nullable=false)
   */
  protected $slug;

  /**
   * @ORM\Column(name="password", type="string", length=128, nullable=false)
   */
  protected $password;

  /**
   * @ORM\Column(name="email", type="string", length=128, unique=true, nullable=false)
   */
  protected $email;

  /**
   * @var Datetime
   *
   * @Gedmo\Timestampable(on="create")
   * @ORM\Column(name="registered_date", type="datetime", nullable=false)
   */
  protected $registeredDate;

  /**
   * @var Datetime
   * 
   * @Gedmo\Timestampable(on="update")
   * @ORM\Column(name="last_update", type="datetime", nullable=false)
   */
  protected $lastUpdate;

  /**
   * @ORM\Column(name="activated", type="boolean", nullable=false)
   */
  protected $activated;

  /**
   * @ORM\Column(name="first_name", type="string", length=64, nullable=true)
   */
  protected $firstName;

  /**
   * @ORM\Column(name="last_name", type="string", length=64, nullable=true)
   */
  protected $lastName;

  /**
   * @ORM\Column(name="activation_key", type="string", length=128, nullable=true)
   */
  protected $activationKey;

  /**
   * @ORM\Column(name="country_code", type="string", columnDefinition="CHAR(2)", nullable=false)
   */
  protected $countryCode;

  /**
   * @ORM\Column(name="country", type="string", length=64, nullable=true)
   */
  protected $country;

  /**
   * @ORM\Column(name="city", type="string", length=64, nullable=true)
   */
  protected $city;

  /**
   * @ORM\Column(name="zip_code", type="string", length=16, nullable=true)
   */
  protected $zipCode;

  /**
   * @ORM\Column(name="gender", type="enumgender", nullable=true) 
   */
  protected $gender;

  /**
   * @ORM\Column(name="birthday_date", type="datetime", nullable=true)
   */
  protected $birthdayDate;

  /**
   * @ORM\Column(name="about", type="string", length=255, nullable=true)
   */
  protected $about;

  /**
   * @ORM\Column(name="language", type="string", columnDefinition="CHAR(2)")
   */
  protected $language;

  /**
   * @ORM\Column(name="notification_max_time", type="integer", nullable=true)
   */
  protected $notificationMaxTime;

  /**
   * @ORM\Column(name="notification_min_time", type="integer", nullable=true)
   */
  protected $notificationMinTime;

  /**
   * @ORM\ManyToMany(targetEntity="User", mappedBy="myFriends")
   */
  protected $friendsWithMe;

  /**
   * @ORM\ManyToMany(targetEntity="User", inversedBy="friendsWithMe")
   * @ORM\JoinTable(name="friends",
   *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="friend_user_id", referencedColumnName="id")}
   *      )
   */
  protected $myFriends;
  
    /**
   * @ORM\ManyToMany(targetEntity="User", mappedBy="myBannedNotificationsSender")
   */
  protected $notificationSenderBannedByMe;

  /**
   * @ORM\ManyToMany(targetEntity="User", inversedBy="notificationSenderBannedByMe")
   * @ORM\JoinTable(name="banned_notifications_senders",
   *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="notification_sender_id", referencedColumnName="id")}
   *      )
   */
  protected $myBannedNotificationsSender;

  /**
   * @ORM\OneToMany(targetEntity="subscription", mappedBy="user") 
   */
  protected $subscriptions;

  /**
   * @ORM\ManyToMany(targetEntity="Thread", inversedBy="userFavorites")
   * @ORM\JoinTable(name="user_favorite_threads",
   *   joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
   *   inverseJoinColumns={@ORM\JoinColumn(name="favorite_thread_id", referencedColumnName="id")}
   * )
   */
  protected $favoritesThreads;

  /** 
   * @ORM\ManyToMany(targetEntity="Notification") 
   * @ORM\JoinTable(name="users_notifications", 
   *  joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}, 
   *  inverseJoinColumns={@ORM\JoinColumn(name="notification_id", referencedColumnName="id", unique=true)} 
   * )
   */
  protected $notifications;
  
  public function __construct()
  {
    $this->subscriptions = new ArrayCollection();
    $this->activationKey = \Statme\Utils\Uid::generateRandToken();
    $this->activated = 0;
    $this->about = '';
  }

  public function getId()
  {
    return $this->id;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function setEmail($email)
  {
    $this->email = $email;
  }

  public function getRegistered()
  {
    return $this->registered;
  }

  public function setRegistered($registered)
  {
    $this->registered = $registered;
  }

  public function getActivated()
  {
    return $this->activated;
  }

  public function setActivated($activated)
  {
    $this->activated = $activated;
  }

  public function getFirstName()
  {
    return $this->firstName;
  }

  public function setFirstName($firstName)
  {
    $this->firstName = $firstName;
  }

  public function getLastName()
  {
    return $this->lastName;
  }

  public function setLastName($lastName)
  {
    $this->lastName = $lastName;
  }

  public function getDisplayName()
  {
    return $this->displayName;
  }

  public function setDisplayName($displayName)
  {
    $this->displayName = $displayName;
  }

  public function getActivationKey()
  {
    return $this->activationKey;
  }

  public function setActivationKey($activationKey)
  {
    $this->activationKey = $activationKey;
  }

  public function getCountry()
  {
    return $this->country;
  }

  public function setCountry($country)
  {
    $this->country = $country;
  }

  public function getCity()
  {
    return $this->city;
  }

  public function setCity($city)
  {
    $this->city = $city;
  }

  public function getZipCode()
  {
    return $this->zipCode;
  }

  public function setZipCode($zipCode)
  {
    $this->zipCode = $zipCode;
  }

  public function getGender()
  {
    return $this->gender;
  }

  public function setGender($gender)
  {
    $this->gender = $gender;
  }

  public function getBirthday()
  {
    return $this->birthday;
  }

  public function setBirthday($birthday)
  {
    $this->birthday = $birthday;
  }

  public function getAbout()
  {
    return $this->about;
  }

  public function setAbout($about)
  {
    $this->about = $about;
  }

  public function getLanguage()
  {
    return $this->language;
  }

  public function setLanguage($language)
  {
    $this->language = $language;
  }

  public function getNotificationMaxTime()
  {
    return $this->notificationMaxTime;
  }

  public function setNotificationMaxTime($notificationMaxTime)
  {
    $this->notificationMaxTime = $notificationMaxTime;
  }

  public function getNotificationMinTime()
  {
    return $this->notificationMinTime;
  }

  public function setNotificationMinTime($notificationMinTime)
  {
    $this->notificationMinTime = $notificationMinTime;
  }

}

