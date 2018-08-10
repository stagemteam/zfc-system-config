<?php

namespace Stagem\ZfcSystem\Config;

return [

    'assetic_configuration' => require_once 'assets.config.php',

    'system' => require 'system.config.php',

    'navigation' => require 'navigation.config.php',

    'actions' => [
        'sys-config' => __NAMESPACE__ . '\\Action',
    ],

    'dependencies' => [
        'factories' => [
            SysConfig::class => Factory\SysConfigFactory::class,
            Service\SysConfigService::class => Service\Factory\SysConfigServiceFactory::class,
        ],
    ],

    'form_elements' => [
        'factories' => [
            Form\ConfigForm::class => Form\Factory\ConfigFormFactory::class,
        ],
    ],

    'view_helpers' => [
        'aliases' => [
            'sysConfig' => View\Helper\SysConfigHelper::class,
        ],
        /*'invokables' => [
            View\Helper\SysConfigHelper::class => View\Helper\SysConfigHelper::class,
        ],*/
    ],

    // MVC
    'view_manager' => [
        'prefix_template_path_stack' => [
            'sys-config::' => __DIR__ . '/../view',
        ],
    ],

    // middleware
    /*'templates' => [
        'paths' => [
            'admin-config'  => [__DIR__ . '/../view/admin/config'],
        ],
    ],*/

    // Doctrine config
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src//Model'],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Model' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
];