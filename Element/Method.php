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

class Method extends AbstractEntity
{
    /**
     * @var string
     */
    public $accessModifier;

    /**
     * @var ClassModel
     */
    public $class;

    public function __construct($id, $name, $accessModifier = 'public', ClassModel $class)
    {
        parent::__construct($id, $name);
        $this->accessModifier = $accessModifier;
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getFQN()
    {
        return sprintf('%s#%s()', $this->class->getFQCN(), $this->name);
    }
}
