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

use DomainCoder\Metamodel\Code\Element\ClassModel;
use DomainCoder\Metamodel\Code\Util\AbstractCollection;
use PHPMentors\DomainKata\Entity\EntityInterface;

class ClassCollection extends AbstractCollection
{
    /**
     * @param $name
     * @return ClassCollection
     */
    public function findByAnnotationName($name)
    {
        return new ClassCollection($this->filter(function (ClassModel $class) use ($name) {
            $annots = $class->annotations->withName($name);
            return $annots->count() > 0;
        }));
    }

    /**
     * @param $keyword
     * @return ClassCollection
     */
    public function findByComment($keyword)
    {
        return new ClassCollection($this->filter(function (ClassModel $class) use ($keyword) {
            return strpos($class->comment, $keyword) !== false;
        }));
    }

    /**
     * @inheritdoc
     */
    public function add(EntityInterface $entity)
    {
        /** @var ClassModel $entity */
        $this->_data[$entity->getFQCN()] = $entity;
    }
}
