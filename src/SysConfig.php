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
 * @package Stagem_System
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcSystem\Config;

//use Doctrine\ORM\NativeQuery;
use Stagem\ZfcSystem\Config\Model\Repository\ConfigRepository;

class SysConfig
{
    /**
     * @var ConfigRepository
     */
    protected $configRepository;

    protected $config = [];

    protected $isNormalized = false;

    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function fetchConfig()
    {
        return $this->configRepository->findConfig();
    }

    public function normalize()
    {
        if ($this->isNormalized) {
            return;
        }

        $rows = $this->fetchConfig();
        foreach ($rows as $row) {
            $this->config[$row['path']] = $row['value'];
        }

        $this->isNormalized = true;
    }

    public function getConfig(string $path)
    {
        if (!$this->isNormalized) {
            $this->normalize();
        }

        return isset($this->config[$path]) ? $this->config[$path] : false;
    }
}