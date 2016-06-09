<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Autor;

$_namespaceLower = strtolower(__NAMESPACE__);

return array(
	'doctrine' => array(
		'driver' => array(
			__NAMESPACE__ . '_entities' => array(
				'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
			),
			'orm_default' => array(
				'drivers' => array(
					__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_entities'
				)
			)
		)
	),
    'router' => array(
        'routes' => array(
            $_namespaceLower => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/' . $_namespaceLower,
                    'defaults' => array(
                        'controller' => __NAMESPACE__ . '\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:action[/:id]]',
                            'constraints' => array(
                                'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'        => '\d+'
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            __NAMESPACE__ . '\Controller\Index' => Controller\IndexController::class
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../../Base/view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../../Base/view/error/404.phtml',
            'error/index'             => __DIR__ . '/../../Base/view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
            __DIR__ . '/../../Base/view/include'
        ),
    )
);