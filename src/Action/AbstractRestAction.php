<?php
/**
 * @author SebRogala <sebrogala@gmail.com>
 * @copyright Copyright (c) 2016 SebRogala All Right Reserved (sebrogala.com)
 * @license proprietary (see LICENSE.md file of this package)
 */

namespace App\Action;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\InputFilter\InputFilterInterface;

abstract class AbstractRestAction
{
    /**
     * Returns new JsonResponse with 422 status code for invalid form
     *
     * @param InputFilterInterface $inputFilter
     * @return mixed
     */
    protected function validationErrorResponse(
        InputFilterInterface $inputFilter
    ){
        $errors = $inputFilter->getMessages();
        return new JsonResponse($errors, 422);
    }

    /**
     * Checks for validation of passed InputFilter and data
     *
     * @param InputFilterInterface $inputFilter
     * @param array $data
     * @return bool
     */
    protected function dataNotValid(InputFilterInterface $inputFilter, array $data)
    {
        $inputFilter->setData($data);
        return !$inputFilter->isValid();
    }

    protected function getParsedBody(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();
        if(empty($data)) {
            $data = [];
        }

        return $data;
    }
}