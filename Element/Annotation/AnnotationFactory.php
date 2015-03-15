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

use DomainCoder\Metamodel\Code\Element;

class AnnotationFactory
{
    public function create($name, $parameters, $target)
    {
        if (!($target instanceof Element\Annotation\AnnotatableInterface)) {
            throw new \RuntimeException('Invalid target for annotation: ' . $target->name);
        }

        $annoation = new Element\Annotation($name, $name);
        $annoation->parameters = $parameters;

        $target->addAnnotation($annoation);

        return $annoation;
    }
}