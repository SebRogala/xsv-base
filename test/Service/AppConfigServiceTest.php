<?php
/**
 * Author: Sebastian Rogala
 * Mail: sebrogala@gmail.com
 * Created: 03.07.18
 */

namespace XsvTest\Base\Service;

use Xsv\Base\Service\AppConfigService;
use PHPUnit\Framework\TestCase;

class AppConfigServiceTest extends TestCase
{
    /** @var array */
    private $config;

    /** @var AppConfigService */
    private $appConfigService;

    public function setUp()
    {
        $this->config = [
            'xsv-base' => [
                'can-create' => [
                    'search-max-depth' => 1,
                    'abstract-factory' => [
                        'Action',
                        'Reaction',
                    ],
                ],
            ],
        ];

        $this->appConfigService = new AppConfigService($this->config);
    }

    public function testReturnsInitialConfigWithProvidedZeroArguments()
    {
        $this->assertSame($this->config, $this->appConfigService->getConfig());
    }

    public function testReturnsOneDepthLevelConfig()
    {
        $key = "xsv-base";
        $expected = $this->config[$key];

        $actual = $this->appConfigService->getConfig($key);

        $this->assertSame($expected, $actual);
    }

    public function testReturnTwoDepthLevelConfig()
    {
        $keyOne = "xsv-base";
        $keyTwo = "can-create";
        $expected = $this->config[$keyOne][$keyTwo];

        $actual = $this->appConfigService->getConfig($keyOne, $keyTwo);

        $this->assertSame($expected, $actual);
    }

    public function testReturnEmptyArrayIfNotExistingKeyUsed()
    {
        $this->assertSame([], $this->appConfigService->getConfig('not-exists'));
    }
}
