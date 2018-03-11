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
    protected $entity = Config::class;

    /**
     * @var Db
     */
    protected $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function getDb()
    {
        static $isConnected = false;
        if (!$isConnected ) {
            $this->db->setPdo($this->getObjectManager()->getConnection());
            $isConnected = true;
        }

        return $this->db;
    }


    public function getStructuredConfig($path)
    {
        $repository = $this->getRepository();
        $sysConfig = $repository->findConfig($path);

        $structure = [];
        foreach ($sysConfig as $config) {
            $parts = explode('/', $config['path']);
            /*$structure[$parts[0]][$parts[1]][$parts[2] . '_id'] = $config['id'];
            $structure[$parts[0]][$parts[1]][$parts[2] . '_scope'] = $config['scope'];
            $structure[$parts[0]][$parts[1]][$parts[2]] = $config['value'];*/

            $structure[$parts[0]][$parts[1]][$parts[2]] = $config;
        }

        return $structure;
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
        /*$connection->insert($tableName, [
            'namespace' => 'Agere\\Payment\\Model\\Payment',
            'mnemo' => 'payment',
            'hidden' => 0,
            //'moduleId' => $paymentModule['id']
        ]);*/
    }
}