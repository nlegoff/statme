<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Subscription
 *
 * @author nico
 */

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity 
 * @ORM\Table(name="subscriptions")
 */
class Subscription
{

  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue 
   */
  protected $id;

  /**
   * @ORM\ManyToOne(targetEntity="User", inversedBy="subscriptions") 
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
   */
  protected $user;

  /**
   * @ORM\ManyToOne(targetEntity="Thread", inversedBy="subscriptions") 
   * @ORM\JoinColumn(name="thread_id", referencedColumnName="id")
   */
  protected $thread;

  /**
   * @ORM\Column(name="privacy", type="enumprivacy") 
   */
  protected $privacy;

  /**
   * @ORM\Column(name="status", type="enumsubscriptionstatus") 
   */
  protected $status;

  /**
   * @var Datetime
   *
   * @Gedmo\Timestampable(on="create")
   * @ORM\Column(name="date", type="datetime")
   */
  protected $date;

  /**
   * @ORM\OneToMany(targetEntity="Stat", mappedBy="subscription") 
   */
  protected $statistics;

  public function __construct()
  {
    $this->statistics = new ArrayCollection();
  }

  public function getId()
  {
    return $this->id;
  }

  public function getUser()
  {
    return $this->user;
  }

  public function setUser($user)
  {
    $this->user = $user;
  }

  public function getThread()
  {
    return $this->thread;
  }

  public function setThread($thread)
  {
    $this->thread = $thread;
  }

  public function getPrivacy()
  {
    return $this->privacy;
  }

  public function setPrivacy($privacy)
  {
    $this->privacy = $privacy;
  }

  public function getStatus()
  {
    return $this->status;
  }

  public function setStatus($status)
  {
    $this->status = $status;
  }

}

