<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ThreadStatus
 *
 * @author nico
 */

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity 
 * @ORM\Table(name="thread_status")
 */
class ThreadStatus
{

  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue 
   */
  protected $id;

  /**
   * @ORM\Column(name="name", type="string", length=32, unique=true, nullable=false)
   */
  protected $name;

  /**
   * @ORM\OneToMany(targetEntity="Thread", mappedBy="status")
   */
  protected $threads;

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

  public function __construct()
  {
    $this->threads = new ArrayCollection();
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

}

