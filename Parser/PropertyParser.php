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
use PhpParser\Node\Stmt;
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
     * @param Stmt $stmt
     * @return bool
     */
    public function match(Stmt $stmt)
    {
        return $stmt instanceof Property;
    }

    /**
     * @param Stmt $propertyStmt
     * @param Element\ClassModel $class
     * @return Element\Property
     */
    public function parse(Stmt $propertyStmt, Element\ClassModel $class)
    {
        // get datatype and access modifier
        return $this->propertyFactory->create($propertyStmt->name, null, null, $class);
    }
}
