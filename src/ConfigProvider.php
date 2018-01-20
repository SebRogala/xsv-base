<?php
/**
 * @author SebRogala <sebrogala@gmail.com>
 * @copyright Copyright (c) 2016 SebRogala All Right Reserved (sebrogala.com)
 * @license proprietary (see LICENSE.md file of this package)
 */

namespace Xsv\Base;

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
            'abstract_factories' => [
                Action\AbstractActionFactory::class,
                InputFilter\AbstractInputFilterFactory::class,
            ],
        ];
    }

}
