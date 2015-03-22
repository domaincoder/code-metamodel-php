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
use DomainCoder\Metamodel\Code\Element\Reference\ReferenceFactory;
use PhpParser\Node\Stmt;

class PropertyAnnotationsParser
{
    /**
     * @var ReferenceFactory
     */
    private $referenceFactory;
    /**
     * @var CommentsParser
     */
    private $commentsParser;

    public function __construct(ReferenceFactory $referenceFactory, CommentsParser $commentsParser)
    {
        $this->referenceFactory = $referenceFactory;
        $this->commentsParser = $commentsParser;
    }

    /**
     * @param Stmt $propertyStmt
     * @param Element\Property $property
     * @param Element\ClassModel $class
     * @return Element\Annotation\AnnotationCollection
     */
    public function parse(Stmt $propertyStmt, Element\Property $property, Element\ClassModel $class)
    {
        // annotation
        $attrs = $propertyStmt->getAttributes();
        $this->commentsParser->parse($attrs, $property);

        $vars = $property->annotations->withName('var');
        if ($vars->count()) {
            /** @var Element\Annotation $var */
            $var = $vars->first();

            if (!is_array($var->parameters)) {
                // classのuseにあるものだけにする（FQCN形式等は要検討）
                //  型が単純なクラス名ではなくて Element\Annotation のような形式になっている場合は、Element 部分が use にあればOK
                if ($searchAlias = strstr($var->parameters, '\\', true) === false) {
                    $searchAlias = $var->parameters;
                }

                $classReferences = $class->references->withAlias($searchAlias);
                if ($classReferences->count()) {
                    $ref = $this->referenceFactory->create($var->parameters, null);
                    $property->reference = $ref;
                }
            }
        }

        return $property->annotations;
    }
}
