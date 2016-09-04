<?php
/**
 * @author SebRogala <sebrogala@gmail.com>
 * @copyright Copyright (c) 2016 SebRogala All Right Reserved (sebrogala.com)
 * @license proprietary (see LICENSE.md file of this package)
 */

namespace Xsv\Base\Factory\BodyParams;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zend\Expressive\Helper\BodyParams\JsonStrategy;

class BodyParamsFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $bodyParams = new BodyParamsMiddleware();
        $bodyParams->clearStrategies();
        $bodyParams->addStrategy(new JsonStrategy());
        $bodyParams->addStrategy(new Strategy\FormUrlEncodedWithMethodStrategy());

        return $bodyParams;
    }
}
