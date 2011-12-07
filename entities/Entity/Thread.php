<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Thread
 *
 * @author nico
 */

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="threads")
 */
class Thread
{

  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue 
   */
  protected $id;

  /**
   * @ORM\Column(name="alpha_id", type="string", length=32, unique=true, nullable=false)
   */
  protected $alphaId;

  /**
   * @Gedmo\Translatable
   * @ORM\Column(name="title", type="string", length=128, nullable=false, unique=true)
   */
  protected $title;

  /**
   * @Gedmo\Slug(fields={"title"})
   * @ORM\Column(name="slug", type="string", length=128, unique=true)
   */
  protected $slug;

  /**
   * @Gedmo\Translatable
   * @ORM\Column(name="description", type="string", length=255)
   */
  protected $description;

  /**
   * @Gedmo\Locale
   */
  protected $locale;

  /**
   * @ORM\ManyToOne(targetEntity="User", inversedBy="threadsSubmitted")
   * @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
   */
  protected $submitter;

  /**
   * @ORM\Column(name="interval_stat_time", type="time")
   */
  protected $intervalStatTime;

  /**
   * @ORM\Column(name="interval_stat_distance", type="integer")
   */
  protected $intervalStatDistance;

  /**
   * @ORM\Column(name="max_value", type="integer")
   */
  protected $maxValue;

  /**
   * @ORM\Column(name="min_value", type="integer")
   */
  protected $minValue;

  /**
   * @var Datetime
   *
   * @Gedmo\Timestampable(on="create")
   * @ORM\Column(name="created_date", type="datetime")
   */
  protected $createdDate;

  /**
   * @var Datetime
   * 
   * @Gedmo\Timestampable(on="update")
   * @ORM\Column(name="last_update", type="datetime", nullable=false)
   */
  protected $lastUpdate;

  /**
   * @ORM\ManyToOne(targetEntity="Category", inversedBy="threads")
   * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
   */
  protected $category;

  /**
   * @ORM\ManyToOne(targetEntity="ThreadStatus", inversedBy="threads")
   * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
   */
  protected $status;

  /**
   * @ORM\ManyToOne(targetEntity="Unit", inversedBy="threads")
   * @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
   */
  protected $unit;

  /**
   * @ORM\OneToMany(targetEntity="Subscription", mappedBy="thread") 
   */
  protected $subscriptions;

  /**
   * @ORM\ManyToMany(targetEntity="User", mappedBy="favoritesThreads")
   */
  protected $userFavorites;

  public function __construct()
  {
    $this->subscriptions = new ArrayCollection();
    $this->alphaId = \Statme\Utils::alphaId();
  }
  
  public function getId()
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function setDescription($description)
  {
    $this->description = $description;
  }

  public function getCreator()
  {
    return $this->creator;
  }

  public function setCreator($creator)
  {
    $this->creator = $creator;
  }

  public function getStatus()
  {
    return $this->status;
  }

  public function setStatus($status)
  {
    $this->status = $status;
  }

  public function getUnit()
  {
    return $this->unit;
  }

  public function setUnit($unit)
  {
    $this->unit = $unit;
  }

  public function getCategory()
  {
    return $this->category;
  }

  public function setCategory($category)
  {
    $this->category = $category;
  }

  public function getIntervalStatTime()
  {
    return $this->intervalStatTime;
  }

  public function setIntervalStatTime($intervalStatTime)
  {
    $this->intervalStatTime = $intervalStatTime;
  }

  public function getIntervalStatDistance()
  {
    return $this->intervalStatDistance;
  }

  public function setIntervalStatDistance($intervalStatDistance)
  {
    $this->intervalStatDistance = $intervalStatDistance;
  }

  public function getMaxValue()
  {
    return $this->maxValue;
  }

  public function setMaxValue($maxValue)
  {
    $this->maxValue = $maxValue;
  }

  public function getMinValue()
  {
    return $this->minValue;
  }

  public function setMinValue($minValue)
  {
    $this->minValue = $minValue;
  }

}

?>
