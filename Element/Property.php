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

use DomainCoder\Metamodel\Code\Element\Reference\ReferenceableInterface;
use DomainCoder\Metamodel\Code\Util\AbstractEntity;

class Property extends AbstractEntity implements ReferenceableInterface
{
    /**
     * @var string
     */
    private $dataType;

    /**
     * @var string
     */
    private $accessModifier;

    /**
     * @var Reference
     */
    public $reference;
    /**
     * @var ClassModel
     */
    private $class;

    public function __construct($id, $name, $dataType, $accessModifier, ClassModel $class)
    {
        parent::__construct($id, $name);
        $this->dataType = $dataType;
        $this->accessModifier = $accessModifier;
        $this->class = $class;
        $this->reference = null;
    }

    /**
     * @return string
     */
    public function getFQN()
    {
        return sprintf('%s:%s', $this->class->getFQCN(), $this->name);
    }

    /**
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @param string $dataType
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * @return string
     */
    public function getAccessModifier()
    {
        return $this->accessModifier;
    }

    /**
     * @param string $accessModifier
     */
    public function setAccessModifier($accessModifier)
    {
        $this->accessModifier = $accessModifier;
    }

    /**
     * @return Reference|null
     */
    public function getReference()
    {
        return $this->reference;
    }
}
