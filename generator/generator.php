<?php
ini_set("display_errors", "On");
include '../vendor/autoload.php';

$classLoader = new \Doctrine\Common\ClassLoader('Entities', __DIR__);
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Proxies', __DIR__);
$classLoader->register();

// config
$config = new \Doctrine\ORM\Configuration();
$config->setMetadataDriverImpl(
    $config->newDefaultAnnotationDriver(__DIR__ . '/Entities')
);
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
$config->setProxyDir(__DIR__ . '/Proxies');
$config->setProxyNamespace('Proxies');

$doctrineConfig = include '../config/autoload/doctrine_orm.local.php';
$connectionParams = $doctrineConfig['doctrine']['connection']['orm_default']['params'];
unset($connectionParams['driverOptions']);
$connectionParams['driver'] = 'pdo_mysql';

$em = \Doctrine\ORM\EntityManager::create($connectionParams, $config);
// custom datatypes (not mapped for reverse engineering)
$em->getConnection()
    ->getDatabasePlatform()
    ->registerDoctrineTypeMapping('set', 'string');
$em->getConnection()
    ->getDatabasePlatform()
    ->registerDoctrineTypeMapping('enum', 'string');
// fetch metadata
$driver = new \Doctrine\ORM\Mapping\Driver\DatabaseDriver(
    $em->getConnection()->getSchemaManager()
);
$em->getConfiguration()->setMetadataDriverImpl($driver);

$cmf = new \Doctrine\ORM\Tools\DisconnectedClassMetadataFactory($em);
$cmf->setEntityManager($em);

$classes = $driver->getAllClassNames();
$metadata = $cmf->getAllMetadata();

$generator = new Doctrine\ORM\Tools\EntityGenerator();
$generator->setUpdateEntityIfExists(true);
$generator->setGenerateStubMethods(true);
$generator->setGenerateAnnotations(true);

$entityLocation = require 'EntityLocation.php';

foreach ($metadata as $entity){
    if (array_key_exists($entity->table['name'], $entityLocation)){
        $generator->generate(array($entity), 
            __DIR__ . '/../module/' . $entityLocation[$entity->table['name']]['module'] . 
            '/src/' . $entityLocation[$entity->table['name']]['module'] . '/Entity');
    } else {
        echo 'Module location not found for "' . $entity->table['name'] . '" <br>'; 
    }
}
print 'Done!';