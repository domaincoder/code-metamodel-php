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

namespace DomainCoder\Metamodel\Code\Element\Method;

use DomainCoder\Metamodel\Code\Element;
use DomainCoder\Metamodel\Code\Util\Model;

class MethodFactory
{
    /**
     * @var Model
     */
    private $model;

    public function __construct(Model $model = null)
    {
        $this->model = $model;
    }

    public function create($name, Element\ClassModel $class)
    {
        $method = new Element\Method($name, $name, 'public', $class);
        $class->methods->add($method);

        if ($this->model) {
            $this->model->methodCollection->add($method);
        }

        return $method;
    }
}
