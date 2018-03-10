<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Serhii Popov
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Popov
 * @package Popov_<package>
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcSystem\Config\Form\Factory;

use Psr\Container\ContainerInterface;
use Stagem\ZfcSystem\Config\Form\ConfigForm;

class ConfigFormFactory
{
    public function __invoke(ContainerInterface $container, $name, array $options = null)
    {
        $form = new ConfigForm('system', $options);
        $form->setSysConfig($container->get('config')['system']);

        return $form;
    }
}