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

use Stagem\ZfcPool\Model\PoolInterface;
use Stagem\ZfcSystem\Config\Model\Repository\ConfigRepository;
use Stagem\ZfcSystem\Config\Service\SysConfigService;

class SysConfig
{
    /**
     * @var SysConfigService
     */
    protected $sysConfigService;

    /**
     * @var PoolInterface
     */
    protected $currentPool;

    /**
     * Actual config
     *
     * @var array
     */
    protected $config = [];

    /**
     * Default config
     *
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * Is config normalized
     *
     * @var bool
     */
    protected $isNormalized = false;

    //public function __construct(ConfigRepository $configRepository, array $defaultConfig = null)
    public function __construct(SysConfigService $sysConfigService, PoolInterface $currentPool, array $defaultConfig = null)
    {
        $this->sysConfigService = $sysConfigService;
        $this->currentPool = $currentPool;
        $this->defaultConfig = $defaultConfig;
    }

    public function getSysConfigService()
    {
        return $this->sysConfigService;
    }

    public function getCurrentPool()
    {
        return $this->currentPool;
    }

    public function fetchConfig(string $path = null, PoolInterface $pool = null)
    {
        if (!$pool) {
            $pool = $this->getCurrentPool();
        }

        //return $this->sysConfigService->getFlatConfig($this->getCurrentPool());
        return $this->sysConfigService->getStructuredConfig($pool, $path);
    }

    public function normalize()
    {
        if ($this->isNormalized) {
            return;
        }

        $this->config = $this->fetchConfig();
        // @todo-serhii It is not effectively iterate config array on each request.
        // Think about some cache optimization. Clear cache on change in Admin configuration
        /*$rows = $this->fetchConfig();
        foreach ($rows as $row) {
            list($section, $group, $field) = explode('/', $row['path']);
            $this->config[$section][$group][$field] = $row['value'];
        }*/

        $this->isNormalized = true;
    }

    /**
     * @param string $path Path in format section/group/value
     * @return mixed|null
     */
    public function get(string $path)
    {
        if (!$this->isNormalized) {
            $this->normalize();
        }

        //list($section, $group, $field) = explode('/', $path);
        $paths = explode('/', $path);

        //return $this->config[$section][$group][$field] ?? $this->defaultConfig[$section][$group][$field] ?? null;

        return $this->getValue($paths, $this->config)/* ?: $this->getValue($paths, $this->defaultConfig)*/;
    }

    public function getValue($paths, $config)
    {
        /*$key = current($paths);
        if (isset($config[$key])) {
            $value = $this->getValue(array_shift($paths));
        } else {
            $value = false;
        }*/

        $fetched = false;
        foreach ($paths as $i => $path) {
            if ($i == 0 && isset($config[$path])) {
                $fetched = $config[$path];
            } elseif (isset($fetched[$path]['value'])) {
                $fetched = $fetched[$path]['value'];
            } elseif (isset($fetched[$path])) {
                $fetched = $fetched[$path];
            } else {
                return false;
            }
        }

        return $fetched;
    }
}