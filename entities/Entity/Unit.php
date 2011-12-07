<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Category
 *
 * @author nico
 */

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="units")
 * use repository for handy tree functions
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 */
class Unit
{

  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue
   */
  protected $id;

  /**
   * @Gedmo\Translatable
   * @ORM\Column(name="title", type="string", length=64, unique=true)
   */
  protected $title;

  /**
   * @Gedmo\Slug(handlers={
   *      @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\TreeSlugHandler", options={
   *          @Gedmo\SlugHandlerOption(name="parentRelationField", value="parent"),
   *          @Gedmo\SlugHandlerOption(name="separator", value="/")
   *      })
   * }, separator="-", updatable=true, fields={"title"})
   * @ORM\Column(name="slug", type="string", length=128, unique=true)
   */
  protected $slug;

  /**
   * @Gedmo\Locale
   */
  protected $locale;

  /**
   * @Gedmo\TreeLeft
   * @ORM\Column(name="lft", type="integer")
   */
  protected $lft;

  /**
   * @Gedmo\TreeLevel
   * @ORM\Column(name="lvl", type="integer")
   */
  protected $lvl;

  /**
   * @Gedmo\TreeRight
   * @ORM\Column(name="rgt", type="integer")
   */
  protected $rgt;

  /**
   * @Gedmo\TreeRoot
   * @ORM\Column(name="root", type="integer")
   */
  protected $root;

  /**
   * @Gedmo\TreeParent
   * @ORM\ManyToOne(targetEntity="Unit", inversedBy="children")
   */
  protected $parent;

  /**
   * @ORM\OneToMany(targetEntity="Unit", mappedBy="parent")
   * @ORM\OrderBy({"lft" = "ASC"})
   */
  protected $children;

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
   * @ORM\ManyToOne(targetEntity="UnitType", inversedBy="units")
   * @ORM\JoinColumn(name="unit_type_id", referencedColumnName="id")
   */
  protected $type;

  /**
   * @ORM\OneToMany(targetEntity="Thread", mappedBy="unit")
   */
  protected $threads;

  public function __construct()
  {
    $this->threads = new ArrayCollection();
  }

  public function getId()
  {
    return $this->id;
  }

  public function setTitle($title)
  {
    $this->title = $title;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function setParent(Category $parent)
  {
    $this->parent = $parent;
  }

  public function getParent()
  {
    return $this->parent;
  }

  public function getType()
  {
    return $this->type;
  }

  public function setType($type)
  {
    $this->type = $type;
  }

  public function setTranslatableLocale($locale)
  {
    $this->locale = $locale;
  }

}

