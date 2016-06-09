<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Autor;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Autor\Service\AutorService;
use Doctrine\ORM\EntityManager;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $translatorI18n = new \Zend\I18n\Translator\Translator();
        $translatorI18n->setLocale('pt_BR');
        
        $translator = new \Zend\Mvc\I18n\Translator($translatorI18n);
        $translator->addTranslationFile(
            'phpArray',
            'vendor/zendframework/zend-i18n-resources/languages/pt_BR/Zend_Validate.php',
            'default',
            'pt_BR'
        );
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Autor\Service\AutorService' => function ($em)
                {
                    return new AutorService($em->get('Doctrine/ORM/EntityManager'));
                }
            )
        );
    }
}
