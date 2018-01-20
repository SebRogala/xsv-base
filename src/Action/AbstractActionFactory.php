<?php
/**
 * Created: 06.07.2017
 */

namespace Xsv\Base\Action;

use Interop\Container\ContainerInterface;
use ReflectionClass;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class AbstractActionFactory implements AbstractFactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $reflection = new ReflectionClass($requestedName);
        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            return new $requestedName;
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];
	    foreach ($parameters as $parameter) {
		    $class = $parameter->getClass();
		    $dependencies[] = $container->get($class->getName());
	    }

        return $reflection->newInstanceArgs($dependencies);
    }

    public function canCreate(ContainerInterface $container, $requestedName)
    {
        if (substr($requestedName, -6) == 'Action') {
            return true;
        }

        return false;
    }
}
