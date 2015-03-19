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

use DomainCoder\Metamodel\Code\Util\AbstractEntity;

class Reference extends AbstractEntity
{
    /**
     * @var string
     */
    public $alias;

    /**
     * @var ClassModel
     */
    public $targetClass;

    public function __construct($id, $name, ClassModel $targetClass = null)
    {
        parent::__construct($id, $name);
        $this->alias = substr($name, strrpos($name, '\\') + 1);
        $this->targetClass = $targetClass;
    }
}
