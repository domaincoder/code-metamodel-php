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
use PHPMentors\DomainKata\Entity\EntityInterface;

class Annotation extends AbstractEntity implements EntityInterface
{
    /**
     * @var mixed
     */
    public $parameters;

    public function __construct($id, $name)
    {
        parent::__construct($id, $name);
        $this->parameters = null;
    }

    /**
     * @param $name
     * @return bool
     */
    public function isName($name)
    {
        return strtolower($this->name) === strtolower($name);
    }
}