<?php
/*
 * Copyright (c) 2015 GOTO Hidenori <hidenorigoto@gmail.com>,
 * All rights reserved.
 *
 * This file is part of CodeMetamodel-PHP.
 *
 * This program and the accompanying materials are made available under
 * the terms of the BSD 2-Clause License which accompanies this
 * distribution, and is available at http://opensource.org/licenses/BSD-2-Clause
 */

namespace DomainCoder\Metamodel\Code\Parser;

use DomainCoder\Metamodel\Code\Element;
use DomainCoder\Metamodel\Code\Element\Annotation\AnnotationFactory;
use DomainCoder\Metamodel\Code\Element\Reference\ReferenceFactory;
use DomainCoder\Metamodel\Code\Util\Model;

class PropertyAnnotationsParser
{
    public static $STANDARD_ANNOTATIONS = ['@var', '@param', '@return'];

    /**
     * @var Model
     */
    private $model;

    /**
     * @var AnnotationFactory
     */
    private $annotationFactory;

    /**
     * @var ReferenceFactory
     */
    private $referenceFactory;
    /**
     * @var CommentsParser
     */
    private $commentsParser;

    public function __construct(Model $model, ReferenceFactory $referenceFactory, CommentsParser $commentsParser)
    {
        $this->model = $model;
        $this->referenceFactory = $referenceFactory;
        $this->commentsParser = $commentsParser;
    }

    /**
     * @param $propertyStmt
     * @param Element\Property $property
     * @param Element\ClassModel $class
     * @return Element\Annotation\AnnotationCollection
     */
    public function parse($propertyStmt, Element\Property $property, Element\ClassModel $class)
    {
        // annotation
        $attrs = $propertyStmt->getAttributes();

        $this->commentsParser->parse($attrs, $property);

        $vars = $property->annotations->findByName('var');
        if ($vars->count()) {
            /** @var Element\Annotation $var */
            $var = $vars->first();

            if (!is_array($var->parameters)) {
                // TODO classのuseにあるものだけにする　（FQCN形式等は要検討）
                //  型が単純なクラス名ではなくて Element\Annotation のような形式になっている場合は、Element 部分が use にあればOK
                if ($searchAlias = strstr($var->parameters, '\\', true) === false) {
                    $searchAlias = $var->parameters;
                }

                $classReferences = $class->references->findByAlias($searchAlias);
                if ($classReferences->count()) {
                    $ref = $this->referenceFactory->create($var->parameters, null);
                    $property->reference = $ref;
                }
            }
        }

        return $property->annotations;
    }

    /**
     * @param $text
     * @return bool
     */
    private function containsStandardAnnotation($text)
    {
        return preg_match('/' . implode('|', self::$STANDARD_ANNOTATIONS) . '/', $text);
    }

    /**
     * @param $text
     * @return mixed
     */
    private function extractStandardAnnotations($text)
    {
        preg_match_all('/(' . implode('|', self::$STANDARD_ANNOTATIONS) . ')(\s*)([^@\s*]*)/', $text, $matches, PREG_SET_ORDER);

        $ret = [];
        foreach ($matches as $match) {
            if (is_array($match)) {
                $param = trim($match[3]);
                if ($param) {
                    $ret[] = ['name' => str_replace('@', '', $match[1]), 'parameter' => $match[3]];
                }
            } else {
                //$ret[] = ['name' => str_replace('@', '', $match[1]), 'parameter' => null];
            }
        }

        return $ret;
    }
}
