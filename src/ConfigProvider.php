<?php
/**
 * @author SebRogala <sebrogala@gmail.com>
 * @copyright Copyright (c) 2016 SebRogala All Right Reserved (sebrogala.com)
 * @license proprietary (see LICENSE.md file of this package)
 */

namespace Xsv\Base;

use Xsv\Base\Factory\AppConfigFactory;
use Xsv\Base\Service\AppConfig;

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
                AppConfig::class => AppConfigFactory::class,
            ],
            'abstract_factories' => [
                Action\AbstractActionFactory::class,
                InputFilter\AbstractInputFilterFactory::class,
            ],
        ];
    }

}
