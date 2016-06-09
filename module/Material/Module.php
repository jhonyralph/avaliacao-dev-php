<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Material;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Material\Service\MaterialService;
use Doctrine\ORM\EntityManager;
use Livro\Form\LivroForm;
use Dicionario\Form\DicionarioForm;
use Livro\Format\LivroFormatData;
use Dicionario\Format\DicionarioFormatData;

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
                    'Livro' => __DIR__ . '/src/Livro',
                    'Dicionario' => __DIR__ . '/src/Dicionario'
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Livro\Service\LivroService' => function ($em)
                {
                    $entityManager = $em->get('Doctrine/ORM/EntityManager');
                    return new MaterialService( $entityManager, new LivroFormatData($entityManager));
                },
                'Dicionario\Service\DicionarioService' => function ($em)
                {
                    $entityManager = $em->get('Doctrine/ORM/EntityManager');
                    return new MaterialService( $entityManager, new DicionarioFormatData($entityManager));
                },
                'Livro\Form\LivroForm' => function ($em)
                {
                    return new LivroForm($em->get('Doctrine/ORM/EntityManager'));
                },
                'Dicionario\Form\DicionarioForm' => function ($em)
                {
                    return new DicionarioForm($em->get('Doctrine/ORM/EntityManager'));
                }
            )
        );
    }
}
