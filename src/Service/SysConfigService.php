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
 * @package Stagem_ZfcSystem
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcSystem\Config\Service;

use Stagem\ZfcPool\Model\PoolInterface;
use Stagem\ZfcPool\Service\PoolService;
use Stagem\ZfcSystem\Config\Model\Config;
use Stagem\ZfcSystem\Config\Model\Repository\ConfigRepository;
use Popov\ZfcCore\Service\DomainServiceAbstract;
use Popov\Db\Db;

/**
 * Class SysConfigService
 *
 * @method ConfigRepository getRepository()
 */
class SysConfigService extends DomainServiceAbstract
{
    const SECTION_DEFAULT = 'general';

    protected $entity = Config::class;

    /**
     * @var Db
     */
    protected $db;

    /**
     * @var PoolInterface
     */
    //protected $currentPool;

    //protected $defaultConfig;

    protected $systemConfig;

    protected $flatConfig = [];

    protected $structuredConfig = [];

    public function __construct(Db $db, array $config)
    {
        $this->db = $db;
        $this->systemConfig = $config['system'];
    }

    public function getDb()
    {
        #static $isConnected = false;
        #if (!$isConnected ) {
        #    $this->db->setPdo($this->getObjectManager()->getConnection());
        #    $isConnected = true;
        #}

        return $this->db;
    }

    public function getSystemConfig()
    {
        return $this->systemConfig;
    }

    public function getStructuredConfig($pool /*= null*/, $sectionName = null)
    {
        if (isset($this->structuredConfig[$pool->getId()])) {
            $structured = $this->structuredConfig[$pool->getId()];
            if (isset($structured[$sectionName])) {
                $structured = $structured[$sectionName];
            }

            return $structured;
        }

        #if (is_null($pool)) {
        #    $pool = $this->getCurrentPool();
        #}
        $repository = $this->getRepository();
        #$sysConfigs = $repository->findConfig($pool, $sectionName ? $sectionName . '/%' : '');
        $sysConfigs = $repository->findConfig($pool/*, $sectionName ? $sectionName . '/%' : ''*/);

        $defaultConfig = $this->systemConfig['default'];

        $structured = [];
        foreach ($sysConfigs as $config) {
            list($section, $group, $field) = explode('/', $config['path']);
            //$parts = explode('/', $config['path']);

            if (isset($structured[$section][$group][$field])
                && $structured[$section][$group][$field]['inherit']
                && ($config['pool'] == PoolService::POOL_ADMIN)
            ) {
                // It allow catch situation when specific "pool" value was set before iterate through default "pool".
                // If set "inherit" override with value from default database config
                $config['pool'] = $structured[$section][$group][$field]['pool'];
                //$config['pool'] = $structure[$section][$group][$field]['pool'];
                //$structure[$section][$group][$field]['value'] = $config['value'];

            } elseif ($config['inherit'] && isset($defaultConfig[$section][$group][$field])) {
                // Default database row cannot be inherit=1, it always must be inherit=0.
                // Based on this we take as granted that row in database always is inherit=0.
                // If default value is already in database it cannot be override with default value from config.
                $config['value'] = $defaultConfig[$section][$group][$field];
            }

            $structured[$section][$group][$field] = $config;
            #$this->flatConfig[$section . '/' . $group . '/' . $field] = $config['value'];

            // unset default config such as we already has it in DB
            unset($defaultConfig[$section][$group][$field]);
        }

        // Add default value from file if relative has not registered in database
        foreach ($defaultConfig as $name => $sectionConfig) {
            if ($sectionName && $sectionName !== $name) {
                continue;
            }
            foreach ($sectionConfig as $groupName => $fieldConfig) {
                foreach ($fieldConfig as $fieldName => $fieldValue) {
                    //list($section, $group, $field) = explode('/', $config['path']);
                    $structured[$name][$groupName][$fieldName] = [
                        'path' => $name . '/' . $groupName . '/' . $fieldName,
                        'value' => $fieldValue,
                        //'poolId' => PoolService::POOL_ADMIN,
                        'poolId' => $pool->getId(),
                        'inherit' => ($pool->getId() == PoolService::POOL_ADMIN) ? false : true,
                    ];

                    #$this->flatConfig[$name . '/' . $groupName . '/' . $fieldName] = $fieldValue;
                }
            }
        }

        return $this->structuredConfig[$pool->getId()] = $structured;
    }

    public function save($data)
    {
        $em = $this->getObjectManager();
        //$connection = $em->getConnection()/*->exec($sql)*/;
        $tableName = $em->getClassMetadata($this->entity)->getTableName();


        $rows = [];
        foreach ($data as $section => $groups) {
            foreach ($groups as $groupName => $group) {
                foreach ($group as $name => $option) {
                    $option['path'] = sprintf('%s/%s/%s', $section, $groupName, $name);
                    $rows[] = $option;
                }
            }
        }

        $this->getDb()->multipleSave($tableName, $rows);
    }
}