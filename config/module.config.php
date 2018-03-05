<?php

namespace Stagem\ZfcSystem\Config;

return [
    'dependencies' => [
        'factories' => [
            SysConfig::class => Factory\SysConfigFactory::class,
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