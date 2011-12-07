<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bootstrap
 *
 * @author nico
 */

namespace Statme;

define('ROOT_PATH', __DIR__ . '/../..');
define('APPLICATION_CONFIG_FILE', ROOT_PATH . '/config/config.yml');
define('DATABASE_CONNECTION_FILE', ROOT_PATH . '/config/db.yml');
define('ROUTING_FILE', ROOT_PATH . '/config/routing.yml');

if (false === class_exists('Symfony\Component\ClassLoader\UniversalClassLoader'))
{
  require_once ROOT_PATH . '/vendor/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';
}

class Application
{

  /**
   *
   * @var Array 
   */
  protected static $config = null;

  /**
   *
   * @var Array 
   */
  protected static $connectionOptions = null;

  /**
   *
   * @var \Doctrine\ORM\EntityManager 
   */
  protected static $entityManager = null;

  /**
   * Return app configuration file as an key/value associative array
   * keys are the option's name
   * values are the value of options
   * @return Array 
   */
  public static function getConfig()
  {
    if (self::$config === null)
    {
      self::$config = \Symfony\Component\Yaml\Yaml::parse(APPLICATION_CONFIG_FILE);
    }

    return self::$config;
  }

  /**
   * Return app connections options from database configuration file
   * @return Array 
   */
  protected static function getConnectionOptions()
  {
    if (self::$connectionOptions === null)
    {
      self::$connectionOptions = \Symfony\Component\Yaml\Yaml::parse(DATABASE_CONNECTION_FILE);
    }

    return self::$connectionOptions;
  }

  /**
   * Register application namespaces
   * @return void
   */
  public static function registerNamespaces()
  {
    $classLoader = new \Symfony\Component\ClassLoader\UniversalClassLoader();
    $classLoader->registerNamespaces(array(
        'Gedmo' => ROOT_PATH . '/vendor/doctrine-extension/lib',
        'Symfony' => ROOT_PATH . '/vendor/symfony/src',
        'Statme' => ROOT_PATH . '/src',
        'Doctrine\\Common' => ROOT_PATH . '/vendor/doctrine-common/lib',
        'Doctrine\\DBAL' => ROOT_PATH . '/vendor/doctrine-dbal/lib',
        'Doctrine' => ROOT_PATH . '/vendor/doctrine-orm/lib',
    ));

    $classLoader->register();

    return;
  }

  /**
   * Bootstrap the app
   * @return void 
   */
  public static function bootstrap()
  {
    if (!class_exists("Doctrine\Common\Version", false))
    {
      self::registerNamespaces();
    }

    $isDevMode = true;
    $entityPath = ROOT_PATH . '/entities';
    $proxyPath = ROOT_PATH . '/proxies';

    $reader = new \Doctrine\Common\Annotations\AnnotationReader();
    $annotationDriver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver($reader);
    \Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
            'Gedmo\\Mapping\\Annotation', ROOT_PATH . '/vendor/doctrine-extension/lib'
    );

    $driverChain = new \Doctrine\ORM\Mapping\Driver\DriverChain();

    $annotationDriver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(
                    $reader,
                    array(
                        ROOT_PATH . '/entities/Entity',
                        ROOT_PATH . '/vendor/doctrine-extension/lib/Gedmo/Translatable/Entity',
                        ROOT_PATH . '/vendor/doctrine-extension/lib/Gedmo/Tree/Entity',
            ));

    //Drivers
    $driverChain->addDriver($annotationDriver, 'Gedmo\\Translatable\\Entity');
    $driverChain->addDriver($annotationDriver, 'Gedmo\\Tree\\Entity');
    $driverChain->addDriver($annotationDriver, 'Entity');

    //Tell doctrine that we use annotations for entities
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
                    array($entityPath), $isDevMode, $proxyPath
    );

    $config->setMetadataDriverImpl($driverChain);

    //Attach listener to the event system event manager
    $eventManager = new \Doctrine\Common\EventManager();

    $treeListener = new \Gedmo\Tree\TreeListener();
    $treeListener->setAnnotationReader($reader);
    $eventManager->addEventSubscriber($treeListener);

    $sluggableListener = new \Gedmo\Sluggable\SluggableListener();
    $sluggableListener->setAnnotationReader($reader);
    $eventManager->addEventSubscriber($sluggableListener);

    $translationListener = new \Gedmo\Translatable\TranslationListener();
    $translationListener->setAnnotationReader($reader);
    $translationListener->setTranslatableLocale('en_us');
    $eventManager->addEventSubscriber($translationListener);

    $timestampListener = new \Gedmo\Timestampable\TimestampableListener();
    $timestampListener->setAnnotationReader($reader);
    $eventManager->addEventSubscriber($timestampListener);

    $sortableListener = new \Gedmo\Sortable\SortableListener();
    $sortableListener->setAnnotationReader($reader);
    $eventManager->addEventSubscriber($sortableListener);

    //Obtaining the entity manager
    $entityManager = \Doctrine\ORM\EntityManager::create(
                    self::getConnectionOptions(), $config, $eventManager
    );

    //Register app type
    \Doctrine\DBAL\Types\Type::addType('point', 'Statme\ORM\PointType');
    \Doctrine\DBAL\Types\Type::addType('enumgender', 'Statme\ORM\Enum\GenderType');
    \Doctrine\DBAL\Types\Type::addType('enumthreadstatus', 'Statme\ORM\Enum\ThreadStatusType');
    \Doctrine\DBAL\Types\Type::addType('enumunittype', 'Statme\ORM\Enum\UnitType');
    \Doctrine\DBAL\Types\Type::addType('enumprivacy', 'Statme\ORM\Enum\PrivacyType');
    \Doctrine\DBAL\Types\Type::addType('enumsubscriptionstatus', 'Statme\ORM\Enum\SubscriptionStatusType');

    //Register point type for schema tool
    $platform = $entityManager->getConnection()->getDatabasePlatform();
    $platform->registerDoctrineTypeMapping('point', 'point');
    $platform->registerDoctrineTypeMapping('enum', 'string');
    $platform->registerDoctrineTypeMapping('enumgender', 'enumgender');
    $platform->registerDoctrineTypeMapping('enumthreadstatus', 'enumthreadstatus');
    $platform->registerDoctrineTypeMapping('enumunittype', 'enumunittype');
    $platform->registerDoctrineTypeMapping('enumprivacy', 'enumprivacy');
    $platform->registerDoctrineTypeMapping('enumsubscriptionstatus', 'enumsubscriptionstatus');

    self::$entityManager = $entityManager;

    return;
  }

  /**
   * Return an application entity manager
   * @return \Doctrine\ORM\EntityManager
   */
  public static function getEntityManager()
  {
    if (self::$entityManager === null)
    {
      self::bootstrap();
    }

    return self::$entityManager;
  }

}
