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

namespace DomainCoder\Metamodel\Code\Element\Property;

use DomainCoder\Metamodel\Code\Element\Property;
use DomainCoder\Metamodel\Code\Util\AbstractCollection;
use PHPMentors\DomainKata\Entity\EntityInterface;

class PropertyCollection extends AbstractCollection
{
    /**
     * @param $name
     * @return PropertyCollection
     */
    public function findByAnnotationName($name)
    {
        return new PropertyCollection($this->filter(function (Property $property) use ($name) {
            $annots = $property->annotations->findByName($name);
            return $annots->count() > 0;
        }));
    }

    /**
     * @param $keyword
     * @return PropertyCollection
     */
    public function findByComment($keyword)
    {
        return new PropertyCollection($this->filter(function (Property $property) use ($keyword) {
            return strpos($property->comment, $keyword) !== false;
        }));
    }

    /**
     * @inheritdoc
     */
    public function add(EntityInterface $entity)
    {
        /** @var Property $entity */
        $this->_data[$entity->getFQN()] = $entity;
    }
}
