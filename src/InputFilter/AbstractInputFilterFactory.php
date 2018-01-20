<?php
/**
 * Created: 06.07.2017
 */

namespace App\InputFilter;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class AbstractInputFilterFactory implements AbstractFactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName;
    }

    public function canCreate(ContainerInterface $container, $requestedName)
    {
        if (substr($requestedName, -11) == 'InputFilter') {
            return true;
        }

        return false;
    }
}
