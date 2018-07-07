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
 * @package Stagem_ZfcSystem
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcSystem\Config\Service\Factory;

use Popov\Db\Db;
use Psr\Container\ContainerInterface;
use Stagem\ZfcPool\Service\PoolService;
use Stagem\ZfcSystem\Config\Service\SysConfigService;

class SysConfigServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        $db = $container->get(Db::class);
        //$currentPool = $container->get(PoolService::class)->getCurrent();

        $sysConfigService = new SysConfigService(/*$currentPool, */$db, $config);

        return $sysConfigService;
    }
}