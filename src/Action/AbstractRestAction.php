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

use App\Entity;
use Doctrine\ORM\PersistentCollection;
use User\DomainShared\Entity\User;
use Xsv\Translate\Translator\Translator;

abstract class AbstractRestAction
{
    /**
     * Returns new JsonResponse with 400 status code for invalid form
     *
     * @param mixed $errors
     * @return mixed
     */
    protected function validationErrorResponse(
        $errors
    ){
        if(is_string($errors)) {
            $errors = [$errors];
        }
        return new JsonResponse($errors, 400);
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
        $entity->removeRelationsAndCollection();

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

            if($value instanceof User) {
                $value->removePassword();
            }

            if($value instanceof Entity) {
                $array[$key] = $this->entityToArray($value);
            }
            else if($value instanceof PersistentCollection || is_array($value)) {
                $a = [];
                foreach((array)$array[$key] as $itemFromCollection) {
                    $a[] = $this->entityToArray($itemFromCollection);
                }
                $array[$key] = $a;
            }
            else if(in_array($key, $entityTranslationKeys))
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

        foreach ((array)$entity as $namespacedKey => $value) {
            preg_match_all($re, $namespacedKey, $matches);
            $key = $matches[0][0];

            if($value instanceof User) {
                $value->removePassword();
            }

            if($value instanceof Entity) {
                $array[$key] = $this->entityToArray($value);
            }
            else if($value instanceof PersistentCollection || is_array($value)) {
                $a = [];
                foreach($value as $itemFromCollection) {
                    $a[] = $this->entityToArray($itemFromCollection);
                }
                $array[$key] = $a;
            }
            else {
                $array[$key] = $value;
            }
        }

        return $array;
    }
}