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

namespace DomainCoder\Metamodel\Code\Util;

use PHPMentors\DomainKata\Entity\EntityCollectionInterface;
use PHPMentors\DomainKata\Entity\EntityInterface;
use Functional as F;

abstract class AbstractCollection implements EntityCollectionInterface, \ArrayAccess
{
    protected $map;

    public function __construct($data = null)
    {
        if ($data === null) {
            $data = [];
        }
        $this->map = $data;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->map);
    }

    /**
     * @inheritdoc
     */
    public function add(EntityInterface $entity)
    {
        $this->map[$entity->id] = $entity;
    }

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        return $this->map[$key];
    }

    /**
     * @inheritdoc
     */
    public function remove(EntityInterface $entity)
    {
        unset($this->map[$entity->id]);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->map);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return count($this->map) === 0;
    }

    /**
     * @param callable $f
     * @return array
     */
    public function filter(\Closure $f)
    {
        return F\select($this->map, $f);
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return F\first($this->map);
    }

    /**
     * @param $initial
     * @param $f
     * @return array
     */
    public function reduce($initial, $f)
    {
        return F\reduce_left($this->map, $f, $initial);
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        $size = count($this->map);
        return (0 <= $offset && $offset < $size);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        $temp = array_values($this->map);
        return $temp[$offset];
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public function offsetSet($offset, $value)
    {
        throw new \RuntimeException();
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public function offsetUnset($offset)
    {
        throw new \RuntimeException();
    }
}
