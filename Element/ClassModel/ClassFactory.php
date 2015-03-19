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

namespace DomainCoder\Metamodel\Code\Element\ClassModel;

use DomainCoder\Metamodel\Code\Element;
use DomainCoder\Metamodel\Code\Util\Model;

class ClassFactory
{
    /**
     * @var Model
     */
    private $model;

    public function __construct(Model $model = null)
    {
        $this->model = $model;
    }

    public function create($name)
    {
        $class = new Element\ClassModel($name, $name);

        if ($this->model) {
            $this->model->classCollection->add($class);
        }

        return $class;
    }
}
