<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Stagem Team
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Stagem
 * @package Stagem_Product
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

// @link http://adam.lundrigan.ca/2012/07/quick-and-dirty-zf2-zend-navigation/
namespace Stagem\ZfcSystem\Config;

return [
    'admin' => [
        'system' => [
            'module' => 'system',
            'label' => 'Settings',
            'route' => 'admin/default',
            'controller' => 'sys-config',
            'action' => 'edit',
            'order' => 200,

            'pages' => [
                Model\Config::MNEMO => [
                    'module' => 'system',
                    'label' => 'Configuration',
                    'route' => 'admin/default',
                    'controller' => 'sys-config',
                    'action' => 'edit',
                    'order' => 200
                ],
            ]
        ],
    ],
];