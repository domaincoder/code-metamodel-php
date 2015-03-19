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

use DomainCoder\Metamodel\Code\Element\Method;
use DomainCoder\Metamodel\Code\Util\AbstractCollection;
use PHPMentors\DomainKata\Entity\EntityInterface;

class MethodCollection extends AbstractCollection
{
    /**
     * @param $name
     * @return MethodCollection
     */
    public function findByAnnotationName($name)
    {
        return new MethodCollection($this->filter(function ($method) use ($name) {
            /** @var Method $method */
            $annots = $method->annotations->findByName($name);
            return $annots->count() > 0;
        }));
    }

    /**
     * @param $keyword
     * @return MethodCollection
     */
    public function findByComment($keyword)
    {
        return new MethodCollection($this->filter(function ($method) use ($keyword) {
            /** @var Method $method */
            return strpos($method->comment, $keyword) !== false;
        }));
    }

    /**
     * @inheritdoc
     */
    public function add(EntityInterface $entity)
    {
        /** @var Method $entity */
        $this->map[$entity->getFQN()] = $entity;
    }
}
