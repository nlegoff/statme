<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Stat
 *
 * @author nico
 */

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity 
 * @ORM\Table(name="statistics")
 */
class Stat
{

  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue 
   */
  protected $id;

  /**
   * @ORM\Column(name="value", type="float", nullable=false)
   */
  protected $value;

  /**
   * @ORM\Column(name="point", type="point") 
   */
  protected $point;

  /**
   * @ORM\Column(name="latitude", type="float")
   */
  protected $latitude;

  /**
   * @ORM\Column(name="longitude", type="float")
   */
  protected $longitude;

  /**
   * @var Datetime
   *
   * @Gedmo\Timestampable(on="create")
   * @ORM\Column(name="date", type="datetime")
   */
  protected $date;

  /**
   * @ORM\ManyToOne(targetEntity="Subscription", inversedBy="statistics")
   * @ORM\JoinColumn(name="subscription_id", referencedColumnName="id")
   */
  protected $subscription;

  /**
   * @ORM\OneToMany(targetEntity="subscription", mappedBy="user") 
   */
  protected $comments;

  public function __construct()
  {
    $this->comments = new ArrayCollection();
  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getValue()
  {
    return $this->value;
  }

  public function setValue($value)
  {
    $this->value = $value;
  }

  public function getPoint()
  {
    return $this->point;
  }

  public function setPoint($point)
  {
    $this->point = $point;
  }

  public function getLatitude()
  {
    return $this->latitude;
  }

  public function setLatitude($latitude)
  {
    $this->latitude = $latitude;
  }

  public function getLongitude()
  {
    return $this->longitude;
  }

  public function setLongitude($longitude)
  {
    $this->longitude = $longitude;
  }

  public function getSubscription()
  {
    return $this->subscription;
  }

  public function setSubscription($subscription)
  {
    $this->subscription = $subscription;
  }

}

