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

use DomainCoder\Metamodel\Code\Element\Source;

class DummyEntity extends AbstractEntity
{
};

class AbstractEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DummyEntity
     */
    private $dummy;

    protected function setUp()
    {
        $this->dummy = new DummyEntity('test', 'test');
    }

    /**
     * @test
     */
    public function instancing()
    {
        $this->assertThat($this->dummy, $this->isInstanceOf(AbstractEntity::class));
    }

    /**
     * @test
     */
    public function isName()
    {
        $this->assertThat($this->dummy->isName('test'), $this->equalTo(true));
        $this->assertThat($this->dummy->isName('foo'), $this->equalTo(false));
    }

    /**
     * @test
     */
    public function equals()
    {
        $same = new DummyEntity('test', 'test1name');
        $other = new DummyEntity('test2', 'test2name');

        $this->assertThat($this->dummy->equals($same), $this->equalTo(true));
        $this->assertThat($this->dummy->equals($other), $this->equalTo(false));
    }

    /**
     * @test
     */
    public function source()
    {
        $this->dummy->setSource('source', 1, 2);
        $source = $this->dummy->getSource();

        $this->assertThat($source, $this->isInstanceOf(Source::class));
        $this->assertThat($source->relativePath, $this->equalTo('source'));
        $this->assertThat($source->line, $this->equalTo(1));
        $this->assertThat($source->col, $this->equalTo(2));
    }
}
