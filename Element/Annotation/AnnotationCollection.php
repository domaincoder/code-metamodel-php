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

namespace DomainCoder\Metamodel\Code\Element\Annotation;

use DomainCoder\Metamodel\Code\Element\Annotation;
use DomainCoder\Metamodel\Code\Util\AbstractCollection;

class AnnotationCollection extends AbstractCollection
{
    /**
     * @param $name
     * @return AnnotationCollection
     */
    public function withName($name)
    {
        return new AnnotationCollection($this->filter(function (Annotation $annotation) use ($name) {
            return $annotation->isName($name);
        }));
    }
}
