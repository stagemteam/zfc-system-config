<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Stagem
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Stagem
 * @package Stagem_ZfcSystem
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcSystem\Config\Factory;

use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Stagem\ZfcPool\PoolHelper;
use Stagem\ZfcPool\Service\PoolService;
use Stagem\ZfcSystem\Config\Model\Config;
use Stagem\ZfcSystem\Config\Service\SysConfigService;
use Stagem\ZfcSystem\Config\SysConfig;

class SysConfigFactory
{
    public function __invoke(ContainerInterface $container)
    {
        //$repository = $container->get(EntityManager::class)->getRepository(Config::class);
        $repository = $container->get(SysConfigService::class);
        $config = $container->get('config')['system']['default'];
        $currentPool = $container->get(PoolHelper::class)->current();

        $sysConfig = new SysConfig($repository, $currentPool, $config);

        return $sysConfig;
    }
}