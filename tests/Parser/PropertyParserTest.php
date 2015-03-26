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
use DomainCoder\Metamodel\Code\Element\Property;
use DomainCoder\Metamodel\Code\Element\Property\PropertyFactory;
use DomainCoder\Metamodel\Code\Util\Model;

class PropertyParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PropertyParser
     */
    private $parser;

    /**
     * @var PropertyFactory
     */
    private $propertyFactory;

    /**
     * @var ClassModel
     */
    private $class;


    protected function setUp()
    {
        $model = new Model();
        $this->propertyFactory = new PropertyFactory($model);
        $this->class = new ClassModel('test', 'test');

        $this->parser = new PropertyParser(
            $this->propertyFactory
        );
    }

    /**
     * @test
     */
    public function parseNormal()
    {
        $stmts = include __DIR__.'/../fixtures/1/Model/Product.php.property_base.cache';

        $property = $this->parser->parse($stmts, $this->class);

        $this->assertThat($property, $this->isInstanceOf(Property::class));
        $this->assertThat($property->name, $this->equalTo('updatedAt'));
        $this->assertThat($property->getAccessModifier(), $this->equalTo('public'));
    }
}
