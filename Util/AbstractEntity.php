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

use DomainCoder\Metamodel\Code\Element\Annotation\AnnotatableInterface;
use DomainCoder\Metamodel\Code\Element\Annotation\AnnotatableTrait;
use DomainCoder\Metamodel\Code\Element\Source;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Entity\Operation\EquatableInterface;

abstract class AbstractEntity implements EntityInterface, AnnotatableInterface, EquatableInterface
{
    use AnnotatableTrait {
        AnnotatableTrait::initialize as a_init;
    }

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $comment;

    /**
     * @var Source
     */
    public $source;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->source = new Source('', 0, 0);

        $this->a_init();
    }

    /**
     * @param $name
     * @return bool
     */
    public function isName($name)
    {
        return $this->name === $name;
    }

    /**
     * @inheritdoc
     */
    public function equals(EntityInterface $target)
    {
        return $this->id === $target->id;
    }

    /**
     * @return Source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param $path
     * @param $line
     * @param $col
     */
    public function setSource($path, $line, $col)
    {
        $this->source->relativePath = $path;
        $this->source->line = $line;
        $this->source->col = $col;
    }
}
