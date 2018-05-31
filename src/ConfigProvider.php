<?php
/**
 * @author SebRogala <sebrogala@gmail.com>
 * @copyright Copyright (c) 2016 SebRogala All Right Reserved (sebrogala.com)
 * @license proprietary (see LICENSE.md file of this package)
 */

namespace Xsv\Base;

use Xsv\Base\AbstractFactory\CommonDependencyInjectionAbstractFactory;
use Xsv\Base\Service\AppConfigServiceFactory;
use Xsv\Base\Service\AppConfigService;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies()
    {
        return [
            'factories' => [
                AppConfigService::class => AppConfigServiceFactory::class,
            ],
            'abstract_factories' => [
                CommonDependencyInjectionAbstractFactory::class
            ],
        ];
    }
}
