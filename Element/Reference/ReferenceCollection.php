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

namespace DomainCoder\Metamodel\Code\Element\Reference;

use DomainCoder\Metamodel\Code\Element\Reference;
use DomainCoder\Metamodel\Code\Util\AbstractCollection;

class ReferenceCollection extends AbstractCollection
{
    public function findByAlias($name)
    {
        return new ReferenceCollection($this->filter(function (Reference $reference) use ($name) {
            return $reference->alias === $name;
        }));
    }
}
