<?php

namespace Company;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\CompanyController::class => Controller\Factory\CompanyControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'company' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/company',
                    'defaults' => [
                        'controller' => Controller\CompanyController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'overview' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/overview[/page/:page]',
                            'defaults' => [
                                'action' => 'overview',
                                'page' => 1,
                            ],
                            'constraints' => [
                                'page' => '\d+',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'company' => __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'invokables' => [
            Entity\Factory\CompanyHydratorFactory::class => Entity\Factory\CompanyHydratorFactory::class,
        ],
        'aliases' => [
            Model\CompanyModelInterface::class => Model\CompanyModel::class,
            Model\ImageModelInterface::class => Model\ImageModel::class,
        ],
        'factories' => [
            Model\CompanyModel::class => Model\Factory\CompanyModelFactory::class,
            Model\ImageModel::class => Model\Factory\ImageModelFactory::class,
            Service\CompanyFormServiceInterface::class => Service\Factory\CompanyFormServiceFactory::class,
        ],
    ],
];