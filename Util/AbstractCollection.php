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

abstract class AbstractCollection implements EntityCollectionInterface
{
    protected $_data;

    public function __construct($data = null)
    {
        if ($data === null) {
            $data = [];
        }
        $this->_data = $data;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->_data);
    }

    /**
     * @inheritdoc
     */
    public function add(EntityInterface $entity)
    {
        $this->_data[$entity->id] = $entity;
    }

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        return $this->_data[$key];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->_data;
    }

    /**
     * @inheritdoc
     */
    public function remove(EntityInterface $entity)
    {
        unset($this->_data[$entity->id]);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->_data);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return count($this->_data) === 0;
    }

    /**
     * @param callable $f
     * @return array
     */
    public function filter(\Closure $f)
    {
        return F\select($this->_data, $f);
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return F\first($this->_data);
    }

    /**
     * @param $initial
     * @param $f
     * @return array
     */
    public function reduce($initial, $f)
    {
        return F\reduce_left($this->_data, $f, $initial);
    }

    /**
     * @param $f
     * @return array
     */
    public function map($f)
    {
        return F\map($this->_data, $f);
    }
}
