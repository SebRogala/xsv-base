<?php
/**
 * @author SebRogala <sebrogala@gmail.com>
 * @copyright Copyright (c) 2016 SebRogala All Right Reserved (sebrogala.com)
 * @license proprietary (see LICENSE.md file of this package)
 */

namespace Xsv\Base\Action;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\InputFilter\InputFilterInterface;

use Xsv\Translate\Translator\Translator;

abstract class AbstractRestAction
{
    /**
     * Returns new JsonResponse with 422 status code for invalid form
     *
     * @param array $errors
     * @return mixed
     */
    protected function validationErrorResponse(
        array $errors
    ){
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

    protected function entityToArray($entity)
    {
        if(!class_exists(Translator::class)) {
            return $this->untranslatedEntityToArray($entity);
        }

        $translationKeys = Translator::getTranslationKeys();
        $re = '/([\w]+)$/m';
        preg_match_all($re, get_class($entity), $matchedKey);
        $entityName = $matchedKey[0][0];

        if(!key_exists($entityName, $translationKeys)) {
            return $this->untranslatedEntityToArray($entity);
        }

        $entityTranslationKeys = $translationKeys[$entityName];
        $array = [];

        foreach ((array)$entity as $namespacedKey => $value) {
            preg_match_all($re, $namespacedKey, $matches);
            $key = $matches[0][0];

            if(in_array($key, $entityTranslationKeys))
            {
                $array[$key] = Translator::translate($entityName . "." . $key, $entity->getId(), $value);
            }
            else
            {
                $array[$key] = $value;
            }
        }

        return $array;
    }

    private function untranslatedEntityToArray($entity)
    {
        $array = [];

        $re = '/([\w]+)$/m';

        foreach ((array)$entity as $key => $value) {
            preg_match_all($re, $key, $matches);
            $array[$matches[0][0]] = $value;
        }

        return $array;
    }
}