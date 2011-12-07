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
 * @ORM\Table(name="notifications")
 */
class Notification
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue
   */
  protected $id;
 
  /**
   * @ORM\ManyToOne(targetEntity="NotificationType", inversedBy="notifications")
   * @ORM\JoinColumn(name="notification_type_id", referencedColumnName="id")
   */
  protected $type;
  
  /**
   * @var Datetime
   *
   * @Gedmo\Timestampable(on="create")
   * @ORM\Column(name="date", type="datetime")
   */
  protected $date;
  
  /**
   * @ORM\Column(name="readed", type="boolean")
   */
  protected $readed;
  
  /**
   * @ORM\Column(name="text", type="text")
   */
  protected $text;
  
  /** 
   * @ORM\OneToOne(targetEntity="user")
   * @ORM\JoinColumn(name="sender_id", referencedColumnName="id") 
   */
  protected $sender;
}