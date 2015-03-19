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
use DomainCoder\Metamodel\Code\Element\Property\PropertyFactory;
use PhpParser\Node;
use PhpParser\Node\Stmt\Property;

class PropertyParser
{
    /**
     * @var PropertyFactory
     */
    private $propertyFactory;

    public function __construct(PropertyFactory $propertyFactory)
    {
        $this->propertyFactory = $propertyFactory;
    }

    /**
     * @param $stmt
     * @return bool
     */
    public function match(Node $stmt)
    {
        return $stmt instanceof Property;
    }

    /**
     * @param $propertyStmt
     * @param Element\ClassModel $class
     * @return Element\Property
     */
    public function parse(Node $propertyStmt, Element\ClassModel $class)
    {
        // TODO get datatype and access modifier
        return $this->propertyFactory->create($propertyStmt->name, null, null, $class);
    }
}
