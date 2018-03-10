<?php

namespace Stagem\ZfcSystem\Config;

return [
    'system' => require 'system.config.php',

    'dependencies' => [
        'factories' => [
            SysConfig::class => Factory\SysConfigFactory::class,
            //Service\SysConfigService::class => Factory\SysConfigFactory::class,
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

    // middleware
    'templates' => [
        'paths' => [
            'admin-config'  => [__DIR__ . '/../view/admin/config'],
        ],
    ],

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