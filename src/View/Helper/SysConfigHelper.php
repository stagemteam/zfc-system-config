<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Serhii Popov
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Stagem
 * @package Stagem_System
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcSystem\Config\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Stagem\ZfcSystem\Config\SysConfig;

class SysConfigHelper extends AbstractHelper
{
    /**
     * @var SysConfig
     */
    protected $sysConfig;

    public function __construct(SysConfig $sysConfig)
    {
        $this->sysConfig = $sysConfig;
    }

    public function get($path)
    {
        return $this->sysConfig->getConfig($path);
    }

    public function __invoke()
    {
        $args = func_get_args();
        if (!$args) {
            return $this;
        }
        $path = $args[0];

        return $this->get($path);
    }
}