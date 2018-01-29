<?php
/**
 * Author: Sebastian Rogala
 * Mail: sebrogala@gmail.com
 * Created: 29.01.18
 */

namespace Xsv\Base\Factory;

use Interop\Container\ContainerInterface;
use Xsv\Base\Service\AppConfig;
use Zend\ServiceManager\Factory\FactoryInterface;

class AppConfigFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        return new AppConfig($container->get('config'));
    }
}
