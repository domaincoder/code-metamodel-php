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

namespace DomainCoder\Metamodel\Code\Util;

use DomainCoder\Metamodel\Code\Element\ClassModel\ClassCollection;
use DomainCoder\Metamodel\Code\Element\Method\MethodCollection;
use DomainCoder\Metamodel\Code\Element\Property\PropertyCollection;

class Model
{
    /**
     * @var ClassCollection
     */
    public $classCollection;

    /**
     * @var MethodCollection
     */
    public $methodCollection;

    /**
     * @var PropertyCollection
     */
    public $propertyCollection;

    public function __construct()
    {
        $this->classCollection = new ClassCollection();
        $this->methodCollection = new MethodCollection();
        $this->propertyCollection = new PropertyCollection();
    }
}
