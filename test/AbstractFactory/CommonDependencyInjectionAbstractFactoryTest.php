<?php
/**
 * Author: Sebastian Rogala
 * Mail: sebrogala@gmail.com
 * Created: 31.05.18
 */

namespace XsvTest\Base\AbstractFactory;

use Interop\Container\ContainerInterface;
use Xsv\Base\AbstractFactory\CommonDependencyInjectionAbstractFactory;
use Xsv\Base\Service\AppConfigService;

class CommonDependencyInjectionAbstractFactoryTest extends \PHPUnit\Framework\TestCase
{
    private function getContainer($config) {
        $container = $this->prophesize(ContainerInterface::class);
        $appConfig = $this->prophesize(AppConfigService::class);

        $appConfig->getConfig('xsv-base', 'can-create')->willReturn($config);
        $container->get(AppConfigService::class)->willReturn($appConfig->reveal());

        return $container;
    }

    public function testCanCreateWithOneWord()
    {
        $config = [
            'search-max-depth' => 1,
            'abstract-factory' => [
                'Action',
            ],
        ];
        $container = $this->getContainer($config);
        $tested = new CommonDependencyInjectionAbstractFactory();

        $this->assertTrue($tested->canCreate($container->reveal(), 'NewHandlerAction'));

        $this->assertFalse($tested->canCreate($container->reveal(), 'NewHandlerActionOther'));
    }

    public function testCanCreateWithTwoWords()
    {
        $config = [
            'search-max-depth' => 2,
            'abstract-factory' => [
                'Action',
                'InputFilter',
                'DoctrineService',
            ],
        ];
        $container = $this->getContainer($config);
        $tested = new CommonDependencyInjectionAbstractFactory();

        $this->assertTrue($tested->canCreate($container->reveal(), 'NewHandlerInputFilter'));
        $this->assertTrue($tested->canCreate($container->reveal(), 'OtherDoctrineService'));
        $this->assertTrue($tested->canCreate($container->reveal(), 'OtherTestAction'));

        $this->assertFalse($tested->canCreate($container->reveal(), 'OtherTestActionNotFound'));
    }
}
