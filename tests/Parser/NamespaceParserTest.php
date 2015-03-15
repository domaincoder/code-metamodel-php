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

namespace DomainCoder\Metamodel\Code\Parser;

use DomainCoder\Metamodel\Code\Element\ClassModel;
use DomainCoder\Metamodel\Code\Element\Reference;
use DomainCoder\Metamodel\Code\Element\Reference\ReferenceFactory;

class NamespaceParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NamespaceParser
     */
    private $parser;

    /**
     * @var ClassParser
     */
    private $classParser;

    /**
     * @var ReferenceFactory
     */
    private $referenceFactory;

    protected function setUp()
    {
        $this->classParser = \Phake::mock(ClassParser::class);
        $this->referenceFactory = \Phake::mock(ReferenceFactory::class);

        $this->parser = new NamespaceParser($this->classParser, $this->referenceFactory);
    }

    /**
     * @test
     */
    public function parseNormal()
    {
        $stmts = include __DIR__.'/../fixtures/1/Model/Product.php.full.cache';

        $namespace = $this->parser->parse($stmts, '');

        $this->assertThat($namespace, $this->isType('string'));
        $this->assertThat($namespace, $this->equalTo('Example\Model'));
    }
}
