<?php

namespace Stagem\ZfcSystem\Config;

return [
    'controllers' => [
        'sys-config' => [
            '@sysConfig_js',
            '@sysConfig_css',
            //'@sysConfig_images',
        ],
    ],
    'modules' => [
        __NAMESPACE__ => [
            'root_path' => __DIR__ . '/../view/assets',
            'collections' => [
                'sysConfig_css' => [
                    'assets' => [
                        'css/menu-drop-down.css',
                    ],
                    'options' => ['output' => 'sys-config.css'],
                ],
                'sysConfig_js' => [
                    'assets' => [
                        'js/menu-drop-down.js',
                        'js/sys-config.js',
                    ],
                ],
                'sysConfig_images' => [
                    'assets' => [
                        'images/*.png',
                        //'images/*.jpg',
                        //'images/*.gif',
                    ],
                    'options' => [
                        'move_raw' => true,
                        'disable_source_path' => true,
                        'targetPath' => 'images',
                    ],
                ],
            ],
        ],
    ],
];