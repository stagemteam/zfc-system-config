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
use ReflectionProperty;
use Stagem\ZfcSystem\Config\Model\Repository\ConfigRepository;
use Stagem\ZfcSystem\Config\SysConfig;

class SysConfigTest extends MockeryTestCase
{
    /** @var SysConfig */
    protected $sysConfig;

    /** @var ConfigRepository */
    protected $repositoryMock;

    public function setUp()
    {
        $this->repositoryMock = Mockery::mock(ConfigRepository::class);

        $this->sysConfig = new SysConfig($this->repositoryMock);
    }

    public function testGetConfigShouldReturnCorrectValueByPath()
    {
        $this->repositoryMock->allows()->findConfig()->andReturns([
            ['id' => 1, 'scope' => 'default', 'path' => 'default/head/title', 'value' => 'Test Title'],
            ['id' => 2, 'scope' => 'default', 'path' => 'default/banner/active', 'value' => '1'],
        ]);

        $value = $this->sysConfig->getConfig('default/head/title');
        $this->assertEquals('Test Title', $value);
    }

    public function testShouldCallNormalizeOnlyOnce()
    {
        $sysConfigMock = Mockery::mock(SysConfig::class . '[normalize]', [$this->repositoryMock]);

        $sysConfigMock->allows()->normalize()->once();

        $reflection = new ReflectionProperty($sysConfigMock, 'isNormalized');
        $reflection->setAccessible(true);

        $sysConfigMock->getConfig('default/head/title');
        $reflection->setValue($sysConfigMock, true);
        $sysConfigMock->getConfig('default/banner/active');
    }
}
