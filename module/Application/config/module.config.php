<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
//use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'auth' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/auth[/:action]',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'area' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/area[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\AreaController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'paciente' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/paciente[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\PacienteController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'tipo' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/tipo[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\TipoController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'odontograma' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/odontograma[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\OdontogramaController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'personal' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/personal[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\PersonalController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'tratamiento' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/tratamiento[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\TratamientoController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'medicamento' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/medicamento[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\MedicamentoController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'usuario' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/usuario[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\UsuarioController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'cita' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/cita[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\CitaController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'site' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/site[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\SiteController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
//    'controllers' => [
//        'factories' => [
//            Controller\IndexController::class => InvokableFactory::class,
//            Controller\AreaController::class => InvokableFactory::class,
//            Controller\PacienteController::class => InvokableFactory::class,
//        ],
//    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/empty'           => __DIR__ . '/../view/layout/empty.phtml',
            'layout/public'           => __DIR__ . '/../view/layout/public.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies'        =>  [
            'ViewJsonStrategy',
        ]
    ],
];
