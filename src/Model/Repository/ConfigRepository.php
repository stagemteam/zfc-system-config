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

namespace Stagem\ZfcSystem\Config\Model\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\NativeQuery;

class ConfigRepository extends EntityRepository
{
    protected $table = 'config_data';
    protected $alias = 'config';

    /**
     * @return NativeQuery
     */
    public function findConfig()
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult($this->getEntityName(), $this->alias);
        $rsm->addFieldResult($this->alias, 'id', 'id');
        $rsm->addFieldResult($this->alias, 'scope', 'scope');
        $rsm->addFieldResult($this->alias, 'path', 'path');
        $rsm->addFieldResult($this->alias, 'value', 'value');

        $query = $this->_em->createNativeQuery(
            "SELECT {$this->alias}.`id`, {$this->alias}.`scope`, {$this->alias}.`path`, {$this->alias}.`value`
			FROM `{$this->table}` {$this->alias}",
            $rsm
        );

        //$query = $this->setParametersByArray($query, [$target, $entityId, $type]);

        return $query->getResult();
        //return $query;
    }
}