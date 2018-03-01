<?php
/**
 * @category Stagem
 * @package Stagem_ZfcSystem
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @datetime: 19.12.15 17:44
 */

namespace StagemTest\ZfcSystem\Config;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery;
use Stagem\ZfcSystem\Config\SysConfig;

class SysConfigTest extends MockeryTestCase
{
    /** @var SysConfig */
    protected $sysConfig;

    public function setUp()
    {
        $this->sysConfig = Mockery::mock(SysConfig::class);
    }

    public function testGetConfigShouldReturnCorrectValueByPath()
    {
        $this->sysConfig->allows()->fetchConfig()->andReturns([
            ['id' => 1, 'scope' => 'default', 'path' => 'default/head/title', 'value' => 'Test Title'],
            ['id' => 2, 'scope' => 'default', 'path' => 'default/banner/active', 'value' => '1'],
        ]);

        $value = $this->sysConfig->getConfig('default/head/title');
        //$this->assertEquals('Test Title', $value);
    }
}
