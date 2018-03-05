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
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class ConfigRepository extends EntityRepository
{
    protected $table = 'config_data';
    protected $alias = 'config';

    public function findConfig()
    {
        $rsm = new ResultSetMappingBuilder($this->_em);

        $rsm->addScalarResult('id', 'id', 'integer'); // select name -> field name
        $rsm->addScalarResult('scope', 'scope');
        $rsm->addScalarResult('path', 'path');
        $rsm->addScalarResult('value', 'value');

        $sql = <<<SQL
SELECT {$this->alias}.`id`, {$this->alias}.`scope`, {$this->alias}.`path`, {$this->alias}.`value` FROM `{$this->table}` {$this->alias}
SQL;

        $query = $this->_em->createNativeQuery($sql, $rsm);
        //$query->setParameters($conditions);
        $result = $query->getResult();

        return $result;

    }
}