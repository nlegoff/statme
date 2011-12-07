<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StatComment
 *
 * @author nico
 */

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity 
 * @ORM\Table(name="comments")
 */
class Comment
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
   * @ORM\Column(name="content", type="text")
   */
  protected $content;
  
  /**
   * @var Datetime
   *
   * @Gedmo\Timestampable(on="create")
   * @ORM\Column(name="posted_date", type="datetime", nullable=false)
   */
  protected $postedDate;
  
  /**
   * @var Datetime
   * 
   * @Gedmo\Timestampable(on="update")
   * @ORM\Column(name="last_update", type="datetime", nullable=false)
   */
  protected $lastUpdate;
  
  /** 
   * @ORM\OneToOne(targetEntity="user")
   * @ORM\JoinColumn(name="author_id", referencedColumnName="id") 
   */
  protected $author;
  
  /**
   * @ORM\ManyToOne(targetEntity="Stat", inversedBy="stats")
   * @ORM\JoinColumn(name="stat_id", referencedColumnName="id")
   */
  protected $stat;

  public function __construct()
  {
    $this->alphaId = \Statme\Utils::alphaId();
  }
  
  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getContent()
  {
    return $this->content;
  }

  public function setContent($content)
  {
    $this->content = $content;
  }

  public function getPostedDate()
  {
    return $this->postedDate;
  }

  public function setPostedDate($postedDate)
  {
    $this->postedDate = $postedDate;
  }

  public function getLastUpdate()
  {
    return $this->lastUpdate;
  }

  public function setLastUpdate($lastUpdate)
  {
    $this->lastUpdate = $lastUpdate;
  }

  public function getAuthor()
  {
    return $this->author;
  }

  public function setAuthor($author)
  {
    $this->author = $author;
  }

  public function getStat()
  {
    return $this->stat;
  }

  public function setStat($stat)
  {
    $this->stat = $stat;
  }

}

