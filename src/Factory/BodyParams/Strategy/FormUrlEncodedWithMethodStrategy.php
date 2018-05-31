<?php
/**
 * @author SebRogala <sebrogala@gmail.com>
 * @copyright Copyright (c) 2016 SebRogala All Right Reserved (sebrogala.com)
 * @license proprietary (see LICENSE.md file of this package)
 */

namespace Xsv\Base\Factory\BodyParams\Strategy;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Helper\BodyParams\StrategyInterface;
use Zend\Expressive\Helper\BodyParams\FormUrlEncodedStrategy;

class FormUrlEncodedWithMethodStrategy extends FormUrlEncodedStrategy implements StrategyInterface
{
    /**
     * {@inheritDoc}
     */
    public function parse(ServerRequestInterface $request): ServerRequestInterface
    {
        if ($request->getMethod() == "PUT") {
            parse_str($request->getBody()->getContents(), $data);

            return $request->withParsedBody($data);
        }

        return $request;
    }
}
