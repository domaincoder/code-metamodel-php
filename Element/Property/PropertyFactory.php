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

namespace DomainCoder\Metamodel\Code\Element\Property;

use DomainCoder\Metamodel\Code\Element;
use DomainCoder\Metamodel\Code\Util\Model;

class PropertyFactory
{
    /**
     * @var Model
     */
    private $model;

    public function __construct(Model $model = null)
    {
        $this->model = $model;
    }

    /**
     * @param $name
     * @param $dataType
     * @param $accessModifier
     * @param Element\ClassModel $class
     * @return Element\Property
     */
    public function create($name, $dataType, $accessModifier, Element\ClassModel $class)
    {
        $property = new Element\Property($name, $name, $dataType, $accessModifier, $class);
        $class->properties->add($property);

        if ($this->model) {
            $this->model->propertyCollection->add($property);
        }

        return $property;
    }
}
