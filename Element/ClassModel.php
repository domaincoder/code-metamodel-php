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

namespace DomainCoder\Metamodel\Code\Element;

use DomainCoder\Metamodel\Code\Element\Method\MethodCollection;
use DomainCoder\Metamodel\Code\Element\Property\PropertyCollection;
use DomainCoder\Metamodel\Code\Element\Reference\ReferenceCollection;
use DomainCoder\Metamodel\Code\Util\AbstractEntity;

class ClassModel extends AbstractEntity
{
    /**
     * @var string
     */
    public $namespace;

    /**
     * @var PropertyCollection
     */
    public $properties;

    /**
     * @var MethodCollection
     */
    public $methods;

    /**
     * @var ReferenceCollection
     */
    public $references;

    public function __construct($id, $name)
    {
        parent::__construct($id, $name);
        $this->properties = new PropertyCollection();
        $this->methods = new MethodCollection();
        $this->references = new ReferenceCollection();
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        // strip trailing slash
        $namespace = preg_replace('/(^.*)(\/?)$/', '$1', $namespace);

        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    public function getFQCN()
    {
        return $this->namespace . '\\' . $this->name;
    }
}
