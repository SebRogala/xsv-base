<?php
/**
 * @author SebRogala <sebrogala@gmail.com>
 * @copyright Copyright (c) 2016 SebRogala All Right Reserved (sebrogala.com)
 * @license proprietary (see LICENSE.md file of this package)
 */

namespace XsvTest\Base\Factory\BodyParams\Strategy;

use Zend\Diactoros\ServerRequest;
use Psr\Http\Message\StreamInterface;
use Xsv\Base\Factory\BodyParams\Strategy\FormUrlEncodedWithMethodStrategy;

class FormUrlEncodedWithMethodStrategyTest extends \PHPUnit_Framework_TestCase
{
    protected $strategy;

    public function setUp()
    {
        $this->strategy = new FormUrlEncodedWithMethodStrategy();
    }

    public function testPostMethodReturnsSameRequest()
    {
        $body = 'foo=bar';
        $stream = $this->prophesize(StreamInterface::class);
        $stream->getContents()->willReturn($body);

        $request = new ServerRequest([], [], '', 'POST');
        $request = $request->withBody($stream->reveal());

        $this->assertSame($request, $this->strategy->parse($request));
    }

    public function testPutReturnsParsedBodyAsArray()
    {
        $expectedBody = ["foo" => "bar"];
        $body = 'foo=bar';
        $stream = $this->prophesize(StreamInterface::class);
        $stream->getContents()->willReturn($body);

        $request = new ServerRequest([], [], '', 'PUT');
        $request = $request->withBody($stream->reveal());

        $this->assertSame($expectedBody, $this->strategy->parse($request)->getParsedBody());
    }
}
