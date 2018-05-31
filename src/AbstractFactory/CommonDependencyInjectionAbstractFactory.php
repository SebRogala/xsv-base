<?php
/**
 * Author: Sebastian Rogala
 * Mail: sebrogala@gmail.com
 * Created: 31.05.18
 */

namespace Xsv\Base\AbstractFactory;

use Interop\Container\ContainerInterface;
use ReflectionClass;
use Xsv\Base\Service\AppConfigService;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class CommonDependencyInjectionAbstractFactory implements AbstractFactoryInterface
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
        $canCreateConfig = $container->get(AppConfigService::class)->getConfig('can-create');

        for($i = 1; $i <= $canCreateConfig['search-max-depth']; $i++) {
            $re = '/(?:[A-Z][a-z]*){' . $i . '}$/m';
            preg_match_all($re, $requestedName, $matches, PREG_SET_ORDER, 0);
            if(!empty($matches) && in_array($matches[0][0], $canCreateConfig['abstract-factory'])) {
                return true;
            }
        }

        return false;
    }
}
